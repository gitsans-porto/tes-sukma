<?php

namespace App\Http\Controllers;

use App\Models\Mutasi;
use App\Models\Penduduk;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Retrieve all mutasi data with relasi penduduk dan kartu keluarga
        // Order by created_at desc untuk memastikan record terbaru selalu di atas (row 1)
        // Menggunakan created_at lebih andal daripada tanggal_kejadian untuk sorting deterministik
        $mutasi = Mutasi::with('penduduk.kartuKeluarga')
            ->orderBy('created_at', 'desc') // Primary sorting: newest first
            ->orderBy('tanggal_kejadian', 'desc') // Secondary sorting: event date
            ->get();

        return view('mutasi.index', compact('mutasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // Get all penduduk yang masih HIDUP dan belum di-soft delete untuk dropdown
        // Filter ini penting untuk memastikan hanya penduduk aktif yang bisa dipilih untuk MENINGGAL/PINDAH
        $penduduk = Penduduk::with('kartuKeluarga')
            ->where('status', 'HIDUP')
            ->orderBy('nama')
            ->get();

        // Get all KK untuk dropdown new penduduk (LAHIR/DATANG)
        $kartuKeluarga = KartuKeluarga::orderBy('no_kk')->get();

        return view('mutasi.create', compact('penduduk', 'kartuKeluarga'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * Logic Implementation:
     * A. Case LAHIR (Birth) or DATANG (Arrival):
     *    - Create new Penduduk with status 'HIDUP'
     *    - Assign to existing or new KartuKeluarga
     * B. Case MENINGGAL (Death) or PINDAH (Moving Out):
     *    - Find existing Penduduk and update status column
     * C. Always save log record to mutasis table
     */
    public function store(Request $request)
    {
        // VALIDASI DINAMIS berdasarkan jenis mutasi
        $rules = [
            'jenis_mutasi' => 'required|in:LAHIR,MENINGGAL,DATANG,PINDAH',
            'tanggal_kejadian' => 'required|date',
            'lokasi_detail' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:1000',
        ];

        // Validasi khusus untuk LAHIR atau DATANG (perlu data penduduk baru)
        if (in_array($request->jenis_mutasi, ['LAHIR', 'DATANG'])) {
            $rules = array_merge($rules, [
                'nik' => 'required|string|size:16|unique:penduduks,nik',
                'nama' => 'required|string|max:255',
                'jenis_kelamin' => 'required|string|in:L,P', // Update: Hanya menerima L atau P
                'tempat_lahir' => 'required|string|max:255',
                'tgl_lahir' => 'required|date',
                'pekerjaan' => 'required|string|max:255',
                'hubungan_keluarga' => 'required|string|max:255',
                'tamatan' => 'required|string|max:255',
                'dusun' => 'nullable|string|max:255',
                'kartu_keluarga_id' => 'required|exists:kartu_keluarga,id',
            ]);
        }

        // Validasi khusus untuk MENINGGAL atau PINDAH (perlu penduduk yang ada)
        if (in_array($request->jenis_mutasi, ['MENINGGAL', 'PINDAH'])) {
            $rules['penduduk_id'] = 'required|exists:penduduks,id';
        }

        $request->validate($rules);

        // Gunakan DB Transaction untuk memastikan konsistensi data
        return DB::transaction(function () use ($request) {
            try {
                $pendudukId = null;

                // KASUS A: LAHIR atau DATANG - Buat penduduk baru
                if (in_array($request->jenis_mutasi, ['LAHIR', 'DATANG'])) {
                    // Generate NIK otomatis untuk kelahiran jika tidak diisi
                    $nik = $request->nik;
                    if ($request->jenis_mutasi === 'LAHIR' && empty($nik)) {
                        $nik = $this->generateNik($request->tgl_lahir, $request->jenis_kelamin);
                    }

                    // Buat data penduduk baru dengan status HIDUP
                    $penduduk = Penduduk::create([
                        'nik' => $nik,
                        'nama' => $request->nama,
                        'jenis_kelamin' => $request->jenis_kelamin,
                        'tempat_lahir' => $request->tempat_lahir,
                        'tgl_lahir' => $request->tgl_lahir,
                        'pekerjaan' => $request->pekerjaan,
                        'hubungan_keluarga' => $request->hubungan_keluarga,
                        'tamatan' => $request->tamatan,
                        'dusun' => $request->dusun,
                        'kartu_keluarga_id' => $request->kartu_keluarga_id,
                        'status' => 'HIDUP', // Status awal selalu HIDUP
                    ]);

                    $pendudukId = $penduduk->id;
                }
                // KASUS B: MENINGGAL atau PINDAH - Update status penduduk yang ada
                elseif (in_array($request->jenis_mutasi, ['MENINGGAL', 'PINDAH'])) {
                    $penduduk = Penduduk::findOrFail($request->penduduk_id);

                    if ($request->jenis_mutasi === 'MENINGGAL') {
                        // KASUS KHUSUS: MENINGGAL - Gunakan soft delete
                        // Ini akan menyembunyikan penduduk dari query normal tapi tetap mempertahankan data
                        // untuk integritas log mutasi dan keperluan audit trail
                        $penduduk->status = 'MENINGGAL'; // Update status terlebih dahulu
                        $penduduk->save();
                        $penduduk->delete(); // Soft delete: set deleted_at timestamp

                    } else {
                        // KASUS PINDAH: Update status biasa
                        $penduduk->update(['status' => 'PINDAH']);
                    }

                    $pendudukId = $penduduk->id;
                }

                // KASUS C: Selalu simpan log mutasi
                Mutasi::create([
                    'penduduk_id' => $pendudukId,
                    'jenis_mutasi' => $request->jenis_mutasi,
                    'tanggal_kejadian' => $request->tanggal_kejadian,
                    'lokasi_detail' => $request->lokasi_detail,
                    'keterangan' => $request->keterangan,
                ]);

                return redirect()->route('mutasi.index')
                    ->with('success', 'Data mutasi berhasil disimpan.');

            } catch (\Exception $e) {
                // Transaction akan otomatis rollback jika terjadi error
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        });
    }

    /**
     * Helper method untuk generate NIK otomatis (simplifikasi)
     * Catatan: Dalam implementasi nyata, NIK generation lebih kompleks
     *
     * Format NIK Indonesia: PPLKKPPDDMMYYXXXX
     * - PP: Kode provinsi (2 digit)
     * - L: Kode kabupaten/kota (2 digit)
     * - K: Kode kecamatan (3 digit)
     * - PPDDMMYY: Tanggal lahir (6 digit) - untuk wanita ditambah 40
     * - XXXX: Nomor urut (4 digit)
     */
    private function generateNik($tglLahir, $jenisKelamin)
    {
        // Untuk implementasi sederhana, gunakan format: tanggal + random 8 digit
        // Dalam implementasi nyata, perlu mengikuti format NIK Indonesia

        $datePart = date('dmy', strtotime($tglLahir));

        // Untuk perempuan, tanggal lahir ditambah 40 (standar NIK Indonesia)
        if ($jenisKelamin === 'P') {
            $tanggal = (int)date('d', strtotime($tglLahir));
            $tanggal += 40;
            $datePart = $tanggal . date('my', strtotime($tglLahir));
        }

        $randomPart = Str::padLeft(mt_rand(1, 9999), 4, '0');

        return $datePart . $randomPart;
    }

    /**
     * Display the specified resource.
     */
    public function show(Mutasi $mutasi): View
    {
        // Load mutasi dengan relasi penduduk dan kartu keluarga
        $mutasi->load('penduduk.kartuKeluarga');

        return view('mutasi.show', compact('mutasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mutasi $mutasi): View
    {
        // Get all penduduk untuk dropdown
        $penduduk = Penduduk::with('kartuKeluarga')
            ->orderBy('nama')
            ->get();

        // Load mutasi dengan relasi penduduk
        $mutasi->load('penduduk');

        return view('mutasi.edit', compact('mutasi', 'penduduk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mutasi $mutasi)
    {
        // VALIDASI
        $request->validate([
            'penduduk_id' => 'required|exists:penduduks,id',
            'jenis_mutasi' => 'required|in:LAHIR,MATI,DATANG,PINDAH',
            'tanggal_kejadian' => 'required|date',
            'lokasi_detail' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        try {
            // UPDATE DATA MUTASI
            $mutasi->update([
                'penduduk_id' => $request->penduduk_id,
                'jenis_mutasi' => $request->jenis_mutasi,
                'tanggal_kejadian' => $request->tanggal_kejadian,
                'lokasi_detail' => $request->lokasi_detail,
                'keterangan' => $request->keterangan,
            ]);

            return redirect()->route('mutasi.index')
                ->with('success', 'Data mutasi berhasil diperbarui.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mutasi $mutasi)
    {
        try {
            // Hapus data mutasi
            $mutasi->delete();

            return redirect()->route('mutasi.index')
                ->with('success', 'Data mutasi berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}

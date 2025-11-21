<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\KartuKeluarga;
use App\Models\Mutasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class PendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Retrieve all penduduk data dengan relasi kartu keluarga
        $penduduk = Penduduk::with('kartuKeluarga')
            ->orderBy('nama') // Order by nama penduduk
            ->get();

        // Group penduduk data by kartu keluarga number untuk statistik per KK
        // Peringatan: Pastikan ada pengecekan division by zero di view saat menghitung rata-rata
        $groupedPenduduk = $penduduk->groupBy('no_kk');

        // Calculate running number for display
        $no = 1;

        return view('index', compact('groupedPenduduk', 'no'));
    }

    /**
     * Helper method untuk mencatat mutasi penduduk
     */
    private function catatMutasi($pendudukId, $jenisMutasi, $keterangan = null, $lokasiDetail = null)
    {
        try {
            Mutasi::create([
                'penduduk_id' => $pendudukId,
                'jenis_mutasi' => $jenisMutasi,
                'tanggal_kejadian' => Carbon::now()->format('Y-m-d'),
                'lokasi_detail' => $lokasiDetail,
                'keterangan' => $keterangan ?? "Mutasi otomatis tercatat saat {$jenisMutasi}",
            ]);
        } catch (\Exception $e) {
            // Log error tapi tidak hentikan proses utama
            \Log::error("Gagal mencatat mutasi: " . $e->getMessage());
        }
    }

    /**
     * Helper method untuk menentukan dan mencatat mutasi penduduk baru
     */
    private function catatMutasiPendudukBaru($penduduk)
    {
        $usia = $penduduk->usia ?? $this->hitungUsia($penduduk->tgl_lahir);
        $hubungan = strtolower($penduduk->hubungan_keluarga);

        // Logika penentuan jenis mutasi
        if ($usia <= 1 && ($hubungan == 'anak' || $hubungan == 'child')) {
            // Jika usia <= 1 tahun dan hubungan anak, dianggap LAHIR
            $jenisMutasi = 'LAHIR';
            $keterangan = "Penduduk baru (kelahiran) - {$penduduk->nama}, usia {$usia} tahun";
        } else {
            // Selain itu dianggap DATANG (pendatang)
            $jenisMutasi = 'DATANG';
            $keterangan = "Penduduk baru (pendatang) - {$penduduk->nama}, {$penduduk->hubungan_keluarga}";
        }

        $this->catatMutasi($penduduk->id, $jenisMutasi, $keterangan, null);
    }

    /**
     * Helper method untuk menghitung usia berdasarkan tanggal lahir
     */
    private function hitungUsia($tanggalLahir)
    {
        return Carbon::parse($tanggalLahir)->age;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        // VALIDASI
        $request->validate([
            // Parent (KK)
            'nomor_kk' => 'required|numeric|unique:kartu_keluarga,no_kk',
            'kategori_sejahtera' => 'nullable',
            'jenis_bangunan' => 'nullable',
            'pemakaian_air' => 'nullable',
            'jenis_bantuan' => 'nullable',

            // Child (Penduduk)
            'anggota' => 'required|array|min:1',
            'anggota.*.nik' => 'required|numeric|digits:16|unique:penduduks,nik',
            'anggota.*.nama' => 'required|string|max:255',
            'anggota.*.jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan,L,P', // Accept both formats
            'anggota.*.tempat_lahir' => 'required|string|max:255',
            'anggota.*.tgl_lahir' => 'required|date',
            'anggota.*.hubungan_keluarga' => 'required|string|max:255',
            'anggota.*.tamatan' => 'required|string|max:255',
            'anggota.*.pekerjaan' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            // Debug: Log request data
            \Log::info('Penduduk Store Request Data:', [
                'kk_data' => $request->only(['nomor_kk', 'kategori_sejahtera', 'jenis_bangunan']),
                'anggota_count' => count($request->anggota ?? []),
                'first_anggota_sample' => $request->anggota[0] ?? null,
            ]);

            // SIMPAN KK
            $kkBaru = KartuKeluarga::create([
                'no_kk' => $request->nomor_kk,   // ← perbaikan penting
                'kategori_sejahtera' => $request->kategori_sejahtera,
                'jenis_bangunan' => $request->jenis_bangunan,
                'pemakaian_air' => $request->pemakaian_air,
                'jenis_bantuan' => $request->jenis_bantuan,
            ]);

            \Log::info('KK Created with ID: ' . $kkBaru->id);

            // SIMPAN ANGGOTA DAN CATAT MUTASI
            $anggotaCount = 0;
            foreach ($request->anggota as $index => $orang) {
                \Log::info("Processing anggota {$index}:", $orang);

                $pendudukBaru = Penduduk::create([
                    'kartu_keluarga_id' => $kkBaru->id,
                    'nik' => $orang['nik'],
                    'nama' => $orang['nama'],
                    'jenis_kelamin' => $orang['jenis_kelamin'],
                    'tempat_lahir' => $orang['tempat_lahir'],
                    'tgl_lahir' => $orang['tgl_lahir'],
                    'usia' => $orang['usia'] ?? null,  // aman
                    'pekerjaan' => $orang['pekerjaan'],
                    'hubungan_keluarga' => $orang['hubungan_keluarga'],
                    'tamatan' => $orang['tamatan'],
                    'status' => 'HIDUP', // Set default status untuk penduduk baru
                ]);

                \Log::info("Penduduk created with ID: " . $pendudukBaru->id);

                // CATAT MUTASI OTOMATIS
                $this->catatMutasiPendudukBaru($pendudukBaru);
                $anggotaCount++;
            }

            DB::commit();

            \Log::info("Transaction committed. Total anggota saved: {$anggotaCount}");

            return redirect()->route('penduduk.index')
                ->with('success', "Data berhasil disimpan. {$anggotaCount} anggota keluarga ditambahkan.");

        } catch (\Exception $e) {
            DB::rollBack();

            // Debug: Log error details
            \Log::error('Error saving penduduk data:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        // Cari data penduduk dengan relasi kartu keluarga
        $penduduk = Penduduk::with('kartuKeluarga')->findOrFail($id);

        return view('show', compact('penduduk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) : View
    {
       $penduduk = Penduduk::findOrFail($id);

        return view('edit', compact('penduduk')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // VALIDASI
        $request->validate([
            'nik' => 'required|numeric|digits:16|unique:penduduks,nik,' . $id,
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'pekerjaan' => 'required|string|max:255',
            'hubungan_keluarga' => 'required|string|max:255',
            'tamatan' => 'required|string|max:255',
            'usia' => 'nullable|numeric|min:0|max:150',
        ]);

        try {
            DB::beginTransaction();

            // CARI DATA PENDUDUK
            $penduduk = Penduduk::findOrFail($id);

            // UPDATE DATA PENDUDUK
            $penduduk->update([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'pekerjaan' => $request->pekerjaan,
                'hubungan_keluarga' => $request->hubungan_keluarga,
                'tamatan' => $request->tamatan,
                'usia' => $request->usia,
            ]);

            DB::commit();

            return redirect()->route('penduduk.index')
                ->with('success', 'Data penduduk berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        try {
            // Cari data penduduk
            $penduduk = Penduduk::with('kartuKeluarga')->findOrFail($id);

            // Ambil jenis mutasi dari request atau default ke 'PINDAH'
            $jenisMutasi = $request->input('jenis_mutasi', 'PINDAH');
            $alasan = $request->input('alasan', 'Dihapus dari sistem');

            // CATAT MUTASI SEBELUM HAPUS
            $keteranganMutasi = "Penduduk dihapus dari sistem - {$alasan}";
            $this->catatMutasi($penduduk->id, $jenisMutasi, $keteranganMutasi);

            // Hapus data penduduk
            $penduduk->delete();

            // Redirect kembali dengan pesan sukses
            $jenisMutasiText = $jenisMutasi == 'MATI' ? 'meninggal' : 'pindah';
            return redirect()->route('penduduk.index')
                ->with('success', "Data penduduk berhasil dihapus dan dicatat sebagai mutasi {$jenisMutasiText}.");

        } catch (\Exception $e) {
            // Redirect kembali dengan pesan error
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified family resource.
     */
    public function familyShow(string $kartuKeluargaId): View
    {
        // Cari data kartu keluarga dengan semua anggotanya
        $kartuKeluarga = KartuKeluarga::with('penduduk')->findOrFail($kartuKeluargaId);

        return view('family.show', compact('kartuKeluarga'));
    }

    /**
     * Show the form for editing the specified family.
     */
    public function familyEdit(string $kartuKeluargaId): View
    {
        // Cari data kartu keluarga dengan semua anggotanya
        $kartuKeluarga = KartuKeluarga::with('penduduk')->findOrFail($kartuKeluargaId);

        return view('family.edit', compact('kartuKeluarga'));
    }

    /**
     * Update the specified family resource in storage.
     */
    public function familyUpdate(Request $request, string $kartuKeluargaId)
    {
        // VALIDASI
        $request->validate([
            // Parent (KK)
            'nomor_kk' => 'required|numeric|unique:kartu_keluarga,no_kk,' . $kartuKeluargaId,
            'kategori_sejahtera' => 'nullable',
            'jenis_bangunan' => 'nullable',
            'pemakaian_air' => 'nullable',
            'jenis_bantuan' => 'nullable',

            // Child (Penduduk)
            'anggota' => 'required|array|min:1',
            'anggota.*.nik' => 'required|numeric|digits:16',
            'anggota.*.nama' => 'required|string',
            'anggota.*.jenis_kelamin' => 'required',
            'anggota.*.tempat_lahir' => 'required',
            'anggota.*.tgl_lahir' => 'required|date',
            'anggota.*.hubungan_keluarga' => 'required',
            'anggota.*.tamatan' => 'required',
            'anggota.*.pekerjaan' => 'required',
        ]);

        try {
            DB::beginTransaction();

            // UPDATE KK
            $kartuKeluarga = KartuKeluarga::findOrFail($kartuKeluargaId);
            $kartuKeluarga->update([
                'no_kk' => $request->nomor_kk,
                'kategori_sejahtera' => $request->kategori_sejahtera,
                'jenis_bangunan' => $request->jenis_bangunan,
                'pemakaian_air' => $request->pemakaian_air,
                'jenis_bantuan' => $request->jenis_bantuan,
            ]);

            // Collect existing NIKs and penduduk data for this family
            $existingAnggota = $kartuKeluarga->penduduk->keyBy('nik');
            $newNiks = collect($request->anggota)->pluck('nik')->toArray();

            // Check for NIK conflicts outside this family
            $nikConflicts = Penduduk::where('kartu_keluarga_id', '!=', $kartuKeluargaId)
                                    ->whereIn('nik', $newNiks)
                                    ->exists();

            if ($nikConflicts) {
                DB::rollBack();
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Beberapa NIK sudah digunakan oleh keluarga lain.');
            }

            // CATAT MUTASI UNTUK ANGGOTA YANG DIHAPUS
            foreach ($existingAnggota as $nikLama => $pendudukLama) {
                if (!in_array($nikLama, $newNiks)) {
                    $keteranganMutasi = "Anggota keluarga dihapus dari KK {$kartuKeluarga->no_kk} saat update data";
                    $this->catatMutasi($pendudukLama->id, 'PINDAH', $keteranganMutasi);
                }
            }

            // HAPUS SEMUA ANGGOTA LAMA
            Penduduk::where('kartu_keluarga_id', $kartuKeluargaId)->delete();

            // SIMPAN ANGGOTA BARU DAN CATAT MUTASI UNTUK PENAMBAHAN
            foreach ($request->anggota as $orang) {
                $pendudukBaru = Penduduk::create([
                    'kartu_keluarga_id' => $kartuKeluarga->id,
                    'nik' => $orang['nik'],
                    'nama' => $orang['nama'],
                    'jenis_kelamin' => $orang['jenis_kelamin'],
                    'tempat_lahir' => $orang['tempat_lahir'],
                    'tgl_lahir' => $orang['tgl_lahir'],
                    'usia' => $orang['usia'] ?? null,
                    'pekerjaan' => $orang['pekerjaan'],
                    'hubungan_keluarga' => $orang['hubungan_keluarga'],
                    'tamatan' => $orang['tamatan'],
                ]);

                // CATAT MUTASI PENAMBAHAN (hanya untuk anggota benar-benar baru)
                if (!$existingAnggota->has($orang['nik'])) {
                    $this->catatMutasiPendudukBaru($pendudukBaru);
                }
            }

            DB::commit();

            return redirect()->route('penduduk.index')
                ->with('success', 'Data keluarga berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified family from storage.
     */
    public function familyDestroy(string $kartuKeluargaId)
    {
        try {
            // Cari data kartu keluarga dengan semua anggotanya
            $kartuKeluarga = KartuKeluarga::with('penduduk')->findOrFail($kartuKeluargaId);

            // CATAT MUTASI UNTUK SEMUA ANGGOTA SEBELUM HAPUS
            foreach ($kartuKeluarga->penduduk as $penduduk) {
                $keteranganMutasi = "Seluruh keluarga (KK: {$kartuKeluarga->no_kk}) dihapus dari sistem";
                $this->catatMutasi($penduduk->id, 'PINDAH', $keteranganMutasi);
            }

            // Hapus kartu keluarga (akan otomatis menghapus semua anggota karena onDelete cascade)
            $kartuKeluarga->delete();

            // Redirect kembali dengan pesan sukses
            return redirect()->route('penduduk.index')
                ->with('success', 'Data keluarga berhasil dihapus dan semua anggota dicatat sebagai mutasi pindah.');

        } catch (\Exception $e) {
            // Redirect kembali dengan pesan error
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}

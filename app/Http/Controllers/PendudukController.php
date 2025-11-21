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
        // Retrieve all penduduk data with proper ordering to maintain insertion sequence
        // First, get all families ordered by their creation date, then get their members
        $kartuKeluarga = \App\Models\KartuKeluarga::orderBy('created_at', 'asc')->get();
        $groupedPenduduk = collect();

        foreach ($kartuKeluarga as $kk) {
            $anggota = Penduduk::with('kartuKeluarga')
                ->where('kartu_keluarga_id', $kk->id)
                ->orderBy('created_at', 'asc') // Order family members by insertion date
                ->get();

            if ($anggota->isNotEmpty()) {
                $groupedPenduduk->put($kk->no_kk, $anggota);
            }
        }

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
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        // VALIDASI DATA FORM - Clean validation with proper error messages
        $validator = \Validator::make($request->all(), [
            // Data Kartu Keluarga
            'nomor_kk' => [
                'required',
                'numeric',
                'digits:16',
                'unique:kartu_keluarga,no_kk'
            ],
            'kategori_sejahtera' => 'nullable|string|max:50',
            'jenis_bangunan' => 'nullable|string|max:100',
            'pemakaian_air' => 'nullable|string|max:100',
            'jenis_bantuan' => 'nullable|string|max:100',

            // Data Anggota Keluarga
            'anggota' => 'required|array|min:1',
            'anggota.*.nik' => [
                'required',
                'numeric',
                'digits:16',
                'unique:penduduks,nik'
            ],
            'anggota.*.nama' => 'required|string|max:255|regex:/^[a-zA-Z\s\.\-]+$/',
            'anggota.*.jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan,L,P,Male,Female',
            'anggota.*.tempat_lahir' => 'required|string|max:100',
            'anggota.*.tgl_lahir' => 'required|date|before:today',
            'anggota.*.hubungan_keluarga' => 'required|string|max:50',
            'anggota.*.tamatan' => 'required|string|max:100',
            'anggota.*.pekerjaan' => 'required|string|max:100',
        ], [
            // Custom validation messages
            'nomor_kk.required' => 'Nomor KK wajib diisi',
            'nomor_kk.numeric' => 'Nomor KK harus berupa angka',
            'nomor_kk.digits' => 'Nomor KK harus 16 digit',
            'nomor_kk.unique' => 'Nomor KK sudah terdaftar',

            'anggota.required' => 'Minimal harus ada 1 anggota keluarga',
            'anggota.min' => 'Minimal harus ada 1 anggota keluarga',

            'anggota.*.nik.required' => 'NIK anggota wajib diisi',
            'anggota.*.nik.numeric' => 'NIK harus berupa angka',
            'anggota.*.nik.digits' => 'NIK harus 16 digit',
            'anggota.*.nik.unique' => 'NIK sudah terdaftar',

            'anggota.*.nama.required' => 'Nama anggota wajib diisi',
            'anggota.*.nama.regex' => 'Nama hanya boleh mengandung huruf, spasi, titik, dan tanda hubung',

            'anggota.*.jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
            'anggota.*.jenis_kelamin.in' => 'Jenis kelamin hanya boleh: Laki-laki, Perempuan, L, P, Male, atau Female',

            'anggota.*.tempat_lahir.required' => 'Tempat lahir wajib diisi',

            'anggota.*.tgl_lahir.required' => 'Tanggal lahir wajib dipilih',
            'anggota.*.tgl_lahir.before' => 'Tanggal lahir tidak boleh hari ini atau masa depan',

            'anggota.*.hubungan_keluarga.required' => 'Hubungan keluarga wajib dipilih',
            'anggota.*.tamatan.required' => 'Pendidikan terakhir wajib dipilih',
            'anggota.*.pekerjaan.required' => 'Pekerjaan wajib diisi',
        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Validasi gagal. Periksa kembali data yang dimasukkan.');
        }

        try {
            // Use database transaction for data integrity
            DB::beginTransaction();

            // Step 1: Create Kartu Keluarga record
            $kartuKeluargaData = [
                'no_kk' => $request->nomor_kk,
                'kategori_sejahtera' => $request->kategori_sejahtera,
                'jenis_bangunan' => $request->jenis_bangunan,
                'pemakaian_air' => $request->pemakaian_air,
                'jenis_bantuan' => $request->jenis_bantuan,
            ];

            $kartuKeluarga = KartuKeluarga::create($kartuKeluargaData);

            if (!$kartuKeluarga) {
                throw new \Exception('Gagal membuat data Kartu Keluarga');
            }

            // Step 2: Create Penduduk records for each family member
            $savedMembers = [];
            $totalMembers = count($request->anggota);

            foreach ($request->anggota as $memberData) {
                // Calculate age if not provided
                if (!isset($memberData['usia']) || empty($memberData['usia'])) {
                    $memberData['usia'] = Carbon::parse($memberData['tgl_lahir'])->age;
                }

                // Standardize gender format to single character for database compatibility
                // Handle multiple input formats: Laki-laki, Perempuan, L, P, Male, Female
                $genderInput = strtolower(trim($memberData['jenis_kelamin']));
                if (in_array($genderInput, ['l', 'laki-laki', 'male'])) {
                    $memberData['jenis_kelamin'] = 'L';
                } elseif (in_array($genderInput, ['p', 'perempuan', 'female'])) {
                    $memberData['jenis_kelamin'] = 'P';
                } else {
                    // Default fallback - if gender is not recognized, default to 'L'
                    $memberData['jenis_kelamin'] = 'L';
                    \Log::warning("Unrecognized gender input: {$memberData['jenis_kelamin']}, defaulting to 'L'");
                }

                $pendudukData = [
                    'kartu_keluarga_id' => $kartuKeluarga->id,
                    'nik' => $memberData['nik'],
                    'nama' => ucwords(strtolower($memberData['nama'])),
                    'jenis_kelamin' => $memberData['jenis_kelamin'],
                    'tempat_lahir' => ucwords(strtolower($memberData['tempat_lahir'])),
                    'tgl_lahir' => $memberData['tgl_lahir'],
                    'usia' => $memberData['usia'],
                    'pekerjaan' => ucwords(strtolower($memberData['pekerjaan'])),
                    'hubungan_keluarga' => $memberData['hubungan_keluarga'],
                    'tamatan' => $memberData['tamatan'],
                    'status' => 'HIDUP', // Default status for new residents
                ];

                $penduduk = Penduduk::create($pendudukData);

                if (!$penduduk) {
                    throw new \Exception('Gagal menyimpan data anggota keluarga');
                }

                $savedMembers[] = $penduduk;

                // NOTE: Mutations should only be created through Mutation page
                // Not automatically when adding new residents
            }

            // Commit all changes
            DB::commit();

            // Success response
            return redirect()->route('penduduk.index')
                ->with('success', "✅ Data berhasil disimpan! {$totalMembers} anggota keluarga dengan Nomor KK {$request->nomor_kk} telah ditambahkan.");

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();

            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Validasi data gagal: ' . $e->getMessage());

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            // Log database errors
            \Log::error('Database Error in PendudukController@store:', [
                'message' => $e->getMessage(),
                'sql' => $e->getSql(),
                'bindings' => $e->getBindings(),
            ]);

            $errorMessage = 'Terjadi kesalahan database. ';

            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                if (str_contains($e->getMessage(), 'nik')) {
                    $errorMessage = 'NIK sudah terdaftar dalam sistem. Gunakan NIK yang berbeda.';
                } elseif (str_contains($e->getMessage(), 'no_kk')) {
                    $errorMessage = 'Nomor KK sudah terdaftar dalam sistem. Gunakan Nomor KK yang berbeda.';
                }
            } else {
                $errorMessage .= 'Hubungi administrator.';
            }

            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);

        } catch (\Exception $e) {
            DB::rollBack();

            // Log general errors
            \Log::error('General Error in PendudukController@store:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
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

                // NOTE: Mutations should only be created through Mutation page
                // Not automatically when updating family data
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

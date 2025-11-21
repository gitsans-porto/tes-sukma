<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Data Penduduk - Multiple Insert</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-people-fill"></i>
                            Tambah Data Penduduk Baru (Multiple Anggota Keluarga)
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Session Flash Messages -->
                        @if(session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Display Validation Errors -->
                        @if ($errors->any())
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <h5 class="alert-heading">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                    Terdapat kesalahan pada input data:
                                </h5>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('penduduk.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- HEADER SECTION - Data Kartu Keluarga (Single) -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="bi bi-house-fill"></i> Data Kartu Keluarga
                                    </h5>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="nomor_kk" class="form-label">Nomor KK <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('nomor_kk') is-invalid @enderror"
                                           id="nomor_kk" name="nomor_kk" value="{{ old('nomor_kk') }}" required>
                                    @error('nomor_kk')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="kategori_sejahtera" class="form-label">Kategori Sejahtera</label>
                                    <select class="form-select @error('kategori_sejahtera') is-invalid @enderror"
                                            id="kategori_sejahtera" name="kategori_sejahtera">
                                        <option value="">Pilih Kategori Sejahtera</option>
                                        <option value="KS1" {{ old('kategori_sejahtera') == 'KS1' ? 'selected' : '' }}>KS1</option>
                                        <option value="KS2" {{ old('kategori_sejahtera') == 'KS2' ? 'selected' : '' }}>KS2</option>
                                        <option value="KS3" {{ old('kategori_sejahtera') == 'KS3' ? 'selected' : '' }}>KS3</option>
                                    </select>
                                    @error('kategori_sejahtera')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="jenis_bangunan" class="form-label">Jenis Bangunan</label>
                                    <input type="text" class="form-control @error('jenis_bangunan') is-invalid @enderror"
                                           id="jenis_bangunan" name="jenis_bangunan" value="{{ old('jenis_bangunan') }}">
                                    @error('jenis_bangunan')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="pemakaian_air" class="form-label">Pemakaian Air</label>
                                    <input type="text" class="form-control @error('pemakaian_air') is-invalid @enderror"
                                           id="pemakaian_air" name="pemakaian_air" value="{{ old('pemakaian_air') }}">
                                    @error('pemakaian_air')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="jenis_bantuan" class="form-label">Jenis Bantuan</label>
                                    <input type="text" class="form-control @error('jenis_bantuan') is-invalid @enderror"
                                           id="jenis_bantuan" name="jenis_bantuan" value="{{ old('jenis_bantuan') }}">
                                    @error('jenis_bantuan')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- REPEATER SECTION - Data Anggota Keluarga (Multiple) -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="border-bottom pb-2 mb-0">
                                            <i class="bi bi-people-fill"></i> Data Anggota Keluarga
                                        </h5>
                                        <button type="button" class="btn btn-success btn-sm" id="tambahAnggota">
                                            <i class="bi bi-plus-circle"></i> Tambah Anggota
                                        </button>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="tableAnggota">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th width="50px">No</th>
                                                    <th>NIK</th>
                                                    <th>Nama Lengkap</th>
                                                    <th>Gender</th>
                                                    <th>Tempat Lahir</th>
                                                    <th>Tanggal Lahir</th>
                                                    <th>Usia</th>
                                                    <th>Pekerjaan</th>
                                                    <th>Hubungan</th>
                                                    <th>Tamatan</th>
                                                    <th width="50px">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="anggotaContainer">
                                                <!-- Baris pertama (Default) -->
                                                <tr class="anggota-row" data-index="0">
                                                    <td class="text-center">1</td>
                                                    <td>
                                                        <input type="number" class="form-control nik-input @error('anggota.0.nik') is-invalid @enderror"
                                                               name="anggota[0][nik]" value="{{ old('anggota.0.nik') }}" required>
                                                        @error('anggota.0.nik')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control nama-input @error('anggota.0.nama') is-invalid @enderror"
                                                               name="anggota[0][nama]" value="{{ old('anggota.0.nama') }}" required>
                                                        @error('anggota.0.nama')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <select class="form-select gender-input @error('anggota.0.jenis_kelamin') is-invalid @enderror" name="anggota[0][jenis_kelamin]" required>
                                                            <option value="">Pilih</option>
                                                            <option value="Laki-laki" {{ old('anggota.0.jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                            <option value="Perempuan" {{ old('anggota.0.jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                        </select>
                                                        @error('anggota.0.jenis_kelamin')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control tempat-lahir-input @error('anggota.0.tempat_lahir') is-invalid @enderror"
                                                               name="anggota[0][tempat_lahir]" value="{{ old('anggota.0.tempat_lahir') }}" required>
                                                        @error('anggota.0.tempat_lahir')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="date" class="form-control tgl-lahir-input @error('anggota.0.tgl_lahir') is-invalid @enderror"
                                                               name="anggota[0][tgl_lahir]" value="{{ old('anggota.0.tgl_lahir') }}" required>
                                                        @error('anggota.0.tgl_lahir')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control usia-input"
                                                               name="anggota[0][usia]" value="{{ old('anggota.0.usia') }}" readonly>
                                                        <small class="text-muted">Auto</small>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control pekerjaan-input @error('anggota.0.pekerjaan') is-invalid @enderror"
                                                               name="anggota[0][pekerjaan]" value="{{ old('anggota.0.pekerjaan') }}" required>
                                                        @error('anggota.0.pekerjaan')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <select class="form-select hubungan-input @error('anggota.0.hubungan_keluarga') is-invalid @enderror" name="anggota[0][hubungan_keluarga]" required>
                                                            <option value="">Pilih</option>
                                                            <option value="Kepala Keluarga" {{ old('anggota.0.hubungan_keluarga') == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                                                            <option value="Istri" {{ old('anggota.0.hubungan_keluarga') == 'Istri' ? 'selected' : '' }}>Istri</option>
                                                            <option value="Anak" {{ old('anggota.0.hubungan_keluarga') == 'Anak' ? 'selected' : '' }}>Anak</option>
                                                            <option value="Menantu" {{ old('anggota.0.hubungan_keluarga') == 'Menantu' ? 'selected' : '' }}>Menantu</option>
                                                            <option value="Cucu" {{ old('anggota.0.hubungan_keluarga') == 'Cucu' ? 'selected' : '' }}>Cucu</option>
                                                            <option value="Lainnya" {{ old('anggota.0.hubungan_keluarga') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                                        </select>
                                                        @error('anggota.0.hubungan_keluarga')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <select class="form-select tamatan-input @error('anggota.0.tamatan') is-invalid @enderror" name="anggota[0][tamatan]" required>
                                                            <option value="">Pilih</option>
                                                            <option value="SD" {{ old('anggota.0.tamatan') == 'SD' ? 'selected' : '' }}>SD</option>
                                                            <option value="SMP" {{ old('anggota.0.tamatan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                                            <option value="SMA/SMK" {{ old('anggota.0.tamatan') == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                                                            <option value="D1/D2/D3" {{ old('anggota.0.tamatan') == 'D1/D2/D3' ? 'selected' : '' }}>D1/D2/D3</option>
                                                            <option value="S1" {{ old('anggota.0.tamatan') == 'S1' ? 'selected' : '' }}>S1</option>
                                                            <option value="S2" {{ old('anggota.0.tamatan') == 'S2' ? 'selected' : '' }}>S2</option>
                                                            <option value="S3" {{ old('anggota.0.tamatan') == 'S3' ? 'selected' : '' }}>S3</option>
                                                            <option value="Tidak Tamat SD" {{ old('anggota.0.tamatan') == 'Tidak Tamat SD' ? 'selected' : '' }}>Tidak Tamat SD</option>
                                                            <option value="Tidak Sekolah" {{ old('anggota.0.tamatan') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                                        </select>
                                                        @error('anggota.0.tamatan')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-secondary btn-sm hapus-anggota" disabled
                                                                title="Tidak bisa menghapus anggota terakhir">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- BUTTONS -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('penduduk.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left"></i> Kembali
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-save"></i> Simpan Semua Data
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery (must be loaded before Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            let anggotaIndex = 1; // Start from 1 because index 0 already exists

            // Fungsi untuk menghitung usia
            function hitungUsia(tanggalLahir) {
                const today = new Date();
                const birthDate = new Date(tanggalLahir);

                let usia = today.getFullYear() - birthDate.getFullYear();
                const bulanSekarang = today.getMonth();
                const tanggalSekarang = today.getDate();
                const bulanLahir = birthDate.getMonth();
                const tanggalLahirHari = birthDate.getDate();

                // Jika bulan lahir belum lewat atau sama tapi tanggal lahir belum lewat
                if (bulanSekarang < bulanLahir ||
                    (bulanSekarang === bulanLahir && tanggalSekarang < tanggalLahirHari)) {
                    usia--;
                }

                return usia;
            }

            // Event Delegation untuk perhitungan usia (handle dinamis added elements)
            $(document).on('change', '.tgl-lahir-input', function() {
                const tanggalLahir = $(this).val();
                const usiaInput = $(this).closest('tr').find('.usia-input');

                if (tanggalLahir) {
                    const usia = hitungUsia(tanggalLahir);
                    usiaInput.val(usia);
                } else {
                    usiaInput.val('');
                }
            });

            

            // Fungsi untuk menambah anggota
            $('#tambahAnggota').click(function() {
                console.log('Tambah anggota clicked - Current index:', anggotaIndex);

                const newRow = `
                    <tr class="anggota-row" data-index="${anggotaIndex}">
                        <td class="text-center">${anggotaIndex + 1}</td>
                        <td>
                            <input type="number" class="form-control nik-input"
                                   name="anggota[${anggotaIndex}][nik]" required>
                        </td>
                        <td>
                            <input type="text" class="form-control nama-input"
                                   name="anggota[${anggotaIndex}][nama]" required>
                        </td>
                        <td>
                            <select class="form-select gender-input" name="anggota[${anggotaIndex}][jenis_kelamin]" required>
                                <option value="">Pilih</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control tempat-lahir-input"
                                   name="anggota[${anggotaIndex}][tempat_lahir]" required>
                        </td>
                        <td>
                            <input type="date" class="form-control tgl-lahir-input"
                                   name="anggota[${anggotaIndex}][tgl_lahir]" required>
                        </td>
                        <td>
                            <input type="number" class="form-control usia-input"
                                   name="anggota[${anggotaIndex}][usia]" readonly>
                            <small class="text-muted">Auto</small>
                        </td>
                        <td>
                            <input type="text" class="form-control pekerjaan-input"
                                   name="anggota[${anggotaIndex}][pekerjaan]" required>
                        </td>
                        <td>
                            <select class="form-select hubungan-input" name="anggota[${anggotaIndex}][hubungan_keluarga]" required>
                                <option value="">Pilih</option>
                                <option value="Kepala Keluarga">Kepala Keluarga</option>
                                <option value="Istri">Istri</option>
                                <option value="Anak">Anak</option>
                                <option value="Menantu">Menantu</option>
                                <option value="Cucu">Cucu</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-select tamatan-input" name="anggota[${anggotaIndex}][tamatan]" required>
                                <option value="">Pilih</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA/SMK">SMA/SMK</option>
                                <option value="D1/D2/D3">D1/D2/D3</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                                <option value="Tidak Tamat SD">Tidak Tamat SD</option>
                                <option value="Tidak Sekolah">Tidak Sekolah</option>
                            </select>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm hapus-anggota" title="Hapus anggota ini">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;

                $('#anggotaContainer').append(newRow);
                console.log('New row added');
                updateDeleteButtons();
                updateRowNumbers();
                anggotaIndex++;
            });

            // Event Delegation untuk menghapus anggota
            $(document).on('click', '.hapus-anggota', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const $button = $(this);
                const $row = $button.closest('.anggota-row');
                const rowCount = $('#anggotaContainer .anggota-row').length;

                console.log('Delete clicked - Row count:', rowCount);

                // Pastikan minimal 1 baris tersisa
                if (rowCount > 1) {
                    // Add fade effect
                    $row.fadeOut(300, function() {
                        $(this).remove();
                        updateDeleteButtons();
                        updateRowNumbers();
                        console.log('Row deleted successfully');
                    });
                } else {
                    alert('Minimal harus ada 1 anggota keluarga!');
                    console.log('Cannot delete - last row');
                }
            });

            // Fungsi untuk update tombol hapus (enable/disable)
            function updateDeleteButtons() {
                const rowCount = $('#anggotaContainer .anggota-row').length;
                const shouldBeDisabled = rowCount <= 1;

                console.log('Update delete buttons - Row count:', rowCount, 'Should be disabled:', shouldBeDisabled);

                $('#anggotaContainer .hapus-anggota').each(function() {
                    const $btn = $(this);
                    $btn.prop('disabled', shouldBeDisabled);

                    if (shouldBeDisabled) {
                        $btn.removeClass('btn-danger').addClass('btn-secondary');
                        $btn.attr('title', 'Tidak bisa menghapus anggota terakhir');
                    } else {
                        $btn.removeClass('btn-secondary').addClass('btn-danger');
                        $btn.attr('title', 'Hapus anggota ini');
                    }
                });
            }

            // Fungsi untuk update nomor urut
            function updateRowNumbers() {
                $('#anggotaContainer .anggota-row').each(function(index) {
                    $(this).find('td:first').text(index + 1);
                    $(this).attr('data-index', index);
                });
            }

            // Hitung usia untuk input yang sudah ada saat page load
            $('.tgl-lahir-input').each(function() {
                const tanggalLahir = $(this).val();
                if (tanggalLahir) {
                    const usia = hitungUsia(tanggalLahir);
                    $(this).closest('tr').find('.usia-input').val(usia);
                }
            });

            // Inisialisasi tombol hapus saat page load
            updateDeleteButtons();

            // Form submission validation
            $('form').submit(function(e) {
                console.log('Form submit triggered');

                // Check if there are empty required fields
                let isValid = true;
                let errorMessage = '';

                // Validate KK number
                const nomorKK = $('#nomor_kk').val().trim();
                if (!nomorKK) {
                    isValid = false;
                    errorMessage = 'Nomor KK wajib diisi!';
                } else if (nomorKK.length < 1) {
                    isValid = false;
                    errorMessage = 'Nomor KK tidak valid!';
                }

                // Validate anggota rows
                const anggotaRows = $('.anggota-row');
                if (anggotaRows.length === 0) {
                    isValid = false;
                    errorMessage = 'Minimal harus ada 1 anggota keluarga!';
                }

                // Check each anggota for required fields
                anggotaRows.each(function(index) {
                    const row = $(this);
                    const nik = row.find('input[name^="anggota"][name$="[nik]"]').val().trim();
                    const nama = row.find('input[name^="anggota"][name$="[nama]"]').val().trim();
                    const gender = row.find('select[name^="anggota"][name$="[jenis_kelamin]"]').val();
                    const tempatLahir = row.find('input[name^="anggota"][name$="[tempat_lahir]"]').val().trim();
                    const tglLahir = row.find('input[name^="anggota"][name$="[tgl_lahir]"]').val();
                    const pekerjaan = row.find('input[name^="anggota"][name$="[pekerjaan]"]').val().trim();
                    const hubungan = row.find('select[name^="anggota"][name$="[hubungan_keluarga]"]').val();
                    const tamatan = row.find('select[name^="anggota"][name$="[tamatan]"]').val();

                    console.log(`Validating anggota ${index + 1}:`, {
                        nik, nama, gender, tempatLahir, tglLahir, pekerjaan, hubungan, tamatan
                    });

                    if (!nik || nik.length !== 16) {
                        isValid = false;
                        errorMessage = `NIK anggota ${index + 1} harus 16 digit!`;
                        return false; // break the loop
                    }

                    if (!nama) {
                        isValid = false;
                        errorMessage = `Nama anggota ${index + 1} wajib diisi!`;
                        return false;
                    }

                    if (!gender) {
                        isValid = false;
                        errorMessage = `Jenis kelamin anggota ${index + 1} wajib dipilih!`;
                        return false;
                    }

                    if (!tempatLahir) {
                        isValid = false;
                        errorMessage = `Tempat lahir anggota ${index + 1} wajib diisi!`;
                        return false;
                    }

                    if (!tglLahir) {
                        isValid = false;
                        errorMessage = `Tanggal lahir anggota ${index + 1} wajib dipilih!`;
                        return false;
                    }

                    if (!pekerjaan) {
                        isValid = false;
                        errorMessage = `Pekerjaan anggota ${index + 1} wajib diisi!`;
                        return false;
                    }

                    if (!hubungan) {
                        isValid = false;
                        errorMessage = `Hubungan keluarga anggota ${index + 1} wajib dipilih!`;
                        return false;
                    }

                    if (!tamatan) {
                        isValid = false;
                        errorMessage = `Pendidikan anggota ${index + 1} wajib dipilih!`;
                        return false;
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Validation Error: ' + errorMessage);
                    console.error('Validation failed:', errorMessage);
                    return false;
                }

                // Disable submit button to prevent double submission
                const submitBtn = $(this).find('button[type="submit"]');
                submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Menyimpan...');

                console.log('Form validation passed, submitting...');

                return true;
            });
        });
    </script>
</body>
</html>
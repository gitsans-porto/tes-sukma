<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Data Keluarga - Multiple Update</title>
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
                    <div class="card-header bg-warning text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-pencil-square"></i>
                            Edit Data Keluarga (Multiple Anggota Keluarga)
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('penduduk.family.update', $kartuKeluarga->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

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
                                           id="nomor_kk" name="nomor_kk" value="{{ old('nomor_kk', $kartuKeluarga->no_kk) }}" required>
                                    @error('nomor_kk')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="kategori_sejahtera" class="form-label">Kategori Sejahtera</label>
                                    <select class="form-select @error('kategori_sejahtera') is-invalid @enderror"
                                            id="kategori_sejahtera" name="kategori_sejahtera">
                                        <option value="">Pilih Kategori Sejahtera</option>
                                        <option value="KS1" {{ old('kategori_sejahtera', $kartuKeluarga->kategori_sejahtera) == 'KS1' ? 'selected' : '' }}>KS1</option>
                                        <option value="KS2" {{ old('kategori_sejahtera', $kartuKeluarga->kategori_sejahtera) == 'KS2' ? 'selected' : '' }}>KS2</option>
                                        <option value="KS3" {{ old('kategori_sejahtera', $kartuKeluarga->kategori_sejahtera) == 'KS3' ? 'selected' : '' }}>KS3</option>
                                    </select>
                                    @error('kategori_sejahtera')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="jenis_bangunan" class="form-label">Jenis Bangunan</label>
                                    <input type="text" class="form-control @error('jenis_bangunan') is-invalid @enderror"
                                           id="jenis_bangunan" name="jenis_bangunan" value="{{ old('jenis_bangunan', $kartuKeluarga->jenis_bangunan) }}">
                                    @error('jenis_bangunan')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="pemakaian_air" class="form-label">Pemakaian Air</label>
                                    <input type="text" class="form-control @error('pemakaian_air') is-invalid @enderror"
                                           id="pemakaian_air" name="pemakaian_air" value="{{ old('pemakaian_air', $kartuKeluarga->pemakaian_air) }}">
                                    @error('pemakaian_air')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="jenis_bantuan" class="form-label">Jenis Bantuan</label>
                                    <input type="text" class="form-control @error('jenis_bantuan') is-invalid @enderror"
                                           id="jenis_bantuan" name="jenis_bantuan" value="{{ old('jenis_bantuan', $kartuKeluarga->jenis_bantuan) }}">
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
                                                <!-- Existing family members -->
                                                @foreach($kartuKeluarga->penduduk as $index => $anggota)
                                                    <tr class="anggota-row" data-index="{{ $index }}">
                                                        <td class="text-center">{{ $index + 1 }}</td>
                                                        <td>
                                                            <input type="number" class="form-control nik-input @error("anggota.$index.nik") is-invalid @enderror"
                                                                   name="anggota[{{ $index }}][nik]" value="{{ old("anggota.$index.nik", $anggota->nik) }}" required>
                                                            @error("anggota.$index.nik")
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control nama-input @error("anggota.$index.nama") is-invalid @enderror"
                                                                   name="anggota[{{ $index }}][nama]" value="{{ old("anggota.$index.nama", $anggota->nama) }}" required>
                                                            @error("anggota.$index.nama")
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        <td>
                                                            <select class="form-select gender-input @error("anggota.$index.jenis_kelamin") is-invalid @enderror" name="anggota[{{ $index }}][jenis_kelamin]" required>
                                                                <option value="">Pilih</option>
                                                                <option value="Laki-laki" {{ old("anggota.$index.jenis_kelamin", $anggota->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                                <option value="Perempuan" {{ old("anggota.$index.jenis_kelamin", $anggota->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                            </select>
                                                            @error("anggota.$index.jenis_kelamin")
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control tempat-lahir-input @error("anggota.$index.tempat_lahir") is-invalid @enderror"
                                                                   name="anggota[{{ $index }}][tempat_lahir]" value="{{ old("anggota.$index.tempat_lahir", $anggota->tempat_lahir) }}" required>
                                                            @error("anggota.$index.tempat_lahir")
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        <td>
                                                            <input type="date" class="form-control tgl-lahir-input @error("anggota.$index.tgl_lahir") is-invalid @enderror"
                                                                   name="anggota[{{ $index }}][tgl_lahir]" value="{{ old("anggota.$index.tgl_lahir", $anggota->tgl_lahir ? \Carbon\Carbon::parse($anggota->tgl_lahir)->format('Y-m-d') : '') }}" required>
                                                            @error("anggota.$index.tgl_lahir")
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control usia-input"
                                                                   name="anggota[{{ $index }}][usia]" value="{{ old("anggota.$index.usia", $anggota->usia) }}" readonly>
                                                            <small class="text-muted">Auto</small>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control pekerjaan-input @error("anggota.$index.pekerjaan") is-invalid @enderror"
                                                                   name="anggota[{{ $index }}][pekerjaan]" value="{{ old("anggota.$index.pekerjaan", $anggota->pekerjaan) }}" required>
                                                            @error("anggota.$index.pekerjaan")
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        <td>
                                                            <select class="form-select hubungan-input @error("anggota.$index.hubungan_keluarga") is-invalid @enderror" name="anggota[{{ $index }}][hubungan_keluarga]" required>
                                                                <option value="">Pilih</option>
                                                                <option value="Kepala Keluarga" {{ old("anggota.$index.hubungan_keluarga", $anggota->hubungan_keluarga) == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                                                                <option value="Istri" {{ old("anggota.$index.hubungan_keluarga", $anggota->hubungan_keluarga) == 'Istri' ? 'selected' : '' }}>Istri</option>
                                                                <option value="Anak" {{ old("anggota.$index.hubungan_keluarga", $anggota->hubungan_keluarga) == 'Anak' ? 'selected' : '' }}>Anak</option>
                                                                <option value="Menantu" {{ old("anggota.$index.hubungan_keluarga", $anggota->hubungan_keluarga) == 'Menantu' ? 'selected' : '' }}>Menantu</option>
                                                                <option value="Cucu" {{ old("anggota.$index.hubungan_keluarga", $anggota->hubungan_keluarga) == 'Cucu' ? 'selected' : '' }}>Cucu</option>
                                                                <option value="Lainnya" {{ old("anggota.$index.hubungan_keluarga", $anggota->hubungan_keluarga) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                                            </select>
                                                            @error("anggota.$index.hubungan_keluarga")
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        <td>
                                                            <select class="form-select tamatan-input @error("anggota.$index.tamatan") is-invalid @enderror" name="anggota[{{ $index }}][tamatan]" required>
                                                                <option value="">Pilih</option>
                                                                <option value="SD" {{ old("anggota.$index.tamatan", $anggota->tamatan) == 'SD' ? 'selected' : '' }}>SD</option>
                                                                <option value="SMP" {{ old("anggota.$index.tamatan", $anggota->tamatan) == 'SMP' ? 'selected' : '' }}>SMP</option>
                                                                <option value="SMA/SMK" {{ old("anggota.$index.tamatan", $anggota->tamatan) == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                                                                <option value="D1/D2/D3" {{ old("anggota.$index.tamatan", $anggota->tamatan) == 'D1/D2/D3' ? 'selected' : '' }}>D1/D2/D3</option>
                                                                <option value="S1" {{ old("anggota.$index.tamatan", $anggota->tamatan) == 'S1' ? 'selected' : '' }}>S1</option>
                                                                <option value="S2" {{ old("anggota.$index.tamatan", $anggota->tamatan) == 'S2' ? 'selected' : '' }}>S2</option>
                                                                <option value="S3" {{ old("anggota.$index.tamatan", $anggota->tamatan) == 'S3' ? 'selected' : '' }}>S3</option>
                                                                <option value="Tidak Tamat SD" {{ old("anggota.$index.tamatan", $anggota->tamatan) == 'Tidak Tamat SD' ? 'selected' : '' }}>Tidak Tamat SD</option>
                                                                <option value="Tidak Sekolah" {{ old("anggota.$index.tamatan", $anggota->tamatan) == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                                            </select>
                                                            @error("anggota.$index.tamatan")
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn @if($kartuKeluarga->penduduk->count() <= 1) btn-secondary @else btn-danger @endif btn-sm hapus-anggota" @if($kartuKeluarga->penduduk->count() <= 1) disabled @endif
                                                                    title="@if($kartuKeluarga->penduduk->count() <= 1) Tidak bisa menghapus anggota terakhir @else Hapus anggota ini @endif">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
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
                                            <i class="bi bi-save"></i> Update Semua Data
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
        // Fallback: Tunggu jQuery dimuat
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Content Loaded');

            // Check jQuery availability
            if (typeof jQuery === 'undefined') {
                console.error('jQuery not loaded!');
                // Fallback to vanilla JavaScript
                initVanillaJS();
                return;
            }

            console.log('jQuery loaded, version:', jQuery.fn.jquery);

            // Use jQuery
            jQuery(document).ready(function($) {
                let anggotaIndex = {{ $kartuKeluarga->penduduk->count() }};
                console.log('Family edit form loaded with', anggotaIndex, 'existing members');

                // Fungsi untuk menghitung usia
                function hitungUsia(tanggalLahir) {
                    const today = new Date();
                    const birthDate = new Date(tanggalLahir);

                    let usia = today.getFullYear() - birthDate.getFullYear();
                    const bulanSekarang = today.getMonth();
                    const tanggalSekarang = today.getDate();
                    const bulanLahir = birthDate.getMonth();
                    const tanggalLahirHari = birthDate.getDate();

                    if (bulanSekarang < bulanLahir ||
                        (bulanSekarang === bulanLahir && tanggalSekarang < tanggalLahirHari)) {
                        usia--;
                    }

                    return usia;
                }

                // Event Delegation untuk perhitungan usia
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
                console.log('Tambah anggota clicked in family edit - Current index:', anggotaIndex);

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
                console.log('New family member row added');
                updateDeleteButtons();
                updateRowNumbers();
                anggotaIndex++;
            });

                // Event Delegation untuk menghapus anggota dengan pendekatan yang lebih robust
                $(document).on('click', '.hapus-anggota', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    console.log('Delete button clicked');

                    // Verifikasi jQuery berfungsi
                    if (typeof $ === 'undefined') {
                        console.error('jQuery not available in click handler');
                        alert('Terjadi kesalahan JavaScript. Silakan refresh halaman.');
                        return;
                    }

                    const $button = $(this);
                    const $row = $button.closest('.anggota-row');

                    // Verifikasi elemen ditemukan
                    if ($row.length === 0) {
                        console.error('Row not found');
                        alert('Baris tidak ditemukan. Silakan refresh halaman.');
                        return;
                    }

                    const $container = $('#anggotaContainer');
                    const rowCount = $container.find('.anggota-row').length;

                    console.log('Row count:', rowCount, 'Button disabled:', $button.prop('disabled'));

                    // Cek apakah button disabled
                    if ($button.prop('disabled')) {
                        console.log('Button is disabled, cannot delete');
                        return;
                    }

                    // Pastikan minimal 1 baris tersisa
                    if (rowCount > 1) {
                        if (confirm('Apakah Anda yakin ingin menghapus anggota keluarga ini?')) {
                            // Add fade effect
                            $row.fadeOut(300, function() {
                                $(this).remove();

                                // Update buttons dan row numbers
                                setTimeout(function() {
                                    updateDeleteButtons();
                                    updateRowNumbers();
                                }, 100);

                                console.log('Family member deleted successfully');
                            });
                        }
                    } else {
                        alert('Minimal harus ada 1 anggota keluarga!');
                        console.log('Cannot delete - last family member');
                    }
                });

                // Fungsi untuk update tombol hapus
                function updateDeleteButtons() {
                    const $container = $('#anggotaContainer');
                    const $rows = $container.find('.anggota-row');
                    const rowCount = $rows.length;
                    const shouldBeDisabled = rowCount <= 1;

                    console.log('Update buttons - Row count:', rowCount, 'Should be disabled:', shouldBeDisabled);

                    $container.find('.hapus-anggota').each(function() {
                        const $btn = $(this);

                        // Update disabled state
                        $btn.prop('disabled', shouldBeDisabled);

                        // Update visual state
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
                    const $rows = $('#anggotaContainer .anggota-row');

                    $rows.each(function(index) {
                        const $row = $(this);
                        $row.find('td:first').text(index + 1);
                        $row.attr('data-index', index);
                    });
                }

                // Hitung usia untuk existing rows
                $('.tgl-lahir-input').each(function() {
                    const $input = $(this);
                    const tanggalLahir = $input.val();

                    if (tanggalLahir) {
                        const usia = hitungUsia(tanggalLahir);
                        $input.closest('tr').find('.usia-input').val(usia);
                    }
                });

                // Inisialisasi buttons saat load
                updateDeleteButtons();

                console.log('Family edit form initialization completed');
            });
            });
        });

        // Vanilla JavaScript Fallback
        function initVanillaJS() {
            console.log('Initializing with vanilla JavaScript');

            // Function untuk hapus anggota dengan vanilla JS
            document.addEventListener('click', function(e) {
                if (e.target.closest('.hapus-anggota')) {
                    e.preventDefault();
                    e.stopPropagation();

                    const button = e.target.closest('.hapus-anggota');
                    const row = button.closest('tr');
                    const container = document.getElementById('anggotaContainer');
                    const rows = container.querySelectorAll('.anggota-row');
                    const rowCount = rows.length;

                    console.log('Vanilla JS - Row count:', rowCount);

                    // Check if button is disabled
                    if (button.disabled) {
                        console.log('Button is disabled');
                        return;
                    }

                    if (rowCount > 1) {
                        if (confirm('Apakah Anda yakin ingin menghapus anggota keluarga ini?')) {
                            // Fade out effect
                            row.style.transition = 'opacity 0.3s';
                            row.style.opacity = '0';

                            setTimeout(() => {
                                row.remove();
                                updateDeleteButtonsVanilla();
                                updateRowNumbersVanilla();
                                console.log('Row deleted with vanilla JS');
                            }, 300);
                        }
                    } else {
                        alert('Minimal harus ada 1 anggota keluarga!');
                    }
                }
            });

            // Function untuk update buttons
            function updateDeleteButtonsVanilla() {
                const container = document.getElementById('anggotaContainer');
                const rows = container.querySelectorAll('.anggota-row');
                const deleteButtons = container.querySelectorAll('.hapus-anggota');
                const shouldBeDisabled = rows.length <= 1;

                deleteButtons.forEach(button => {
                    button.disabled = shouldBeDisabled;

                    if (shouldBeDisabled) {
                        button.classList.remove('btn-danger');
                        button.classList.add('btn-secondary');
                        button.title = 'Tidak bisa menghapus anggota terakhir';
                    } else {
                        button.classList.remove('btn-secondary');
                        button.classList.add('btn-danger');
                        button.title = 'Hapus anggota ini';
                    }
                });
            }

            // Function untuk update row numbers
            function updateRowNumbersVanilla() {
                const container = document.getElementById('anggotaContainer');
                const rows = container.querySelectorAll('.anggota-row');

                rows.forEach((row, index) => {
                    const firstCell = row.querySelector('td');
                    if (firstCell) {
                        firstCell.textContent = index + 1;
                    }
                    row.setAttribute('data-index', index);
                });
            }

            // Initialize buttons on load
            setTimeout(updateDeleteButtonsVanilla, 100);
        }
    </script>
</body>
</html>
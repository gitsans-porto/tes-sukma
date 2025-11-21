<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tambah Mutasi Penduduk</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset ('asset/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('asset/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Select2 CSS untuk searchable dropdown -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 Bootstrap 5 Theme -->
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css" rel="stylesheet" />

    <style>
        /* Custom styles untuk conditional form */
        .form-section {
            display: none;
            transition: all 0.3s ease;
        }

        .form-section.active {
            display: block;
        }

        .mutasi-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 500;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .mutasi-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .mutasi-badge.selected {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }

        .badge-lahir {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
        }

        .badge-datang {
            background: linear-gradient(45deg, #17a2b8, #007bff);
            color: white;
        }

        .badge-meninggal {
            background: linear-gradient(45deg, #6c757d, #343a40);
            color: white;
        }

        .badge-pindah {
            background: linear-gradient(45deg, #ffc107, #fd7e14);
            color: white;
        }

        .select2-container--default .select2-selection--single {
            height: 38px;
            padding-top: 3px;
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('penduduk.index') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SISTEM INFORMASI</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('penduduk.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Penduduk</span>
                </a>
            </li>

            <!-- Nav Item - Mutasi -->
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('mutasi.index') }}">
                    <i class="fas fa-fw fa-exchange-alt"></i>
                    <span>Mutasi</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">
                            <i class="fas fa-plus fa-sm text-primary-50"></i> Tambah Mutasi Penduduk
                        </h1>
                        <a href="{{ route('mutasi.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
                        </a>
                    </div>

                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- Content Row -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold">Form Data Mutasi</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('mutasi.store') }}" method="POST" id="mutasiForm">
                                @csrf

                                <!-- Pilih Jenis Mutasi dengan UI Card -->
                                <div class="mb-4">
                                    <label class="form-label font-weight-bold">
                                        <i class="fas fa-tag"></i> Pilih Jenis Mutasi
                                    </label>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <div class="mutasi-badge badge-lahir" data-mutasi="LAHIR">
                                                <i class="fas fa-baby"></i><br>
                                                <strong>Lahir</strong>
                                            </div>
                                            <input type="radio" name="jenis_mutasi" value="LAHIR" class="d-none" id="mutasi_lahir">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="mutasi-badge badge-datang" data-mutasi="DATANG">
                                                <i class="fas fa-sign-in-alt"></i><br>
                                                <strong>Datang</strong>
                                            </div>
                                            <input type="radio" name="jenis_mutasi" value="DATANG" class="d-none" id="mutasi_datang">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="mutasi-badge badge-meninggal" data-mutasi="MENINGGAL">
                                                <i class="fas fa-cross"></i><br>
                                                <strong>Meninggal</strong>
                                            </div>
                                            <input type="radio" name="jenis_mutasi" value="MENINGGAL" class="d-none" id="mutasi_meninggal">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="mutasi-badge badge-pindah" data-mutasi="PINDAH">
                                                <i class="fas fa-sign-out-alt"></i><br>
                                                <strong>Pindah</strong>
                                            </div>
                                            <input type="radio" name="jenis_mutasi" value="PINDAH" class="d-none" id="mutasi_pindah">
                                        </div>
                                    </div>
                                    @error('jenis_mutasi')
                                        <div class="text-danger mt-2">
                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Form Section untuk LAHIR / DATANG (Data Penduduk Baru) -->
                                <div id="formPendudukBaru" class="form-section">
                                    <div class="card border-left-success shadow mb-4">
                                        <div class="card-header">
                                            <h6 class="m-0 font-weight-bold">
                                                <i class="fas fa-user-plus"></i> Data Penduduk Baru
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                                           id="nik" name="nik" value="{{ old('nik') }}"
                                                           placeholder="Nomor Induk Kependudukan (16 digit)" maxlength="16">
                                                    @error('nik')
                                                        <div class="invalid-feedback">
                                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                                        </div>
                                                    @enderror
                                                    <small class="form-text text-muted">
                                                        <i class="fas fa-info-circle"></i> Masukkan 16 digit NIK. Untuk kelahiran bisa dikosongkan untuk generate otomatis.
                                                    </small>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                                           id="nama" name="nama" value="{{ old('nama') }}"
                                                           placeholder="Masukkan nama lengkap">
                                                    @error('nama')
                                                        <div class="invalid-feedback">
                                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                                    <select class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                                            id="jenis_kelamin" name="jenis_kelamin">
                                                        <option value="">Pilih Jenis Kelamin</option>
                                                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                    </select>
                                                    @error('jenis_kelamin')
                                                        <div class="invalid-feedback">
                                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                                        </div>
                                                    @enderror
                                                    <small class="form-text text-muted">
                                                        <i class="fas fa-info-circle"></i> Database akan menyimpan nilai: L (Laki-laki) atau P (Perempuan)
                                                    </small>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                                           id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                                           placeholder="Kota/Kabupaten Kelahiran">
                                                    @error('tempat_lahir')
                                                        <div class="invalid-feedback">
                                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="tgl_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control @error('tgl_lahir') is-invalid @enderror"
                                                           id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir') }}">
                                                    @error('tgl_lahir')
                                                        <div class="invalid-feedback">
                                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="pekerjaan" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror"
                                                           id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}"
                                                           placeholder="Pekerjaan">
                                                    @error('pekerjaan')
                                                        <div class="invalid-feedback">
                                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="hubungan_keluarga" class="form-label">Hubungan Keluarga <span class="text-danger">*</span></label>
                                                    <select class="form-control @error('hubungan_keluarga') is-invalid @enderror"
                                                            id="hubungan_keluarga" name="hubungan_keluarga">
                                                        <option value="">Pilih Hubungan</option>
                                                        <option value="Kepala Keluarga" {{ old('hubungan_keluarga') == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                                                        <option value="Istri" {{ old('hubungan_keluarga') == 'Istri' ? 'selected' : '' }}>Istri</option>
                                                        <option value="Anak" {{ old('hubungan_keluarga') == 'Anak' ? 'selected' : '' }}>Anak</option>
                                                        <option value="Orang Tua" {{ old('hubungan_keluarga') == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                                                        <option value="Lainnya" {{ old('hubungan_keluarga') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                                    </select>
                                                    @error('hubungan_keluarga')
                                                        <div class="invalid-feedback">
                                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="tamatan" class="form-label">Pendidikan <span class="text-danger">*</span></label>
                                                    <select class="form-control @error('tamatan') is-invalid @enderror"
                                                            id="tamatan" name="tamatan">
                                                        <option value="">Pilih Pendidikan</option>
                                                        <option value="Tidak Sekolah" {{ old('tamatan') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                                        <option value="SD" {{ old('tamatan') == 'SD' ? 'selected' : '' }}>SD</option>
                                                        <option value="SMP" {{ old('tamatan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                                        <option value="SMA" {{ old('tamatan') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                                        <option value="D3" {{ old('tamatan') == 'D3' ? 'selected' : '' }}>D3</option>
                                                        <option value="S1" {{ old('tamatan') == 'S1' ? 'selected' : '' }}>S1</option>
                                                        <option value="S2" {{ old('tamatan') == 'S2' ? 'selected' : '' }}>S2</option>
                                                        <option value="S3" {{ old('tamatan') == 'S3' ? 'selected' : '' }}>S3</option>
                                                    </select>
                                                    @error('tamatan')
                                                        <div class="invalid-feedback">
                                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="dusun" class="form-label">Dusun</label>
                                                    <input type="text" class="form-control @error('dusun') is-invalid @enderror"
                                                           id="dusun" name="dusun" value="{{ old('dusun') }}"
                                                           placeholder="Nama Dusun">
                                                    @error('dusun')
                                                        <div class="invalid-feedback">
                                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="kartu_keluarga_id" class="form-label">
                                                        <i class="fas fa-users"></i> Nomor Kartu Keluarga <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-control select2-kk @error('kartu_keluarga_id') is-invalid @enderror"
                                                            id="kartu_keluarga_id" name="kartu_keluarga_id"
                                                            data-placeholder="Cari nomor KK atau nama kepala keluarga...">
                                                        <option value="">Pilih Kartu Keluarga</option>
                                                        @foreach($kartuKeluarga as $kk)
                                                            <option value="{{ $kk->id }}" {{ old('kartu_keluarga_id') == $kk->id ? 'selected' : '' }}>
                                                                {{ $kk->no_kk }} - {{ $kk->penduduk->first()->nama ?? 'Tidak ada Kepala Keluarga' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('kartu_keluarga_id')
                                                        <div class="invalid-feedback">
                                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                                        </div>
                                                    @enderror
                                                    <small class="form-text text-muted">
                                                        <i class="fas fa-search"></i> Ketik untuk mencari nomor KK atau nama kepala keluarga
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Section untuk MENINGGAL / PINDAH (Pilih Penduduk yang Ada) -->
                                <div id="formPendudukAda" class="form-section">
                                    <div class="card border-left-warning shadow mb-4">
                                        <div class="card-header">
                                            <h6 class="m-0 font-weight-bold">
                                                <i class="fas fa-user-check"></i> Pilih Penduduk
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="penduduk_id" class="form-label">
                                                        <i class="fas fa-search"></i> Cari dan Pilih Penduduk <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-control @error('penduduk_id') is-invalid @enderror"
                                                            id="penduduk_id" name="penduduk_id">
                                                        <option value="">Pilih Penduduk</option>
                                                        @foreach($penduduk as $p)
                                                            <option value="{{ $p->id }}" {{ old('penduduk_id') == $p->id ? 'selected' : '' }}>
                                                                {{ $p->nama }} ({{ $p->nik }}) - {{ $p->kartuKeluarga->no_kk ?? 'Tidak ada KK' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('penduduk_id')
                                                        <div class="invalid-feedback">
                                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                                        </div>
                                                    @enderror
                                                    <small class="form-text text-muted">
                                                        <i class="fas fa-info-circle"></i> Hanya penduduk dengan status HIDUP yang muncul dalam daftar.
                                                    </small>
                                                </div>
                                            </div>

                                            <!-- Detail Penduduk yang Dipilih -->
                                            <div id="detailPenduduk" class="alert alert-info d-none">
                                                <h6><i class="fas fa-info-circle"></i> Detail Penduduk Terpilih:</h6>
                                                        <div id="detailContent"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Detail Mutasi (Selalu Muncul) -->
                                <div class="card border-left-primary shadow mb-4">
                                    <div class="card-header">
                                        <h6 class="m-0 font-weight-bold">
                                            <i class="fas fa-file-alt"></i> Detail Mutasi
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="tanggal_kejadian" class="form-label" id="tanggal_label">
                                                    <i class="fas fa-calendar"></i> Tanggal Kejadian <span class="text-danger">*</span>
                                                </label>
                                                <input type="date" class="form-control @error('tanggal_kejadian') is-invalid @enderror"
                                                       id="tanggal_kejadian" name="tanggal_kejadian" value="{{ old('tanggal_kejadian') }}">
                                                @error('tanggal_kejadian')
                                                    <div class="invalid-feedback">
                                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                                    </div>
                                                @enderror
                                                <small class="form-text text-muted" id="tanggal_hint">
                                                    <i class="fas fa-info-circle"></i> Tanggal terjadinya peristiwa mutasi
                                                </small>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="lokasi_detail" class="form-label">Lokasi Detail</label>
                                                <input type="text" class="form-control @error('lokasi_detail') is-invalid @enderror"
                                                       id="lokasi_detail" name="lokasi_detail" value="{{ old('lokasi_detail') }}"
                                                       placeholder="Contoh: RSUD Kota, Puskesmas, Desa Sebelah, dll">
                                                @error('lokasi_detail')
                                                    <div class="invalid-feedback">
                                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="keterangan" class="form-label">Keterangan</label>
                                                <textarea class="form-control @error('keterangan') is-invalid @enderror"
                                                          id="keterangan" name="keterangan" rows="3"
                                                          placeholder="Masukkan keterangan tambahan jika ada">{{ old('keterangan') }}</textarea>
                                                @error('keterangan')
                                                    <div class="invalid-feedback">
                                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary btn-lg px-5" id="submitBtn" disabled>
                                            <i class="fas fa-save"></i> Simpan Data Mutasi
                                        </button>
                                        <a href="{{ route('mutasi.index') }}" class="btn btn-secondary btn-lg px-5 ml-2">
                                            <i class="fas fa-times"></i> Batal
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Sistem Informasi Manajemen {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('asset/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('asset/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('asset/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('asset/js/sb-admin-2.min.js') }}"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- JavaScript untuk Conditional Rendering -->
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 untuk dropdown penduduk
            $('#penduduk_id').select2({
                placeholder: 'Cari nama atau NIK penduduk...',
                allowClear: true,
                width: '100%',
                theme: 'bootstrap4'
            });

            // Inisialisasi Select2 untuk dropdown Kartu Keluarga
            $('.select2-kk').select2({
                placeholder: $(this).data('placeholder') || 'Cari nomor KK atau nama kepala keluarga...',
                allowClear: true,
                width: '100%',
                theme: 'bootstrap4',
                // Custom matcher untuk pencarian lebih baik
                matcher: function(params, data) {
                    // If there are no search terms, return all of the data
                    if ($.trim(params.term) === '') {
                        return data;
                    }

                    // Skip if there is no 'children' property
                    if (typeof data.children === 'undefined') {
                        return null;
                    }

                    // `data.children` contains the actual options that we are matching against
                    var filteredChildren = [];
                    $.each(data.children, function (idx, child) {
                        var term = params.term.toUpperCase();
                        var text = child.text.toUpperCase();

                        // Cari berdasarkan nomor KK atau nama kepala keluarga
                        if (text.indexOf(term) > -1) {
                            filteredChildren.push(child);
                        }
                    });

                    // If we matched any of the children, then set the matched children on the group
                    // and return the group object
                    if (filteredChildren.length) {
                        data.children = filteredChildren;
                        return data;
                    }

                    // Return `null` if the term should not be displayed
                    return null;
                }
            });

            // Data penduduk untuk detail (bisa dipindahkan ke API endpoint)
            const dataPenduduk = {
                @foreach($penduduk as $p)
                    '{{ $p->id }}': {
                        nama: '{{ $p->nama }}',
                        nik: '{{ $p->nik }}',
                        no_kk: '{{ $p->kartuKeluarga->no_kk ?? 'Tidak ada KK' }}',
                        usia: '{{ $p->usia }}',
                        pekerjaan: '{{ $p->pekerjaan }}',
                        dusun: '{{ $p->dusun ?? 'Tidak diketahui' }}'
                    }@if(!$loop->last),@endif
                @endforeach
            };

            // Handle click pada badge jenis mutasi
            $('.mutasi-badge').click(function() {
                const mutasiType = $(this).data('mutasi');

                // Reset semua badge
                $('.mutasi-badge').removeClass('selected');
                $('.form-section').removeClass('active');
                $('#submitBtn').prop('disabled', false);

                // Select badge yang diklik
                $(this).addClass('selected');
                $(`#mutasi_${mutasiType.toLowerCase()}`).prop('checked', true);

                // Show form section yang sesuai
                if (mutasiType === 'LAHIR' || mutasiType === 'DATANG') {
                    $('#formPendudukBaru').addClass('active');
                    // Enable required fields untuk penduduk baru
                    $('#formPendudukBaru input, #formPendudukBaru select').prop('required', true);
                    $('#formPendudukAda input, #formPendudukAda select').prop('required', false);
                    $('#penduduk_id').prop('required', false);
                } else if (mutasiType === 'MENINGGAL' || mutasiType === 'PINDAH') {
                    $('#formPendudukAda').addClass('active');
                    // Enable required fields untuk penduduk yang ada
                    $('#penduduk_id').prop('required', true);
                    $('#formPendudukBaru input, #formPendudukBaru select').prop('required', false);
                }

                // Update form title dan deskripsi
                updateFormInfo(mutasiType);
            });

            // Handle change pada select penduduk
            $('#penduduk_id').change(function() {
                const pendudukId = $(this).val();
                const detailDiv = $('#detailPenduduk');
                const detailContent = $('#detailContent');

                if (pendudukId && dataPenduduk[pendudukId]) {
                    const penduduk = dataPenduduk[pendudukId];
                    detailContent.html(`
                        <div class="row">
                            <div class="col-md-6"><strong>Nama:</strong> ${penduduk.nama}</div>
                            <div class="col-md-6"><strong>NIK:</strong> ${penduduk.nik}</div>
                            <div class="col-md-6"><strong>No. KK:</strong> ${penduduk.no_kk}</div>
                            <div class="col-md-6"><strong>Usia:</strong> ${penduduk.usia} tahun</div>
                            <div class="col-md-6"><strong>Pekerjaan:</strong> ${penduduk.pekerjaan}</div>
                            <div class="col-md-6"><strong>Dusun:</strong> ${penduduk.dusun}</div>
                        </div>
                    `);
                    detailDiv.removeClass('d-none');
                } else {
                    detailDiv.addClass('d-none');
                }
            });

            // Function untuk update form info
            function updateFormInfo(mutasiType) {
                const infoTexts = {
                    'LAHIR': 'Untuk mencatat kelahiran penduduk baru. Isi data lengkap penduduk yang baru lahir.',
                    'DATANG': 'Untuk mencatat penduduk baru yang pindah masuk ke desa. Isi data lengkap penduduk yang datang.',
                    'MENINGGAL': 'Untuk mencatat kematian penduduk. Pilih penduduk yang meninggal dari daftar.',
                    'PINDAH': 'Untuk mencatat penduduk yang pindah keluar dari desa. Pilih penduduk yang pindah dari daftar.'
                };

                // Update submit button text
                const buttonTexts = {
                    'LAHIR': 'Simpan Data Kelahiran',
                    'DATANG': 'Simpan Data Kedatangan',
                    'MENINGGAL': 'Simpan Data Kematian',
                    'PINDAH': 'Simpan Data Kepindahan'
                };

                // Dynamic label update untuk tanggal field
                const dateLabels = {
                    'LAHIR': {
                        label: '<i class="fas fa-baby"></i> Tanggal Kelahiran',
                        hint: '<i class="fas fa-info-circle"></i> Tanggal kelahiran penduduk (tercantum pada akta kelahiran)'
                    },
                    'DATANG': {
                        label: '<i class="fas fa-sign-in-alt"></i> Tanggal Kedatangan',
                        hint: '<i class="fas fa-info-circle"></i> Tanggal penduduk resmi pindah masuk ke desa'
                    },
                    'MENINGGAL': {
                        label: '<i class="fas fa-cross"></i> Tanggal Meninggal',
                        hint: '<i class="fas fa-info-circle"></i> Tanggal kematian (sesuai surat keterangan kematian)'
                    },
                    'PINDAH': {
                        label: '<i class="fas fa-sign-out-alt"></i> Tanggal Pindah',
                        hint: '<i class="fas fa-info-circle"></i> Tanggal penduduk resmi pindah keluar dari desa'
                    }
                };

                // Update tanggal label dan hint
                const dateInfo = dateLabels[mutasiType] || dateLabels['PINDAH'];
                $('#tanggal_label').html(`${dateInfo.label} <span class="text-danger">*</span>`);
                $('#tanggal_hint').html(dateInfo.hint);

                // Update submit button text
                $('#submitBtn').html(`<i class="fas fa-save"></i> ${buttonTexts[mutasiType]}`);
            }

            // Form validation submit
            $('#mutasiForm').submit(function(e) {
                const jenisMutasi = $('input[name="jenis_mutasi"]:checked').val();

                if (!jenisMutasi) {
                    e.preventDefault();
                    alert('Silakan pilih jenis mutasi terlebih dahulu!');
                    return false;
                }

                if ((jenisMutasi === 'MENINGGAL' || jenisMutasi === 'PINDAH') && !$('select[name="penduduk_id"]').val()) {
                    e.preventDefault();
                    alert('Silakan pilih penduduk yang akan dimutasikan!');
                    return false;
                }

                // Add confirmation
                const confirmMessages = {
                    'LAHIR': 'Apakah Anda yakin ingin menyimpan data kelahiran ini?',
                    'DATANG': 'Apakah Anda yakin ingin menyimpan data kedatangan ini?',
                    'MENINGGAL': 'Apakah Anda yakin ingin mencatat kematian penduduk ini? Status penduduk akan berubah menjadi MENINGGAL.',
                    'PINDAH': 'Apakah Anda yakin ingin mencatat kepindahan penduduk ini? Status penduduk akan berubah menjadi PINDAH.'
                };

                if (!confirm(confirmMessages[jenisMutasi])) {
                    e.preventDefault();
                    return false;
                }
            });

            // Auto-generate NIK untuk kelahiran (jika diperlukan)
            $('#mutasi_lahir').click(function() {
                if (!$('#nik').val()) {
                    // Bisa auto-generate atau kosongkan
                    $('#nik').attr('placeholder', 'NIK akan digenerate otomatis jika dikosongkan');
                }
            });
        });
    </script>

</body>

</html>
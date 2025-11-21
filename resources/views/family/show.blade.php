<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Detail Keluarga - {{ $kartuKeluarga->no_kk }}</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset ('asset/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="{{ asset('asset/css/sb-admin-2.min.css') }}" rel="stylesheet">

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
            <li class="nav-item">
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
                        <h1 class="h3 mb-0 text-gray-800">Detail Keluarga</h1>
                        <div>
                            <a href="{{ route('penduduk.family.edit', $kartuKeluarga->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm mr-2">
                                <i class="fas fa-edit fa-sm text-white-50"></i> Edit Keluarga
                            </a>
                            <a href="{{ route('penduduk.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <!-- Kartu Keluarga Information -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 bg-primary">
                            <h6 class="m-0 font-weight-bold text-white">
                                <i class="fas fa-id-card mr-2"></i>Informasi Kartu Keluarga
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="text-primary">Nomor KK</h5>
                                    <p class="h4">{{ $kartuKeluarga->no_kk }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="text-primary">Kategori Sejahtera</h5>
                                    <p class="h4">{{ $kartuKeluarga->kategori_sejahtera ?: '-' }}</p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <strong>Jenis Bangunan:</strong> {{ $kartuKeluarga->jenis_bangunan ?: '-' }}
                                </div>
                                <div class="col-md-4">
                                    <strong>Pemakaian Air:</strong> {{ $kartuKeluarga->pemakaian_air ?: '-' }}
                                </div>
                                <div class="col-md-4">
                                    <strong>Jenis Bantuan:</strong> {{ $kartuKeluarga->jenis_bantuan ?: '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Anggota Keluarga -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 bg-info">
                            <h6 class="m-0 font-weight-bold text-white">
                                <i class="fas fa-users mr-2"></i>Anggota Keluarga ({{ $kartuKeluarga->penduduk->count() }} orang)
                            </h6>
                        </div>
                        <div class="card-body">
                            @if($kartuKeluarga->penduduk->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-primary">
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>Nama Lengkap</th>
                                                <th>NIK</th>
                                                <th>Hubungan</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Tempat Lahir</th>
                                                <th>Tanggal Lahir</th>
                                                <th>Usia</th>
                                                <th>Pekerjaan</th>
                                                <th>Pendidikan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $nomor = 1;
                                            @endphp
                                            @foreach($kartuKeluarga->penduduk as $anggota)
                                                <tr>
                                                    <td class="text-center">{{ $nomor++ }}</td>
                                                    <td>
                                                        <strong>{{ $anggota->nama }}</strong>
                                                        @if($anggota->hubungan_keluarga == 'Kepala Keluarga')
                                                            <span class="badge badge-primary ml-2">KK</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $anggota->nik }}</td>
                                                    <td>
                                                        <span class="badge badge-info">
                                                            {{ $anggota->hubungan_keluarga }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {{ $anggota->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                        <i class="fas fa-{{ $anggota->jenis_kelamin == 'L' ? 'mars' : 'venus' }} text-{{ $anggota->jenis_kelamin == 'L' ? 'primary' : 'danger' }} ml-1"></i>
                                                    </td>
                                                    <td>{{ $anggota->tempat_lahir }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($anggota->tgl_lahir)->format('d/m/Y') }}</td>
                                                    <td>
                                                        <span class="badge badge-{{ $anggota->usia < 18 ? 'warning' : 'success' }}">
                                                            {{ $anggota->usia }} tahun
                                                        </span>
                                                    </td>
                                                    <td>{{ $anggota->pekerjaan }}</td>
                                                    <td>
                                                        <small class="text-muted">{{ $anggota->tamatan }}</small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Statistik Keluarga -->
                                <div class="row mt-4">
                                    <div class="col-md-3">
                                        <div class="card border-left-primary shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Anggota</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kartuKeluarga->penduduk->count() }}</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="card border-left-success shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Laki-laki</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kartuKeluarga->penduduk->where('jenis_kelamin', 'L')->count() }}</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-mars fa-2x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="card border-left-danger shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Perempuan</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kartuKeluarga->penduduk->where('jenis_kelamin', 'P')->count() }}</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-venus fa-2x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="card border-left-warning shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Anak-anak</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kartuKeluarga->penduduk->where('usia', '<', 18)->count() }}</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-child fa-2x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-users fa-4x text-gray-300 mb-3"></i>
                                    <h5 class="text-gray-500">Tidak ada anggota keluarga</h5>
                                    <p class="text-gray-400">Data anggota keluarga belum tersedia.</p>
                                </div>
                            @endif
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

</body>

</html>
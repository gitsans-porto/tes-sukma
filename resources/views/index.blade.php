<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Testing</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset ('asset/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('asset/css/sb-admin-2.min.css') }}" rel="stylesheet">

    

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">TESTING</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="/dashboard">
                    <span>Dashboard</span>
                </a>
                <a class="nav-link" href="/mutasi">
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

                    <!-- Topbar Search -->
                    {{-- <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> --}}

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->

                        <!-- Nav Item - Messages -->
                        

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                                {{-- <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg"> --}}
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
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
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

                    <h1 class="h3 mb-4 text-gray-800">Tabel Penduduk</h1>
                    <div class="mb-3    ">
                        <a href="{{ route('penduduk.create') }}">
                            <button class="btn btn-danger">Tambah Data</button>
                        </a>
                    </div>

                    <!-- Statistics Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Keluarga</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $groupedPenduduk->count() }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Penduduk</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $groupedPenduduk->sum(function($group) { return $group->count(); }) }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Rata-rata Anggota/KK</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{-- Safe calculation: Prevent division by zero --}}
                                                @php
                                                    $totalPenduduk = $groupedPenduduk->sum(function($group) { return $group->count(); });
                                                    $totalKK = $groupedPenduduk->count();
                                                    $rataRataAnggota = $totalKK > 0 ? round($totalPenduduk / $totalKK, 1) : 0;
                                                @endphp
                                                {{ $rataRataAnggota }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Penduduk Berdasarkan Kartu Keluarga</h6>
                        </div>
                        <div class="card-body">
                            @if($groupedPenduduk->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="pendudukTable">
                                        <thead class="table-primary">
                                            <tr>
                                                <th style="width: 60px;" class="text-center align-middle">No</th>
                                                <th style="width: 120px;" class="text-center align-middle">No. KK</th>
                                                <th class="align-middle">Nama</th>
                                                <th class="align-middle">NIK</th>
                                                <th class="align-middle">Peran Keluarga</th>
                                                <th class="align-middle">Jenis Kelamin</th>
                                                <th class="align-middle">Tempat Lahir</th>
                                                <th class="align-middle">Tanggal Lahir</th>
                                                <th style="width: 120px;" class="text-center align-middle">Aksi Keluarga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $nomor = $no;
                                            @endphp

                                            @foreach($groupedPenduduk as $noKk => $anggotaKeluarga)
                                                @php
                                                    $jumlahAnggota = $anggotaKeluarga->count();
                                                    $isFirstRow = true;
                                                    $kartuKeluargaId = $anggotaKeluarga->first()->kartu_keluarga_id;
                                                @endphp

                                                @foreach($anggotaKeluarga as $penduduk)
                                                    <tr>
                                                        @if($isFirstRow)
                                                            <td rowspan="{{ $jumlahAnggota }}" class="text-center align-middle valign-middle" style="vertical-align: middle;">
                                                                {{ $nomor }}
                                                            </td>
                                                            <td rowspan="{{ $jumlahAnggota }}" class="text-center align-middle valign-middle" style="vertical-align: middle;">
                                                                <strong>{{ $penduduk->no_kk }}</strong>
                                                            </td>
                                                        @endif

                                                        <td class="align-middle">
                                                            {{ $penduduk->nama }}
                                                            @if($penduduk->peran_keluarga == 'Kepala Keluarga')
                                                                <span class="badge badge-primary ml-2">KK</span>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">{{ $penduduk->nik }}</td>
                                                        <td class="align-middle">{{ $penduduk->peran_keluarga }}</td>
                                                        <td class="align-middle">
                                                            {{ $penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                        </td>
                                                        <td class="align-middle">{{ $penduduk->tempat_lahir }}</td>
                                                        <td class="align-middle">{{ \Carbon\Carbon::parse($penduduk->tgl_lahir)->format('d/m/Y') }}</td>
                                                        @if($isFirstRow)
                                                            <td rowspan="{{ $jumlahAnggota }}" class="text-center align-middle valign-middle" style="vertical-align: middle;">
                                                                <div class="btn-group-vertical" role="group">
                                                                    <a href="{{ route('penduduk.family.show', $kartuKeluargaId) }}" class="btn btn-sm btn-info mb-1" title="Detail Keluarga">
                                                                        <i class="fas fa-users"></i> Detail
                                                                    </a>
                                                                    <a href="{{ route('penduduk.family.edit', $kartuKeluargaId) }}" class="btn btn-sm btn-warning mb-1" title="Edit Keluarga">
                                                                        <i class="fas fa-edit"></i> Edit
                                                                    </a>
                                                                    <form action="{{ route('penduduk.family.destroy', $kartuKeluargaId) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus seluruh data keluarga ini?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus Keluarga">
                                                                            <i class="fas fa-trash"></i> Hapus
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                    @php
                                                        $isFirstRow = false;
                                                    @endphp
                                                @endforeach

                                                @php
                                                    $nomor++;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-users fa-4x text-gray-300 mb-3"></i>
                                    <h5 class="text-gray-500">Belum ada data penduduk</h5>
                                    <p class="text-gray-400">Tambahkan data penduduk untuk melihat informasi di sini.</p>
                                    <a href="{{ route('penduduk.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Tambah Data Pertama
                                    </a>
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
                        <span>Copyright &copy; Your Website 2020</span>
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
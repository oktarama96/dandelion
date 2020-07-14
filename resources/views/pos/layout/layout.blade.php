<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>@yield('title-page')</title>

  <!-- Custom fonts for this template-->
  <link href="{{ asset('/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ asset('/css/sb-admin-2.min.css') }}" rel="stylesheet">

  @yield('add-css')

</head>

<body id="page-top" @if (Request::path() === 'pos/pages/pos' || Request::path() === 'pos/pages/transaksi') {{ 'class=sidebar-toggled' }} @else {{ '' }} @endif>

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion @if (Request::path() === 'pos/pages/pos' || Request::path() === 'pos/pages/transaksi') {{ 'toggled' }} @else {{ '' }} @endif" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('index') }}">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Dandelion</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item {{ Request::path() == 'pos' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('index') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Master Data
      </div>

      <!-- Nav Item -->
      <li class="nav-item {{ Request::path() === 'pos/pages/pengguna' ? 'active' : '' }}">
        <a class="nav-link" href="/pos/pages/pengguna">
          <i class="fas fa-fw fa-table"></i>
          <span>Data Pengguna</span></a>
      </li>

      <!-- Nav Item -->
      <li class="nav-item {{ Request::path() === 'pos/pages/pelanggan' ? 'active' : '' }}">
        <a class="nav-link" href="/pos/pages/pelanggan">
          <i class="fas fa-fw fa-table"></i>
          <span>Data Pelanggan</span></a>
      </li>

      <!-- Nav Item -->
      <li class="nav-item {{ Request::path() === 'pos/pages/kategoriproduk' ? 'active' : '' }}">
        <a class="nav-link" href="/pos/pages/kategoriproduk">
          <i class="fas fa-fw fa-table"></i>
          <span>Data Kategori Produk</span></a>
      </li>

      <!-- Nav Item -->
      <li class="nav-item {{ Request::path() === 'pos/pages/warnaproduk' ? 'active' : '' }}">
        <a class="nav-link" href="/pos/pages/warnaproduk">
          <i class="fas fa-fw fa-table"></i>
          <span>Data Warna Produk</span></a>
      </li>

      <!-- Nav Item -->
      <li class="nav-item {{ Request::path() === 'pos/pages/ukuranproduk' ? 'active' : '' }}">
        <a class="nav-link" href="/pos/pages/ukuranproduk">
          <i class="fas fa-fw fa-table"></i>
          <span>Data Ukuran Produk</span></a>
      </li>

      <!-- Nav Item -->
      <li class="nav-item {{ Request::path() === 'pos/pages/produk' ? 'active' : '' }}">
        <a class="nav-link" href="/pos/pages/produk">
          <i class="fas fa-fw fa-table"></i>
          <span>Data Produk</span></a>
      </li>

      <!-- Nav Item -->
      <li class="nav-item {{ Request::path() === 'pos/pages/kupondiskon' ? 'active' : '' }}">
        <a class="nav-link" href="/pos/pages/kupondiskon">
          <i class="fas fa-fw fa-table"></i>
          <span>Data Kupon Diskon</span></a>
      </li>
      
      <!-- Nav Item -->
      <li class="nav-item {{ Request::path() === 'pos/pages/transaksi' ? 'active' : '' }}">
        <a class="nav-link" href="/pos/pages/transaksi">
          <i class="fas fa-fw fa-table"></i>
          <span>Data Transaksi</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Application
      </div>

      <!-- Nav Item -->
      <li class="nav-item {{ Request::path() === 'pos/pages/pos' ? 'active' : '' }}">
        <a class="nav-link" href="/pos/pages/pos">
          <i class="fas fa-fw fa-cash-register"></i>
          <span>Point Of Sale</span></a>
      </li>

      <!-- Nav Item -->
      <li class="nav-item">
        <a class="nav-link" href="/">
          <i class="fas fa-fw fa-globe-asia"></i>
          <span>Online Shop</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Report
      </div>

      <!-- Nav Item -->
      <li class="nav-item {{ Request::path() === 'pos/pages/report/transaksi' ? 'active' : '' }}">
        <a class="nav-link" href="/pos/pages/report/transaksi">
          <i class="fas fa-fw fa-table"></i>
          <span>Laporan Transaksi</span></a>
      </li>

      <!-- Nav Item -->
      <li class="nav-item {{ Request::path() === 'pos/pages/report/stokproduk' ? 'active' : '' }}">
        <a class="nav-link" href="/pos/pages/report/stokproduk">
          <i class="fas fa-fw fa-table"></i>
          <span>Laporan Stok Produk</span></a>
      </li>

      <!-- Nav Item -->
      <li class="nav-item {{ Request::path() === 'pos/pages/pos' ? 'active' : '' }}">
        <a class="nav-link" href="/pos/pages/pos">
          <i class="fas fa-fw fa-table"></i>
          <span>Laporan Keuntungan</span></a>
      </li>

      <!-- Nav Item -->
      <li class="nav-item {{ Request::path() === 'pos/pages/report/stokhabis' ? 'active' : '' }}">
        <a class="nav-link" href="/pos/pages/report/stokhabis">
          <i class="fas fa-fw fa-table"></i>
          <span>Laporan Stok Habis</span></a>
      </li>

      <!-- Nav Item -->
      <li class="nav-item {{ Request::path() === 'pos/pages/report/stoklaris' ? 'active' : '' }}">
        <a class="nav-link" href="/pos/pages/report/stoklaris">
          <i class="fas fa-fw fa-table"></i>
          <span>Laporan Stok Paling Laris</span></a>
      </li>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('profile') }}">
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

          @yield('content')

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Dandelion Fashion Shop 2020</span>
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
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Anda yakin ingin logout ?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="/pos/login">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('/js/sb-admin-2.min.js') }}"></script>

  <!-- Sweet Alert -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  @yield('add-js')

</body>

</html>

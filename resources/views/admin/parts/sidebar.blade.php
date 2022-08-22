<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('landing-admin') }}" class="brand-link">
      <!-- <img src="{{ asset('assets') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
      <span class="brand-text font-weight-light">Sistem Akuntan</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('assets') }}/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth()->user()->nama }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-header">Main</li>
          <li class="nav-item">
            <a href="{{ route('landing-admin') }}" class="nav-link {{ Request::is('landing_admin') ? 'active' : '' }}">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item {{ Request::is('master/*') ? 'menu-open' : '' }}"> <!-- menu-open -->
            <a href="#" class="nav-link {{ Request::is('master/*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('kategori') }}" class="nav-link {{ Request::is('master/kategori') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kategori</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('produk') }}" class="nav-link {{ Request::is('master/produk') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Produk</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item {{ Request::is('administrasi/*') ? 'menu-open' : '' }}"> <!-- menu-open -->
            <a href="#" class="nav-link {{ Request::is('administrasi/*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Administrasi
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item" {{ Auth()->user()->level == 'ADMIN' ? '' : 'hidden'  }}>
                <a href="{{ route('adm_pemesanan') }}" class="nav-link {{ Request::is('administrasi/pemesanan') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pemesanan</p>
                </a>
              </li>
              <li class="nav-item" {{ Auth()->user()->level == 'ADMIN' ? 'hidden' : ''  }}>
                <a href="{{ route('adm_pemasukan') }}" class="nav-link {{ Request::is('administrasi/pemasukan') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pemasukan</p>
                </a>
              </li>
              <li class="nav-item" {{ Auth()->user()->level == 'ADMIN' ? 'hidden' : ''  }}>
                <a href="{{ route('adm_pengeluaran') }}" class="nav-link {{ Request::is('administrasi/pengeluaran') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengeluaran</p>
                </a>
              </li>
              <li class="nav-item" {{ Auth()->user()->level == 'ADMIN' ? 'hidden' : ''  }}>
                <a href="{{ route('adm_piutang') }}" class="nav-link {{ Request::is('administrasi/piutang') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Piutang</p>
                </a>
              </li>
              <li class="nav-item" {{ Auth()->user()->level == 'ADMIN' ? 'hidden' : ''  }}>
                <a href="{{ route('adm_jurnal') }}" class="nav-link {{ Request::is('administrasi/jurnal') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jurnal</p>
                </a>
              </li>
              <li class="nav-item" {{ Auth()->user()->level == 'ADMIN' ? 'hidden' : ''  }}>
                <a href="{{ route('adm_neraca') }}" class="nav-link {{ Request::is('administrasi/neraca') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Neraca</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- <li class="nav-item">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Laporan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kategori</p>
                </a>
              </li>
            </ul>
          </li> -->
          <li class="nav-header">System</li>
          <li class="nav-item" {{ Auth()->user()->level == 'MANAGER' ? '' : 'hidden' }}>
            <a href="{{ route('update_saldo') }}" class="nav-link {{ Request::is('sys/update_saldo') ? 'active' : '' }}">
              <i class="nav-icon fas fa-edit"></i>
              <p>Update Saldo Kas</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('users') }}" class="nav-link {{ Request::is('sys/users') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user"></i>
              <p>Users</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
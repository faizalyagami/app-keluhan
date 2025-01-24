<!-- Sidenav -->
<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="{{ route('dashboard')}}">
          <h2 class="text-primary text-uppercase">Keluhan Mahasiswa</h2>
          <p class="text-muted">Anda Login sebagai: <br><strong>{{ $loggedPetugas ? $loggedPetugas->nama_petugas : 'Guest' }}</strong></p>
        </a>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav mt-4">
            <li class="nav-item">
              <a class="nav-link {{ (request()->segment(2) == 'dashboard') ? 'active' : '' }}" href="{{ route('dashboard')}}">
                <i class="fas fa-tv text-primary"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            <li class="nav-item nav-with-child">
                <a class="nav-link {{ (request()->segment(2) == 'keluhan') ? 'active' : '' }}" href="#">
                  <i class="fas fa-bullhorn text-orange"></i> Keluhan
                  <i class="text-right fas fa-chevron-down"></i>
                </a>

                <ul class="nav-item-child">
                  
                  @if (Auth::guard('admin')->user()->roles == 'admin')
                    <li class="nav-item">
                      <a class="nav-link {{ (request()->segment(2) == 'keluhan/0') ? 'active' : '' }}" href="{{ route('keluhan.index', '0')}}">
                          <i class="fas fa-clipboard-check text-info"></i> Verifikasi & Validasi
                      </a>
                    </li> 
                  @endif
                  
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('keluhan.index', 'proses')}}">
                        <i class="fas fa-sync text-yellow"></i> Sedang Diproses
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('keluhan.index', 'selesai')}}">
                        <i class="fas fa-check text-success"></i> Selesai
                    </a>
                  </li>
                </ul>
              </li>

            @if (Auth::guard('admin')->user()->roles === 'admin')
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('laporan.index')}}">
                    <i class="fas fa-file-alt text-green"></i>
                    <span class="nav-link-text">Laporan</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('mahasiswa.index')}}">
                    <i class="fas fa-users text-default"></i>
                    <span class="nav-link-text">Mahasiswa</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('petugas.index')}} ">
                    <i class="fas fa-users-cog text-info"></i>
                    <span class="nav-link-text">Petugas</span>
                  </a>
                </li>
            @endif
          </ul>
        </div>
      </div>
    </div>
  </nav>

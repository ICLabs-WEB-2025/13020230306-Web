<div class="sidebar" data-background-color="dark"> {{-- Anda bisa mengganti data-background-color dengan "white", "black", dll. --}}
    <div class="sidebar-logo">
        <!-- Logo Sidebar -->
        <a href="{{ route('admin.dashboard') }}" class="logo">
            {{-- Jika punya logo SVG/gambar: --}}
            {{-- <img src="{{ asset('kaiadmin/assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand" height="20"/> --}}
            <span class="text-light ms-1 fw-bold fs-5">ADMIN PENITIPAN</span>
        </a>
        <div class="sidebar-toggler sidenav-toggler">
            <span class="navbar-toggler-icon"></span>
        </div>
        <button class="btn btn-minimize">
            <i class="gg-menu-left"></i>
        </button>
        <!-- End Logo Sidebar -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                {{-- Dasbor Utama Admin --}}
                <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="collapsed" aria-expanded="false">
                        <i class="fas fa-tachometer-alt"></i>
                        <p>Dasbor Utama</p>
                    </a>
                </li>

                {{-- Judul Seksi Menu --}}
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Manajemen Utama</h4>
                </li>

                {{-- Menu Kelola Penitipan Hewan --}}
                <li class="nav-item {{ request()->routeIs('admin.pet-boardings.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.pet-boardings.index') }}">
                        <i class="fas fa-paw"></i>
                        <p>Kelola Penitipan</p>
                    </a>
                </li>

                {{-- Contoh Menu Manajemen Pengguna (jika ada) --}}
                {{--
                <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#usersManagement" class="collapsed" aria-expanded="false">
                        <i class="fas fa-users"></i>
                        <p>Manajemen Pengguna</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.users.*') ? 'show' : '' }}" id="usersManagement">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                                <a href="#"> <span class="sub-item">Daftar Pengguna</span> </a>
                            </li>
                            <li class="{{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
                                <a href="#"> <span class="sub-item">Tambah Pengguna</span> </a>
                            </li>
                        </ul>
                    </div>
                </li>
                --}}

                {{-- Contoh Menu Laporan (jika ada) --}}
                {{--
                <li class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fas fa-chart-line"></i>
                        <p>Laporan</p>
                    </a>
                </li>
                --}}

                {{-- Menu Logout (biasanya di akhir atau di header) --}}
                <li class="nav-item mt-auto mb-2"> {{-- mt-auto untuk mendorong ke bawah --}}
                     <a href="{{ route('logout') }}"
                         onclick="event.preventDefault(); document.getElementById('logout-form-admin-sidebar').submit();">
                          <i class="fas fa-sign-out-alt"></i>
                         <p>Logout</p>
                     </a>
                     <form id="logout-form-admin-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">
                         @csrf
                     </form>
                </li>
            </ul>
        </div>
    </div>
</div>
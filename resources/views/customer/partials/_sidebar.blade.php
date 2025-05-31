<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Sidebar -->
        <a href="{{ route('customer.dashboard') }}" class="logo">
            {{-- <img src="{{ asset('kaiadmin/assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand" height="20"/> --}}
             <span class="text-light ms-2 fw-bold">{{ config('app.name', 'Pet Care') }}</span>
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
                <li class="nav-item {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('customer.dashboard') }}" class="collapsed" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <p>Dasbor Utama</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Penitipan Hewan</h4>
                </li>
                <li class="nav-item {{ request()->routeIs('customer.pet-boarding.create') ? 'active' : '' }}">
                    <a href="{{ route('customer.pet-boarding.create') }}">
                        <i class="fas fa-paw"></i> <!-- Ganti dengan ikon yang sesuai -->
                        <p>Formulir Penitipan</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('customer.pet-boarding.index') ? 'active' : '' }}">
                    <a href="{{ route('customer.pet-boarding.index') }}">
                        <i class="fas fa-history"></i> <!-- Ganti dengan ikon yang sesuai -->
                        <p>Riwayat Penitipan</p>
                    </a>
                </li>

                <li class="nav-item">
                     <a href="{{ route('logout') }}"
                         onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                          <i class="fas fa-sign-out-alt"></i>
                         <p>Logout</p>
                     </a>
                     <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">
                         @csrf
                     </form>
                </li>
            </ul>
        </div>
    </div>
</div>
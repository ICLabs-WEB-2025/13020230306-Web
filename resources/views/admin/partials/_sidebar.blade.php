<div class="sidebar" data-background-color="white"> 
    <div class="sidebar-logo">
 
        <a href="{{ route('admin.dashboard') }}" class="logo">
  
            <span class="text-dark ms-1 fw-bold fs-5"></span>
        </a>
        <div class="sidebar-toggler sidenav-toggler">
    
        </div>
     
            <i class="gg-menu-left"></i>
        </button>
        <!-- End Logo Sidebar -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-success">
               
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
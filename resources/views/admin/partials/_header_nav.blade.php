<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
    <div class="container-fluid">
     
        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
        
            <li class="nav-item topbar-user dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                    <div class="avatar-sm">
                       
                        <img src="{{ asset('kaiadmin/assets/img/profile.jpg') }}" alt="Profil Admin" class="avatar-img rounded-circle"/>
                    </div>
                    <span class="profile-username">
                        <span class="op-7">Halo,</span>
                        <span class="fw-bold">{{ Auth::user()->name }}</span>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                        <li>
                            <div class="user-box">
                                <div class="avatar-lg">
                                    <img src="{{ asset('kaiadmin/assets/img/profile.jpg') }}" alt="image profile" class="avatar-img rounded"/>
                                </div>
                                <div class="u-text">
                                    <h4>{{ Auth::user()->name }}</h4>
                                    <p class="text-muted">{{ Auth::user()->email }}</p>
                                    <p class="text-muted"><small>Peran: {{ ucfirst(Auth::user()->role) }}</small></p>
                                    {{-- <a href="#" class="btn btn-xs btn-secondary btn-sm">Lihat Profil</a> --}}
                                </div>
                            </div>
                        </li>
                        <li>
                            {{-- <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Profil Saya</a>
                            <a class="dropdown-item" href="#">Pengaturan Akun</a> --}}
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form-admin-header').submit();">
                                Logout
                            </a>
                            <form id="logout-form-admin-header" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </div>
                </ul>
            </li>
        </ul>
    </div>
</nav>
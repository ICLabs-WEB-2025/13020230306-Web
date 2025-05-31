<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
    <div class="container-fluid">
        {{-- Tombol Toggle Sidebar untuk tampilan mobile (opsional, tergantung struktur template) --}}
        {{-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button> --}}

        {{-- Navigasi Kiri Header (Bisa untuk Search, dll.) --}}
        {{--
        <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
            <div class="input-group">
                <div class="input-group-prepend">
                    <button type="submit" class="btn btn-search pe-1">
                        <i class="fa fa-search search-icon"></i>
                    </button>
                </div>
                <input type="text" placeholder="Cari Sesuatu..." class="form-control" />
            </div>
        </nav>
        --}}

        {{-- Navigasi Kanan Header (Profil Pengguna, Notifikasi, dll.) --}}
        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
            {{-- Tombol Search untuk Mobile (jika search di kiri tidak ditampilkan di mobile) --}}
            {{--
            <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" aria-haspopup="true">
                    <i class="fa fa-search"></i>
                </a>
                <ul class="dropdown-menu dropdown-search animated fadeIn">
                    <form class="navbar-left navbar-form nav-search">
                        <div class="input-group">
                            <input type="text" placeholder="Search ..." class="form-control" />
                        </div>
                    </form>
                </ul>
            </li>
            --}}

            {{-- Contoh Notifikasi --}}
            {{--
            <li class="nav-item topbar-icon dropdown hidden-caret">
                <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    <span class="notification">3</span> {{-- Jumlah Notifikasi --}}
            {{--    </a>
                <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                    <li>
                        <div class="dropdown-title">Anda memiliki 3 notifikasi baru</div>
                    </li>
                    <li>
                        <div class="notif-scroll scrollbar-outer">
                            <div class="notif-center">
                                <a href="#">
                                    <div class="notif-icon notif-primary"> <i class="fa fa-user-plus"></i> </div>
                                    <div class="notif-content">
                                        <span class="block"> Pelanggan baru mendaftar </span>
                                        <span class="time">5 menit yang lalu</span>
                                    </div>
                                </a>
                                <!-- Item notifikasi lainnya -->
            {{--                </div>
                        </div>
                    </li>
                    <li>
                        <a class="see-all" href="javascript:void(0);"> Lihat semua notifikasi <i class="fa fa-angle-right"></i></a>
                    </li>
                </ul>
            </li>
            --}}

            {{-- Profil Pengguna --}}
            <li class="nav-item topbar-user dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                    <div class="avatar-sm">
                        {{-- Ganti dengan avatar pengguna jika ada, atau inisial default --}}
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
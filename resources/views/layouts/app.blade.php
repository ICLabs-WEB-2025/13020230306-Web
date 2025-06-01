<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $title ?? config('app.name', 'PenitipanHewan') }}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/paw.jpg') }}" rel="icon">
    <link href="{{ asset('assets/img/paw.jpg') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

    <!-- Scripts (jika menggunakan Vite) -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
</head>
<body class="{{ $bodyClass ?? 'index-page' }}">

    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
            <a href="{{ route('landingPage.index') }}" class="logo d-flex align-items-center">
               <img src="{{ asset('assets/img/paw.jpg') }}" alt="">
                <h1 class="sitename">Penitipan Hewan</h1>
            </a>
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ route('landingPage.index') }}" class="{{ request()->routeIs('landingPage.index') ? 'active' : '' }}">Beranda</a></li>
                    @guest
                        @if (Route::has('login'))
                            <li><a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Masuk</a></li>
                        @endif
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'active' : '' }}">Daftar</a></li>
                        @endif
                    @else
                        {{-- Tampilkan nama pengguna --}}
                        {{-- <li class="nav-item"><span class="nav-link text-white">Halo, {{ Auth::user()->name }}</span></li> --}}

                        @if(Auth::user()->isAdmin())
                            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}">Dasbor Admin</a></li>
                        @elseif(Auth::user()->isCustomer())
                            <li><a href="{{ route('customer.dashboard') }}" class="{{ request()->routeIs('customer.dashboard*') ? 'active' : '' }}">Dasbor Saya</a></li>
                        @endif
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Keluar
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endguest
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>
    </header>

    <main class="main">
        @if (session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    <footer id="footer" class="footer light-background">
        <!-- Salin konten footer Anda dari index.html ke sini -->
        <div class="container">
          <div class="row g-4">
            <div class="col-md-6 col-lg-3 mb-3 mb-md-0">
              <div class="widget">
                <h3 class="widget-heading">Tentang Kami</h3>
                <p class="mb-4">
                  There live the blind texts. Separated they live in Bookmarksgrove
                  right at the coast of the Semantics, a large language ocean.
                </p>
                <p class="mb-0">
                  <a href="#" class="btn-learn-more">Selengkapnya</a>
                </p>
              </div>
            </div>
            <div class="col-md-6 col-lg-3 ps-lg-5 mb-3 mb-md-0">
              <div class="widget">
                <h3 class="widget-heading">Navigasi</h3>
                <ul class="list-unstyled float-start me-5">
                  <li><a href="#">Gambaran Umum</a></li>
                  <li><a href="#">Tentang Kami</a></li>
                  <li><a href="#">Cari Pembeli</a></li>
                </ul>
                <ul class="list-unstyled float-start">
                  <li><a href="#">Gambaran Umum</a></li>
                  <li><a href="#">Tentang Kami</a></li>
                  <li><a href="#">Layanan</a></li>
                </ul>
              </div>
            </div>
            <div class="col-md-6 col-lg-3 pl-lg-5">
              <div class="widget">
                <h3 class="widget-heading">Postingan Terbaru</h3>
                <ul class="list-unstyled footer-blog-entry">
                  <li>
                    <span class="d-block date">Mei 3, 2020</span>
                    <a href="#">There live the Blind Texts</a>
                  </li>
                  <li>
                    <span class="d-block date">Mei 3, 2020</span>
                    <a href="#">Separated they live in Bookmarksgrove right</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-md-6 col-lg-3 pl-lg-5">
              <div class="widget">
                <h3 class="widget-heading">Terhubung</h3>
                <ul class="list-unstyled social-icons light mb-3">
                  <li>
                    <a href="#"><span class="bi bi-facebook"></span></a>
                  </li>
                  <li>
                    <a href="#"><span class="bi bi-twitter-x"></span></a>
                  </li>
                  <li>
                    <a href="#"><span class="bi bi-linkedin"></span></a>
                  </li>
                  <li>
                    <a href="#"><span class="bi bi-google"></span></a>
                  </li>
                  <li>
                    <a href="#"><span class="bi bi-google-play"></span></a>
                  </li>
                </ul>
              </div>
              <!-- Hapus bagian subscribe jika tidak menggunakan PHP form bawaan template -->
            </div>
          </div>
          <div class="copyright d-flex flex-column flex-md-row align-items-center justify-content-md-between">
            <p>© <span>Hak Cipta</span> <strong class="px-1 sitename">Active.</strong> <span>Dilindungi Undang-Undang</span></p>
            <div class="credits">
              Dirancang oleh <a href="https://bootstrapmade.com/">BootstrapMade</a> Didistribusikan Oleh <a href="https://themewagon.com">ThemeWagon</a>
            </div>
          </div>
        </div>
    </footer>

    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    {{-- Hapus validate.js jika tidak menggunakan form PHP bawaan template --}}
    {{-- <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script> --}}
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @stack('scripts') <!-- Untuk skrip spesifik halaman -->
</body>
</html>
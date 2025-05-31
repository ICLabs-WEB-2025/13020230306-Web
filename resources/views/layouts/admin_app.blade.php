<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ $title ?? 'Dasbor Admin' }} - {{ config('app.name', 'Pet Care') }}</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('kaiadmin/assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" /> <!-- Sesuaikan path favicon -->

    <!-- Fonts and icons -->
    <script src="{{ asset('kaiadmin/assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: { "families": ["Public Sans:300,400,500,600,700"] },
            custom: { "families": ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset('kaiadmin/assets/css/fonts.min.css') }}'] },
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('kaiadmin/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('kaiadmin/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('kaiadmin/assets/css/kaiadmin.min.css') }}" />

    {{-- CSS Kustom untuk Admin jika ada --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}" /> --}}
    @stack('styles') {{-- Untuk CSS spesifik halaman --}}
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar Admin -->
        @include('admin.partials._sidebar') {{-- Path ke sidebar admin --}}
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">
                        <a href="{{ route('admin.dashboard') }}" class="logo">
                            {{-- <img src="{{ asset('kaiadmin/assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand" height="20" /> --}}
                             <span class="text-light ms-2 fw-bold">ADMIN {{ strtoupper(config('app.name', 'Pet Care')) }}</span>
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>
                    </div>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header Admin -->
                @include('admin.partials._header_nav') {{-- Path ke header nav admin --}}
                <!-- End Navbar -->
            </div>

            <div class="container"> {{-- Kontainer untuk konten halaman --}}
                <div class="page-inner">
                    {{-- Notifikasi Sukses --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Notifikasi Error --}}
                    @if (session('error'))
                         <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Notifikasi Error Validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                             <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Konten Utama Halaman --}}
                    @yield('content')
                </div>
            </div>

            {{-- Footer Admin --}}
            @include('admin.partials._footer') {{-- Path ke footer admin --}}
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('kaiadmin/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('kaiadmin/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('kaiadmin/assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('kaiadmin/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('kaiadmin/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{ asset('kaiadmin/assets/js/kaiadmin.min.js') }}"></script>

    {{-- Script Kustom untuk Admin jika ada --}}
    {{-- <script src="{{ asset('js/admin_custom.js') }}"></script> --}}
    @stack('scripts') {{-- Untuk JS spesifik halaman --}}
</body>
</html>
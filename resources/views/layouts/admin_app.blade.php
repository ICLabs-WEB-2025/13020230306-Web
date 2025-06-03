<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Penitipan Hewan</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('kaiadmin/assets/img/Paw.jpg') }}" type="image/x-icon" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{ asset('kaiadmin/assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: { "families": ["Public Sans:300,400,500,600,700"] },
            custom: { "families": ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset('kaiadmin/assets/css/fonts.min.css') }}'] },
            active: function () { sessionStorage.fonts = true; }
        });
    </script>

    <link rel="stylesheet" href="{{ asset('kaiadmin/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('kaiadmin/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('kaiadmin/assets/css/kaiadmin.min.css') }}" />
    @stack('styles')
</head>
<body>
    <div class="wrapper">
        @include('admin.partials._sidebar')
        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <div class="logo-header" data-background-color="white">
                        <a href="{{ route('admin.dashboard') }}" class="logo">
                             <span class="text-dark ms-2 fw-bold">Admin Penitipan Hewan</span>
                        </a>
                        <div class="nav-toggle"><button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button><button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button></div>
                        <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
                    </div>
                </div>
                @include('admin.partials._header_nav')
            </div>
            <div class="container">
                <div class="page-inner">
                    @yield('content')
                </div>
            </div>
            @include('admin.partials._footer')
        </div>
    </div>
    <script src="{{ asset('kaiadmin/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('kaiadmin/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('kaiadmin/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('kaiadmin/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('kaiadmin/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('kaiadmin/assets/js/kaiadmin.min.js') }}"></script>
    @stack('scripts')
</body>
</html>

<footer class="footer">
    <div class="container-fluid">
        <nav class="pull-left">
            <ul class="nav">
                {{-- <li class="nav-item">
                    <a class="nav-link" href="#">
                        Bantuan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        Lisensi
                    </a>
                </li> --}}
            </ul>
        </nav>
        <div class="copyright ms-auto">
            {{ date('Y') }} © <a href="{{ url('/') }}" target="_blank">{{ config('app.name', 'Pet Care') }}</a>.
            {{-- Didesain oleh <a href="https://www.themekita.com" target="_blank">ThemeKita</a> (jika menggunakan template berbayar dan ingin memberi kredit) --}}
        </div>
    </div>
</footer>
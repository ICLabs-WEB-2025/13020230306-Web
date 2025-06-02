@extends('layouts.admin_app', ['title' => 'Dashboard Admin'])

@section('content')
<div class="container-fluid px-4 py-4"> {{-- Padding untuk konten --}}

    {{-- Header Sambutan --}}
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-2 text-gray-800">Selamat Datang Kembali, {{ Auth::user()->name }}!</h1>
            <p class="mb-0">Berikut adalah ringkasan aktivitas di platform Penitipan Hewan Anda.</p>
        </div>
    </div>

    {{-- Baris untuk Kartu Statistik (Stat Cards) --}}
    <div class="row">
        {{-- Kartu Jumlah Pengguna --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pengguna</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPengguna ?? 'N/A' }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i> {{-- Ganti dengan ikon Anda --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kartu Penitipan Aktif --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Penitipan Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $penitipanAktif ?? 'N/A' }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-paw fa-2x text-gray-300"></i> {{-- Ganti dengan ikon Anda --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kartu Permintaan Baru --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Permintaan Baru</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $permintaanBaru ?? 'N/A' }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i> {{-- Ganti dengan ikon Anda --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kartu Pendapatan (Contoh) --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pendapatan (Bulan Ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($pendapatanBulanIni ?? 0, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> {{-- Ganti dengan ikon Anda --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Baris untuk Grafik dan Aktivitas Terbaru --}}
    <div class="row">
        {{-- Kolom untuk Grafik --}}
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                {{-- Card Header - Dropdown --}}
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Pertumbuhan Pengguna</h6>
                    {{-- Anda bisa menambahkan dropdown filter di sini --}}
                </div>
                {{-- Card Body --}}
                <div class="card-body">
                    <div class="chart-area">
                        {{-- Tempatkan elemen canvas untuk chart di sini --}}
                        <canvas id="myAreaChart"></canvas>
                        <p class="text-center mt-3"><em>(Implementasi grafik memerlukan library seperti Chart.js)</em></p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom untuk Aktivitas Terbaru / Quick Links --}}
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aktivitas Terbaru</h6>
                </div>
                <div class="card-body">
                    @if(isset($permintaanPenitipanTerbaru) && $permintaanPenitipanTerbaru->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($permintaanPenitipanTerbaru as $permintaan)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $permintaan->user->name ?? 'User' }}</strong> mengajukan penitipan
                                    <br><small class="text-muted">{{ $permintaan->hewan->nama_hewan ?? 'Hewan' }} - {{ $permintaan->created_at->diffForHumans() }}</small>
                                </div>
                                <a href="{{-- route('admin.penitipan.show', $permintaan->id) --}}" class="btn btn-sm btn-outline-primary">Lihat</a>
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center text-muted">Belum ada permintaan penitipan baru.</p>
                    @endif
                    <hr>
                    <h6 class="mt-3 mb-2 font-weight-bold text-primary">Aksi Cepat</h6>
                    <a href="{{-- route('admin.penitipan.index') --}}" class="btn btn-info btn-block mb-2">
                        <i class="fas fa-paw mr-2"></i> Kelola Semua Penitipan
                    </a>
                    <a href="{{-- route('admin.users.index') --}}" class="btn btn-success btn-block">
                        <i class="fas fa-users mr-2"></i> Kelola Pengguna
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
  
{{-- Jika Anda menggunakan Chart.js atau library grafik lainnya --}}
@push('scripts')
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
{{-- <script> --}}
    {{-- // Contoh data dan konfigurasi untuk Chart.js (sesuaikan dengan data Anda) --}}
    {{-- var ctx = document.getElementById("myAreaChart"); --}}
    {{-- var myAreaChart = new Chart(ctx, { --}}
    {{--  type: 'line', --}}
    {{--  data: { --}}
    {{--    labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"], --}}
    {{--    datasets: [{ --}}
    {{--      label: "Pengguna Baru", --}}
    {{--      lineTension: 0.3, --}}
    {{--      backgroundColor: "rgba(78, 115, 223, 0.05)", --}}
    {{--      borderColor: "rgba(78, 115, 223, 1)", --}}
    {{--      pointRadius: 3, --}}
    {{--      pointBackgroundColor: "rgba(78, 115, 223, 1)", --}}
    {{--      pointBorderColor: "rgba(78, 115, 223, 1)", --}}
    {{--      pointHoverRadius: 3, --}}
    {{--      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)", --}}
    {{--      pointHoverBorderColor: "rgba(78, 115, 223, 1)", --}}
    {{--      pointHitRadius: 10, --}}
    {{--      pointBorderWidth: 2, --}}
    {{--      data: [{{ $dataPenggunaBaruPerBulan ?? '0,0,0,0,0,0,0,0,0,0,0,0' }}], // Isi dengan data dari controller --}}
    {{--    }], --}}
    {{--  }, --}}
    {{--  options: { // Opsi lainnya... } --}}
    {{-- }); --}}
{{-- </script> --}}
@endpush

@endsection
@extends('layouts.customer_app') {{-- Menggunakan layout Kaiadmin untuk customer --}}

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Selamat Datang, {{ Auth::user()->name }}!</h3>
    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="{{ route('customer.dashboard') }}">
                <i class="icon-home"></i>
            </a>
        </li>
        <li class="separator">
            <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
            <a href="#">Dasbor Utama</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Dasbor Pelanggan</h4>
            </div>
            <div class="card-body">
                <p>Ini adalah halaman dasbor pelanggan Anda. Dari sini Anda dapat mengelola penitipan hewan peliharaan Anda.</p>
                <p>Fitur yang tersedia:</p>
                <ul>
                    <li>Mengajukan formulir penitipan hewan baru.</li>
                    <li>Melihat riwayat pengajuan penitipan Anda.</li>
                    <li>Mengedit atau membatalkan pengajuan yang masih berstatus "pending".</li>
                    <li>Mencetak nota untuk setiap pengajuan penitipan.</li>
                </ul>
                <div class="mt-4">
                    <a href="{{ route('customer.pet-boarding.create') }}" class="btn btn-primary btn-lg me-3">
                        <i class="fas fa-paw icon-left"></i> Ajukan Penitipan Baru
                    </a>
                    <a href="{{ route('customer.pet-boarding.index') }}" class="btn btn-info btn-lg">
                        <i class="fas fa-history icon-left"></i> Lihat Riwayat Penitipan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Contoh jika ingin menambahkan statistik ringkas (sesuaikan datanya dari controller)  --}}

{{-- <div class="row mt-4">
    <div class="col-sm-6 col-md-4">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-primary bubble-shadow-small">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Penitipan Pending</p>
                            <h4 class="card-title">5</h4> // Ganti dengan data dinamis
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-success bubble-shadow-small">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Penitipan Terverifikasi</p>
                            <h4 class="card-title">12</h4> // Ganti dengan data dinamis
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-secondary bubble-shadow-small">
                            <i class="fas fa-archive"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Total Riwayat Penitipan</p>
                            <h4 class="card-title">20</h4> // Ganti dengan data dinamis
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

@endsection
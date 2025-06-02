@extends('layouts.customer_app') 

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

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Dasbor Pelanggan</h4>
            </div>  
            <div class="card-body text-center">
                
                <p><strong>Instruksi Penggunaan:</strong></p>
                <ul class="text-start d-inline-block" style="text-align: left;">
                    <li>Klik <b>Ajukan Penitipan Baru</b> untuk mengisi formulir penitipan hewan.</li>
                    <li>Gunakan <b>Lihat Riwayat Penitipan</b> untuk melihat daftar pengajuan penitipan Kamu.</li>
                    <li>Kamu dapat <b>mengedit</b> atau <b>membatalkan</b> pengajuan yang masih berstatus <i>pending</i> pada halaman riwayat.</li>
                    <li>Setelah pengajuan diterima, Kamu dapat <b>mencetak nota</b> untuk setiap pengajuan penitipan.</li>
                </ul>
                </ul>
                <div class="mt-4">
                    <a href="{{ route('customer.pet-boarding.create') }}" class="btn btn-success btn-lg me-3">
                        <i class="fas fa-paw icon-left"></i> Ajukan Penitipan Baru
                    </a>
                    <a href="{{ route('customer.pet-boarding.index') }}" class="btn btn-success btn-lg" style="background-color: #90ee90; border-color: #90ee90;">
                        <i class="fas fa-history icon-left"></i> Lihat Riwayat Penitipan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@extends('layouts.admin_app', ['title' => $title ?? 'Dasbor Admin'])

@section('content')
<div class="container-fluid px-3 py-3"> 

    <div class="page-header">
        <h3 class="fw-bold mb-3">Selamat Datang, {{ $adminName }}!</h3>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item">Dasbor Utama</li>
        </ul>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
  
    <div class="card shadow-sm"> 
        <div class="card-body">

            <div class="row justify-content-center mb-4">
                <div class="col-sm-8 col-md-5 col-lg-4 col-xl-3 mb-3">
                    <div class="card card-stats card-round h-100">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Total Pelanggan</p>
                                        <h4 class="card-title">{{ $totalPengguna ?? '0' }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-8 col-md-5 col-lg-4 col-xl-3 mb-3">
                    <div class="card card-stats card-round h-100">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-success bubble-shadow-small">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Total Pendapatan</p>
                                        <h4 class="card-title">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card">
                         <div class="card-header bg-light">
                        </div>
                        <div class="card-body">
                            <a href="{{ route('admin.pet-boardings.index') }}" class="btn btn-primary d-block mb-2">
                                <i class="fas fa-tasks me-2"></i> Kelola Semua Penitipan
                            </a>
                            <a href="{{ route('admin.pet-boardings.index', ['status_filter' => \App\Models\PetBoarding::STATUS_PENDING]) }}" class="btn btn-warning d-block mb-2">
                                <i class="fas fa-hourglass-start me-2"></i> Lihat Permintaan Pending
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
@endpush

@extends('layouts.customer_app')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Edit Data Penitipan #{{ $boarding->id }}</h3>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{ route('customer.dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="{{ route('customer.pet-boarding.index') }}">Penitipan Hewan</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item">Edit Data Penitipan</li>
    </ul>
</div>
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Perbarui Data Penitipan Hewan</h4>
            </div>
            <div class="card-body">
                {{-- Tampilkan pesan error validasi jika ada --}}
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

                <form action="{{ route('customer.pet-boarding.update', $boarding->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT') {{-- Penting untuk metode HTTP PUT --}}
                    {{-- Menggunakan partial form yang sama dengan halaman create --}}
                    @include('customer.pet-boarding._form', [
                        'boarding' => $boarding,
                        'user' => $user,
                        'servicePackages' => $servicePackages
                    ])
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.customer_app')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Formulir Penitipan Hewan Baru</h3>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{ route('customer.dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="{{ route('customer.pet-boarding.index') }}">Penitipan Hewan</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item">Formulir Baru</li>
    </ul>
</div>
<div class="row">
    <div class="col-md-10 mx-auto"> 
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Isi Data Penitipan</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('customer.pet-boarding.store') }}" method="POST" enctype="multipart/form-data">
                    @include('customer.pet-boarding._form', ['user' => $user, 'servicePackages' => $servicePackages])
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
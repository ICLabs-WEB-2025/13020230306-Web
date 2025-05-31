@extends('layouts.admin_app') {{-- $title akan diambil dari Controller --}}

@section('content')
<section class="dashboard-container section d-flex align-items-center" style="min-height: 70vh;">
  <div class="container" data-aos="fade-up">
    <div class="row justify-content-center">
      <div class="col-md-8 text-center">
        <h1>Selamat Datang, {{ Auth::user()->name }}! (Admin)</h1>
        <p>Ini adalah dasbor admin Anda.</p>
        <p>Anda dapat mengelola pengguna, pengaturan situs, dll. di sini.</p>
      </div>
    </div>
  </div> 
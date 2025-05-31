@extends('layouts.app', ['bodyClass' => 'register-page'])

@section('content')
<section id="register" class="register section auth-form-container d-flex align-items-center" style="min-height: 80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header text-center">
                        <h3 class="fw-light my-4">{{ __('Buat Akun') }}</h3>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-floating mb-3">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nama Lengkap Anda">
                                <label for="name">{{ __('Nama Lengkap') }}</label>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@contoh.com">
                                <label for="email">{{ __('Alamat Email') }}</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Kata Sandi">
                                        <label for="password">{{ __('Kata Sandi') }}</label>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Konfirmasi kata sandi">
                                        <label for="password-confirm">{{ __('Konfirmasi Kata Sandi') }}</label>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="form-floating mb-3">
                                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" aria-label="Pilih Peran">
                                    <option value="customer" {{ old('role', 'customer') == 'customer' ? 'selected' : '' }}>Pelanggan</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (untuk demo)</option>
                                </select>
                                <label for="role">{{ __('Daftar sebagai') }}</label>
                                 @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> --}}

                            <div class="mt-4 mb-0">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        {{ __('Buat Akun') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                        <div class="small"><a href="{{ route('login') }}">Sudah punya akun? Masuk</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
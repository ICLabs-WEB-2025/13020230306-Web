@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Detail Penitipan Hewan #{{ $petBoarding->id }}</h3>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="{{ route('admin.pet-boardings.index') }}">Kelola Penitipan Hewan</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item">Detail Penitipan</li>
    </ul>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Informasi Penitipan</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID Pengajuan:</strong> #{{ $petBoarding->id }}</p>
                        <p><strong>Nama Pemilik:</strong> {{ $petBoarding->owner_name }}</p>
                        <p><strong>Email Pemilik:</strong> {{ $petBoarding->user->email ?? 'N/A' }}</p>
                        <hr>
                        <p><strong>Nama Hewan:</strong> {{ $petBoarding->pet_name }}</p>
                        <p><strong>Jenis Hewan:</strong> {{ $petBoarding->pet_type }}</p>
                        <p><strong>Umur Hewan:</strong> {{ $petBoarding->pet_age }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Paket Layanan:</strong> {{ $petBoarding->service_package }}</p>
                        <p><strong>Total Biaya:</strong> Rp {{ number_format($petBoarding->total_cost, 0, ',', '.') }}</p>
                        <p><strong>Metode Pembayaran:</strong> {{ $petBoarding->payment_method }}</p>
                        @if($petBoarding->payment_method == 'Transfer Bank')
                            <p><strong>Bukti Pembayaran:</strong>
                                @if($petBoarding->payment_proof_path)
                                    <a href="{{ Storage::url($petBoarding->payment_proof_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat Bukti</a>
                                @else
                                    <span class="text-muted">Belum diunggah</span>
                                @endif
                            </p>
                        @endif
                        <p><strong>Tanggal Pengajuan:</strong> {{ $petBoarding->created_at->isoFormat('D MMMM YYYY, HH:mm') }}</p>
                        <p><strong>Status Saat Ini:</strong>
                            <span class="badge
                                @if($petBoarding->status == \App\Models\PetBoarding::STATUS_PENDING) badge-warning
                                @elseif($petBoarding->status == \App\Models\PetBoarding::STATUS_VERIFIED) badge-success
                                @elseif($petBoarding->status == \App\Models\PetBoarding::STATUS_REJECTED) badge-danger
                                @elseif($petBoarding->status == \App\Models\PetBoarding::STATUS_COMPLETED) badge-info
                                @elseif($petBoarding->status == \App\Models\PetBoarding::STATUS_CANCELLED) badge-secondary
                                @else badge-default
                                @endif">
                                {{ ucfirst($petBoarding->status) }}
                            </span>
                        </p>
                    </div>
                </div>
                 @if($petBoarding->admin_notes)
                    <hr>
                    <h5>Catatan Admin Sebelumnya:</h5>
                    <p style="white-space: pre-wrap;">{{ $petBoarding->admin_notes }}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Update Status Penitipan</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pet-boardings.update-status', $petBoarding->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="status">Ubah Status Menjadi:</label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            @foreach($statuses as $statusValue)
                                <option value="{{ $statusValue }}" {{ $petBoarding->status == $statusValue ? 'selected' : '' }}>
                                    {{ ucfirst($statusValue) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="admin_notes">Catatan Admin (Opsional):</label>
                        <textarea name="admin_notes" id="admin_notes" class="form-control @error('admin_notes') is-invalid @enderror" rows="3">{{ old('admin_notes', $petBoarding->admin_notes ?? '') }}</textarea>
                        @error('admin_notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update Status</button>
                </form>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body text-center">
                 <a href="{{ route('admin.pet-boardings.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
            </div>
        </div>
    </div>
</div>
@endsection
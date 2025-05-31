@extends('layouts.customer_app')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Riwayat Penitipan Hewan Saya</h3>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{ route('customer.dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="{{ route('customer.pet-boarding.index') }}">Penitipan Hewan</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item">Riwayat Penitipan</li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Daftar Pengajuan Penitipan</h4>
                    <a href="{{ route('customer.pet-boarding.create') }}" class="btn btn-primary btn-round ms-auto">
                        <i class="fa fa-plus"></i> Ajukan Penitipan Baru
                    </a>
                </div>
            </div>
            <div class="card-body">
                {{-- @include('partials.alerts') Buat partial untuk menampilkan session success/error --}}

                @if($boardings->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-paw fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Anda belum memiliki riwayat penitipan.</h4>
                        <a href="{{ route('customer.pet-boarding.create') }}" class="btn btn-primary mt-3">
                            <i class="fa fa-plus"></i> Ajukan Sekarang
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Nama Hewan</th>
                                    <th>Paket Layanan</th>
                                    <th class="text-end">Total Biaya</th>
                                    <th class="text-center">Status</th>
                                    <th>Tanggal</th>
                                    <th class="text-center" style="width: 25%;">Aksi</th> {{-- Lebarkan kolom aksi --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($boardings as $boarding)
                                <tr>
                                    <td class="text-center">#{{ $boarding->id }}</td>
                                    <td>{{ $boarding->pet_name }} <small class="d-block text-muted">{{ $boarding->pet_type }}</small></td>
                                    <td>{{ $boarding->service_package }}</td>
                                    <td class="text-end">Rp {{ number_format($boarding->total_cost, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <span class="badge
                                            @if($boarding->status == \App\Models\PetBoarding::STATUS_PENDING) badge-warning
                                            @elseif($boarding->status == \App\Models\PetBoarding::STATUS_VERIFIED) badge-success
                                            @elseif($boarding->status == \App\Models\PetBoarding::STATUS_REJECTED) badge-danger
                                            @elseif($boarding->status == \App\Models\PetBoarding::STATUS_COMPLETED) badge-info
                                            @elseif($boarding->status == \App\Models\PetBoarding::STATUS_CANCELLED) badge-secondary
                                            @else badge-default @endif">
                                            {{ ucfirst($boarding->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $boarding->created_at->isoFormat('D MMM YYYY, HH:mm') }}</td>
                                    <td class="text-center">
                                        <div class="form-button-action">
                                            {{-- Tombol Edit --}}
                                            @if($boarding->canBeModified())
                                                <a href="{{ route('customer.pet-boarding.edit', $boarding->id) }}" data-bs-toggle="tooltip" title="Edit Data" class="btn btn-link btn-primary btn-lg p-1">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif

                                            {{-- Tombol Cancel (Ubah Status) --}}
                                            @if($boarding->canBeModified())
                                                <form action="{{ route('customer.pet-boarding.cancel', $boarding->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan penitipan ini? Status akan diubah menjadi Dibatalkan.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" data-bs-toggle="tooltip" title="Batalkan Pengajuan" class="btn btn-link btn-warning p-1">
                                                        <i class="fa fa-times-circle"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- Tombol Delete Permanen --}}
                                            @php
                                                // Tentukan status apa saja yang boleh dihapus permanen oleh customer
                                                // Misalnya hanya jika 'pending' atau 'cancelled'
                                                $allowedStatusesToDelete = [\App\Models\PetBoarding::STATUS_PENDING, \App\Models\PetBoarding::STATUS_CANCELLED];
                                            @endphp
                                            @if(in_array($boarding->status, $allowedStatusesToDelete))
                                                <form action="{{ route('customer.pet-boarding.destroy', $boarding->id) }}" method="POST" class="d-inline" onsubmit="return confirm('PERHATIAN: Data ini akan dihapus permanen dan tidak bisa dikembalikan. Apakah Anda yakin?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" data-bs-toggle="tooltip" title="Hapus Permanen" class="btn btn-link btn-danger p-1">
                                                        <i class="fa fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- Tombol Cetak Nota --}}
                                            <a href="{{ route('customer.pet-boarding.receipt', $boarding->id) }}" data-bs-toggle="tooltip" title="Cetak Nota" class="btn btn-link btn-info p-1" target="_blank">
                                                <i class="fa fa-print"></i>
                                            </a>

                                            {{-- Ikon Gembok jika tidak ada aksi yang diizinkan lagi --}}
                                            @if(!$boarding->canBeModified() && !in_array($boarding->status, $allowedStatusesToDelete) && $boarding->status !== \App\Models\PetBoarding::STATUS_COMPLETED && $boarding->status !== \App\Models\PetBoarding::STATUS_VERIFIED && $boarding->status !== \App\Models\PetBoarding::STATUS_REJECTED)
                                                 {{-- Tidak menampilkan gembok jika sudah completed/verified/rejected karena nota masih bisa diakses --}}
                                            @elseif(!$boarding->canBeModified() && !in_array($boarding->status, $allowedStatusesToDelete))
                                                 <span class="text-muted" data-bs-toggle="tooltip" title="Tindakan tidak tersedia (Status: {{ ucfirst($boarding->status) }})"><i class="fa fa-lock"></i></span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($boardings->hasPages())
                        <div class="mt-4 d-flex justify-content-center">
                            {{ $boardings->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
@extends('layouts.admin_app') {{-- Pastikan ini adalah layout Kaiadmin Anda untuk admin --}}

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Kelola Data Penitipan Hewan</h3>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item">Penitipan Hewan</li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Daftar Semua Pengajuan Penitipan</h4>
       
                </div>
                {{-- Form Filter Opsional --}}
                <form method="GET" action="{{ route('admin.pet-boardings.index') }}" class="mt-3">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text" name="search_filter" class="form-control" placeholder="Cari nama hewan/pemilik/email..." value="{{ request('search_filter') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status_filter" class="form-select">
                                <option value="all">Semua Status</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ request('status_filter') == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                         <div class="col-md-2">
                            <a href="{{ route('admin.pet-boardings.index') }}" class="btn btn-secondary w-100">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                @if($boardings->isEmpty())
                    <div class="text-center py-4">
                        <i class="fas fa-paw fa-3x text-muted mb-2"></i>
                        <p>Tidak ada data penitipan yang ditemukan.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table id="adminPetBoardingTable" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Nama Pemilik</th>
                                    <th>Nama Hewan</th>
                                    <th>Paket</th>
                                    <th class="text-end">Total Biaya</th>
                                    <th class="text-center">Status</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($boardings as $boarding)
                                <tr>
                                    <td class="text-center">#{{ $boarding->id }}</td>
                                    <td>
                                        {{ $boarding->owner_name }}
                                        <small class="d-block text-muted">{{ $boarding->user->email ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        {{ $boarding->pet_name }}
                                        <small class="d-block text-muted">{{ $boarding->pet_type }}</small>
                                    </td>
                                    <td>{{ $boarding->service_package }}</td>
                                    <td class="text-end">Rp {{ number_format($boarding->total_cost, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <span class="badge
                                            @if($boarding->status == \App\Models\PetBoarding::STATUS_PENDING) badge-warning
                                            @elseif($boarding->status == \App\Models\PetBoarding::STATUS_VERIFIED) badge-success
                                            @elseif($boarding->status == \App\Models\PetBoarding::STATUS_REJECTED) badge-danger
                                            @elseif($boarding->status == \App\Models\PetBoarding::STATUS_COMPLETED) badge-info
                                            @elseif($boarding->status == \App\Models\PetBoarding::STATUS_CANCELLED) badge-secondary
                                            @else badge-default
                                            @endif">
                                            {{ ucfirst($boarding->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $boarding->created_at->isoFormat('D MMM YYYY, HH:mm') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.pet-boardings.show', $boarding->id) }}" data-bs-toggle="tooltip" title="Lihat Detail & Ubah Status" class="btn btn-link btn-info btn-lg">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        {{-- Admin mungkin tidak perlu tombol edit/delete di sini, cukup di halaman detail --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- Paginasi Links --}}
                    @if ($boardings->hasPages())
                        <div class="mt-4 d-flex justify-content-center">
                            {{ $boardings->appends(request()->except('page'))->links() }} {{-- Menjaga parameter filter saat paginasi --}}
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
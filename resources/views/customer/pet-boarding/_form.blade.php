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

@csrf
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="owner_name">Nama Pemilik <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('owner_name') is-invalid @enderror" id="owner_name" name="owner_name" value="{{ old('owner_name', $boarding->owner_name ?? $user->name) }}" required>
            @error('owner_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="pet_name">Nama Hewan <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('pet_name') is-invalid @enderror" id="pet_name" name="pet_name" value="{{ old('pet_name', $boarding->pet_name ?? '') }}" required>
            @error('pet_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="pet_type">Jenis Hewan (mis: Kucing Persia, Anjing Golden) <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('pet_type') is-invalid @enderror" id="pet_type" name="pet_type" value="{{ old('pet_type', $boarding->pet_type ?? '') }}" required>
            @error('pet_type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="pet_age">Umur Hewan (mis: 2 Tahun, 6 Bulan) <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('pet_age') is-invalid @enderror" id="pet_age" name="pet_age" value="{{ old('pet_age', $boarding->pet_age ?? '') }}" required>
            @error('pet_age')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="form-group">
    <label for="service_package">Pilih Paket Pelayanan Hewan <span class="text-danger">*</span></label>
    <select class="form-select @error('service_package') is-invalid @enderror" id="service_package" name="service_package" required onchange="updateTotalCost(this.value)">
        <option value="">-- Pilih Paket --</option>
        @php $selectedCost = 0; @endphp
        @foreach($servicePackages as $package => $cost)
            @php
                if(old('service_package', $boarding->service_package ?? '') == $package) {
                    $selectedCost = $cost;
                }
            @endphp
            <option value="{{ $package }}" data-cost="{{ $cost }}" {{ old('service_package', $boarding->service_package ?? '') == $package ? 'selected' : '' }}>
                {{ $package }} - Rp {{ number_format($cost, 0, ',', '.') }}
            </option>
        @endforeach
    </select>
    @error('service_package')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label class="form-label">Total Biaya</label>
    <input type="text" class="form-control bg-light" id="total_cost_display" value="Rp {{ number_format(old('total_cost', $boarding->total_cost ?? $selectedCost), 0, ',', '.') }}" readonly>
</div>

<div class="form-group">
    <label for="payment_method">Metode Pembayaran <span class="text-danger">*</span></label>
    <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required onchange="togglePaymentProof(this.value)">
        <option value="Cash" {{ old('payment_method', $boarding->payment_method ?? 'Cash') == 'Cash' ? 'selected' : '' }}>Cash (Bayar di Tempat)</option>
        <option value="Transfer Bank" {{ old('payment_method', $boarding->payment_method ?? '') == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
    </select>
    @error('payment_method')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group" id="payment_proof_section" style="display: {{ old('payment_method', $boarding->payment_method ?? 'Cash') == 'Transfer Bank' ? 'block' : 'none' }};">
    <label for="payment_proof" class="form-label">Upload Bukti Pembayaran (Format: JPG, PNG, GIF, WEBP. Maks: 2MB) <span id="payment_proof_required_label" class="text-danger" style="display:none;">*</span></label>
    <input type="file" class="form-control @error('payment_proof') is-invalid @enderror" id="payment_proof" name="payment_proof" accept="image/jpeg,image/png,image/gif,image/webp">
    @error('payment_proof')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @if(isset($boarding) && $boarding->payment_proof_path)
        <div class="mt-2">
            <small>Bukti pembayaran saat ini:</small><br>
            <a href="{{ Storage::url($boarding->payment_proof_path) }}" target="_blank" data-glightbox title="Bukti Pembayaran">
                <img src="{{ Storage::url($boarding->payment_proof_path) }}" alt="Bukti Pembayaran" style="max-width: 150px; max-height: 150px; border:1px solid #ddd; padding:5px; border-radius:4px;">
            </a>
        </div>
    @endif
</div>
<small class="form-text text-muted" id="transfer_info_text" style="display: {{ old('payment_method', $boarding->payment_method ?? 'Cash') == 'Transfer Bank' ? 'block' : 'none' }};">
    Silakan transfer ke rekening ABCDEFG Bank 123-456-7890 a.n. Pet Care Anda.
</small>

<div class="card-action mt-4">
    <button type="submit" class="btn btn-success">{{ isset($boarding) ? 'Update Data Penitipan' : 'Ajukan Penitipan' }}</button>
    <a href="{{ route('customer.pet-boarding.index') }}" class="btn btn-danger">Batal</a>
</div>

@push('scripts')
<script>
    const servicePackagesData = @json($servicePackages); // Pastikan ini dikirim dari controller

    function updateTotalCost(packageName) {
        const displayElement = document.getElementById('total_cost_display');
        let cost = 0;
        if (packageName && servicePackagesData[packageName]) {
            cost = servicePackagesData[packageName];
        }
        displayElement.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(cost);
    }

    function togglePaymentProof(method) {
        const proofSection = document.getElementById('payment_proof_section');
        const proofInput = document.getElementById('payment_proof');
        const proofRequiredLabel = document.getElementById('payment_proof_required_label');
        const transferInfoText = document.getElementById('transfer_info_text');

        if (method === 'Transfer Bank') {
            proofSection.style.display = 'block';
            transferInfoText.style.display = 'block';
            // Hanya tampilkan tanda bintang jika ini form create ATAU form edit dan belum ada bukti
            const hasExistingProof = @json(isset($boarding) && $boarding->payment_proof_path ? true : false);
            if (!hasExistingProof || document.querySelector('input[name="_method"][value="PUT"]') === null) { // Cek jika bukan form edit atau jika edit tapi tak ada bukti lama
                proofRequiredLabel.style.display = 'inline';
            } else {
                proofRequiredLabel.style.display = 'none';
            }

        } else {
            proofSection.style.display = 'none';
            transferInfoText.style.display = 'none';
            proofInput.value = ''; // Kosongkan input file jika ganti ke cash
            proofRequiredLabel.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const initialPackageElement = document.getElementById('service_package');
        if (initialPackageElement) {
            updateTotalCost(initialPackageElement.value);
        }

        const initialPaymentMethodElement = document.getElementById('payment_method');
        if (initialPaymentMethodElement) {
            togglePaymentProof(initialPaymentMethodElement.value);
        }

        // Optional: Inisialisasi GLightbox jika ada gambar bukti pembayaran di form edit
        if (typeof GLightbox !== 'undefined') {
            const lightbox = GLightbox({
                selector: '[data-glightbox]'
            });
        }
    });
</script>
@endpush
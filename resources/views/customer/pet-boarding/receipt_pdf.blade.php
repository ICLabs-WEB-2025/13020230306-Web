<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $title ?? 'Nota Penitipan Hewan' }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif; /* DejaVu Sans mendukung banyak karakter, termasuk simbol mata uang */
            margin: 0;
            padding: 0;
            font-size: 12px;
            color: #333333;
        }
        .container {
            width: 90%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #dddddd;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000000;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #000000;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 12px;
            color: #555555;
        }
        .section {
            margin-bottom: 25px;
        }
        .section h2 {
            font-size: 16px;
            color: #333333;
            border-bottom: 1px solid #eeeeee;
            padding-bottom: 5px;
            margin-top: 0;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #dddddd;
        }
        th {
            background-color: #f9f9f9;
            font-weight: bold;
        }
        .info-grid {
            width: 100%;
        }
        .info-grid td {
            border-bottom: none; /* Hapus border bawah untuk grid info */
            padding: 4px 0;
        }
        .info-grid strong {
            display: inline-block;
            width: 140px; /* Sesuaikan lebar label jika perlu */
        }
        .total-section {
            margin-top: 30px;
            text-align: right;
        }
        .total-section table {
            width: auto;
            margin-left: auto;
            border: none;
        }
        .total-section th, .total-section td {
            border: none;
            text-align: right;
            padding: 5px;
        }
        .total-section .grand-total td {
            font-size: 1.2em;
            font-weight: bold;
            border-top: 2px solid #000000;
            padding-top: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
            font-size: 10px;
            color: #777777;
        }
        .status-badge {
            padding: 3px 7px;
            border-radius: 4px;
            color: white;
            font-size: 0.9em;
        }
        .status-pending { background-color: #ffc107; color: #000;} /* Kuning */
        .status-verified { background-color: #28a745;} /* Hijau */
        .status-rejected { background-color: #dc3545;} /* Merah */
        .status-completed { background-color: #17a2b8;} /* Biru muda */
        .status-cancelled { background-color: #6c757d;} /* Abu-abu */
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>NOTA PENITIPAN HEWAN</h1>
            {{-- Anda bisa menambahkan logo atau alamat perusahaan di sini jika perlu --}}
            <p>ID Penitipan: #{{ $boarding->id }}</p>
        </div>

        <div class="section">
            <h2>Informasi Pemilik & Hewan</h2>
            <table class="info-grid">
                <tr>
                    <td><strong>Nama Pemilik:</strong></td>
                    <td>{{ $boarding->owner_name }}</td>
                </tr>
                <tr>
                    <td><strong>Email Pemilik:</strong></td>
                    <td>{{ $boarding->user->email }}</td>
                </tr>
                 <tr><td colspan="2" style="padding-top:10px;"></td></tr> {{-- Spasi --}}
                <tr>
                    <td><strong>Nama Hewan:</strong></td>
                    <td>{{ $boarding->pet_name }}</td>
                </tr>
                <tr>
                    <td><strong>Jenis Hewan:</strong></td>
                    <td>{{ $boarding->pet_type }}</td>
                </tr>
                <tr>
                    <td><strong>Umur Hewan:</strong></td>
                    <td>{{ $boarding->pet_age }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h2>Detail Layanan & Pembayaran</h2>
            <table class="info-grid">
                <tr>
                    <td><strong>Tanggal Pengajuan:</strong></td>
                    <td>{{ $boarding->created_at->isoFormat('D MMMM YYYY, HH:mm') }}</td>
                </tr>
                <tr>
                    <td><strong>Paket Layanan:</strong></td>
                    <td>{{ $boarding->service_package }}</td>
                </tr>
                <tr>
                    <td><strong>Metode Pembayaran:</strong></td>
                    <td>{{ $boarding->payment_method }}</td>
                </tr>
                @if($boarding->payment_method == 'Transfer Bank')
                    <tr>
                        <td><strong>Status Pembayaran:</strong></td>
                        <td>
                            @if($boarding->payment_proof_path && $boarding->status !== \App\Models\PetBoarding::STATUS_REJECTED)
                                <span style="color: green;">Bukti Sudah Diunggah</span>
                                {{-- Admin mungkin perlu memverifikasi ini secara manual --}}
                            @elseif($boarding->status === \App\Models\PetBoarding::STATUS_REJECTED && $boarding->payment_proof_path)
                                <span style="color: red;">Bukti Ditolak</span>
                            @else
                                <span style="color: orange;">Menunggu Pembayaran/Unggahan Bukti</span>
                            @endif
                        </td>
                    </tr>
                @endif
                <tr>
                    <td><strong>Status Pengajuan:</strong></td>
                    <td>
                        <span class="status-badge status-{{ $boarding->status }}">
                            {{ ucfirst($boarding->status) }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h2>Rincian Biaya</h2>
            <table>
                <thead>
                    <tr>
                        <th>Deskripsi</th>
                        <th style="text-align: right;">Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $boarding->service_package }}</td>
                        <td style="text-align: right;">Rp {{ number_format($boarding->total_cost, 0, ',', '.') }}</td>
                    </tr>
                    {{-- Anda bisa menambahkan item biaya lain di sini jika ada, misal biaya tambahan --}}
                </tbody>
            </table>
        </div>

        <div class="total-section">
            <table>
                <tr class="grand-total">
                    <td><strong>TOTAL BAYAR:</strong></td>
                    <td><strong>Rp {{ number_format($boarding->total_cost, 0, ',', '.') }}</strong></td>
                </tr>
            </table>
        </div>

        @if($boarding->admin_notes)
        <div class="section" style="margin-top: 20px; border-top: 1px dashed #ccc; padding-top: 15px;">
            <h2>Catatan dari Admin:</h2>
            <p style="white-space: pre-wrap;">{{ $boarding->admin_notes }}</p>
        </div>
        @endif

        <div class="footer">
            <p>Terima kasih telah mempercayakan penitipan hewan Anda kepada kami.</p>
            <p><strong>{{ config('app.name', 'Pet Care Anda') }}</strong></p>
            {{-- Anda bisa menambahkan alamat atau kontak di sini --}}
            <p>Dokumen ini dicetak pada: {{ now()->isoFormat('D MMMM YYYY, HH:mm:ss') }}</p>
        </div>
    </div>
</body>
</html>
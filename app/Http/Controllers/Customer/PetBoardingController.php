<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\PetBoarding;
use App\Models\User; // Jika Anda perlu data user selain yang login
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule; // Untuk validasi Rule::in()

class PetBoardingController extends Controller
{
    /**
     * Daftar paket layanan dan biayanya.
     * Dalam aplikasi nyata, ini sebaiknya berasal dari database atau file konfigurasi.
     */
    protected $servicePackages = [
        'Paket Grooming Basic' => 50000,
        'Paket Grooming Lengkap' => 80000,
        'Penitipan Harian (Tanpa Grooming)' => 70000,
        'Penitipan Harian (Plus Grooming Basic)' => 110000,
        'Paket Medical Checkup' => 150000,
        // Tambahkan paket lain jika ada
    ];

    /**
     * Menampilkan daftar data penitipan milik customer yang sedang login.
     */
    public function index()
    {
        $boardings = PetBoarding::where('user_id', Auth::id())
                                 ->orderBy('created_at', 'desc')
                                 ->paginate(10); // Paginasi untuk daftar yang panjang
        return view('customer.pet-boarding.index', compact('boardings'), ['title' => 'Riwayat Penitipan Saya']);
    }

    /**
     * Menampilkan formulir untuk membuat data penitipan baru.
     */
    public function create()
    {
        $user = Auth::user(); // Data user yang login untuk default nama pemilik
        $servicePackages = $this->servicePackages;
        return view('customer.pet-boarding.create', compact('user', 'servicePackages'), ['title' => 'Formulir Penitipan Hewan']);
    }

    /**
     * Menyimpan data penitipan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pet_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'pet_type' => 'required|string|max:255',
            'pet_age' => 'required|string|max:100', // Misalnya "2 Tahun", "6 Bulan"
            'service_package' => ['required', 'string', Rule::in(array_keys($this->servicePackages))],
            'payment_method' => ['required', 'string', Rule::in(['Transfer Bank', 'Cash'])],
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Maks 2MB
        ]);

        $totalCost = $this->servicePackages[$request->service_package];
        $paymentProofPath = null;

        if ($request->payment_method === 'Transfer Bank') {
            if (!$request->hasFile('payment_proof')) {
                return back()->withErrors(['payment_proof' => 'Bukti pembayaran wajib diunggah jika memilih metode Transfer Bank.'])->withInput();
            }
            // Simpan file ke storage/app/public/payment_proofs
            $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        PetBoarding::create([
            'user_id' => Auth::id(),
            'pet_name' => $request->pet_name,
            'owner_name' => $request->owner_name,
            'pet_type' => $request->pet_type,
            'pet_age' => $request->pet_age,
            'service_package' => $request->service_package,
            'payment_method' => $request->payment_method,
            'total_cost' => $totalCost,
            'payment_proof_path' => $paymentProofPath,
            'status' => PetBoarding::STATUS_PENDING, // Status awal saat pengajuan
        ]);

        return redirect()->route('customer.pet-boarding.index')->with('success', 'Data penitipan berhasil diajukan dan menunggu verifikasi.');
    }

    /**
     * Menampilkan formulir untuk mengedit data penitipan yang sudah ada.
     * Menggunakan Route Model Binding untuk $petBoarding.
     */
    public function edit(PetBoarding $petBoarding)
    {
        // Otorisasi: Pastikan customer hanya bisa edit data miliknya
        if ($petBoarding->user_id !== Auth::id()) {
            return redirect()->route('customer.pet-boarding.index')->with('error', 'Anda tidak diizinkan mengakses data ini.');
        }
        // Otorisasi: Pastikan hanya bisa diedit jika statusnya 'pending'
        if (!$petBoarding->canBeModified()) {
            return redirect()->route('customer.pet-boarding.index')->with('error', 'Data penitipan ini tidak dapat diedit karena statusnya bukan "pending".');
        }

        $user = Auth::user(); // Bisa juga $petBoarding->user jika ingin data pemilik dari record
        $servicePackages = $this->servicePackages;
        return view('customer.pet-boarding.edit', [
            'boarding' => $petBoarding, // Kirim sebagai 'boarding' agar konsisten dengan _form.blade.php
            'user' => $user,
            'servicePackages' => $servicePackages,
            'title' => 'Edit Data Penitipan #' . $petBoarding->id
        ]);
    }

    /**
     * Memperbarui data penitipan yang sudah ada di database.
     * Menggunakan Route Model Binding untuk $petBoarding.
     */
    public function update(Request $request, PetBoarding $petBoarding)
    {
        // Otorisasi
        if ($petBoarding->user_id !== Auth::id()) {
            return redirect()->route('customer.pet-boarding.index')->with('error', 'Anda tidak diizinkan memperbarui data ini.');
        }
        if (!$petBoarding->canBeModified()) {
            return redirect()->route('customer.pet-boarding.index')->with('error', 'Data penitipan ini tidak dapat diperbarui karena statusnya bukan "pending".');
        }

        $request->validate([
            'pet_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'pet_type' => 'required|string|max:255',
            'pet_age' => 'required|string|max:100',
            'service_package' => ['required', 'string', Rule::in(array_keys($this->servicePackages))],
            'payment_method' => ['required', 'string', Rule::in(['Transfer Bank', 'Cash'])],
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $totalCost = $this->servicePackages[$request->service_package];
        $paymentProofPath = $petBoarding->payment_proof_path; // Pertahankan path lama secara default

        if ($request->payment_method === 'Transfer Bank') {
            if ($request->hasFile('payment_proof')) {
                // Jika ada file baru diupload, hapus yang lama (jika ada)
                if ($petBoarding->payment_proof_path) {
                    Storage::disk('public')->delete($petBoarding->payment_proof_path);
                }
                $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
            } elseif (!$petBoarding->payment_proof_path) {
                // Jika metode adalah Transfer Bank, tidak ada file baru yang diupload,
                // DAN tidak ada file lama (artinya sebelumnya bukan transfer atau belum ada bukti), maka bukti menjadi wajib.
                return back()->withErrors(['payment_proof' => 'Bukti pembayaran wajib diunggah jika memilih metode Transfer Bank dan belum ada bukti sebelumnya.'])->withInput();
            }
        } else { // Metode pembayaran adalah 'Cash'
            // Jika metode diubah menjadi Cash dan ada bukti pembayaran lama, hapus bukti tersebut
            if ($petBoarding->payment_proof_path) {
                Storage::disk('public')->delete($petBoarding->payment_proof_path);
            }
            $paymentProofPath = null; // Set path menjadi null untuk metode Cash
        }

        $petBoarding->update([
            'pet_name' => $request->pet_name,
            'owner_name' => $request->owner_name,
            'pet_type' => $request->pet_type,
            'pet_age' => $request->pet_age,
            'service_package' => $request->service_package,
            'payment_method' => $request->payment_method,
            'total_cost' => $totalCost,
            'payment_proof_path' => $paymentProofPath,
            // Status tidak diubah oleh customer saat update data, hanya admin yang bisa mengubah status verifikasi
        ]);

        return redirect()->route('customer.pet-boarding.index')->with('success', 'Data penitipan berhasil diperbarui.');
    }

    /**
     * Membatalkan (mengubah status menjadi 'cancelled') data penitipan.
     * Menggunakan Route Model Binding untuk $petBoarding.
     */
    public function cancel(PetBoarding $petBoarding)
    {
        // Otorisasi
        if ($petBoarding->user_id !== Auth::id()) {
            return redirect()->route('customer.pet-boarding.index')->with('error', 'Anda tidak diizinkan membatalkan data ini.');
        }
        // Otorisasi: Pastikan hanya bisa dibatalkan jika statusnya 'pending'
        if (!$petBoarding->canBeModified()) {
            return redirect()->route('customer.pet-boarding.index')->with('error', 'Data penitipan ini tidak dapat dibatalkan karena statusnya bukan "pending".');
        }

        // Saat dibatalkan, bukti pembayaran juga bisa dihapus dari storage
        if ($petBoarding->payment_proof_path) {
            Storage::disk('public')->delete($petBoarding->payment_proof_path);
        }

        $petBoarding->update([
            'status' => PetBoarding::STATUS_CANCELLED,
            'payment_proof_path' => null // Hapus referensi path bukti pembayaran
        ]);

        return redirect()->route('customer.pet-boarding.index')->with('success', 'Pengajuan penitipan hewan berhasil dibatalkan.');
    }

    /**
     * Menghasilkan nota PDF untuk data penitipan tertentu.
     * Menggunakan Route Model Binding untuk $petBoarding.
     */
    public function generateReceipt(PetBoarding $petBoarding)
    {
        // Otorisasi: Pastikan customer hanya bisa cetak nota miliknya
        if ($petBoarding->user_id !== Auth::id()) {
            return redirect()->route('customer.pet-boarding.index')->with('error', 'Anda tidak diizinkan mengakses nota ini.');
        }

        // Opsional: Anda mungkin ingin membatasi pencetakan nota hanya untuk status tertentu
        // if (!in_array($petBoarding->status, [PetBoarding::STATUS_VERIFIED, PetBoarding::STATUS_COMPLETED])) {
        //     return redirect()->route('customer.pet-boarding.index')->with('error', 'Nota belum dapat dicetak untuk status pengajuan ini.');
        // }

        $data = [
            'boarding' => $petBoarding,
            'title' => 'Nota Penitipan Hewan - #' . $petBoarding->id
            // Anda bisa menambahkan data lain yang dibutuhkan di PDF, misal detail perusahaan Anda
        ];

        // Pastikan view 'customer.pet-boarding.receipt_pdf' sudah ada
        $pdf = Pdf::loadView('customer.pet-boarding.receipt_pdf', $data);

        // Untuk men-download PDF:
        return $pdf->download('nota-penitipan-'.$petBoarding->id.'.pdf');

        // Untuk menampilkan PDF di browser:
        // return $pdf->stream('nota-penitipan-'.$petBoarding->id.'.pdf');
    }

    /**
     * Jika Anda memilih untuk menghapus permanen data (opsional).
     * Menggunakan Route Model Binding untuk $petBoarding.
     */
    public function destroy(PetBoarding $petBoarding)
    {
        // Otorisasi
        if ($petBoarding->user_id !== Auth::id()) {
            return redirect()->route('customer.pet-boarding.index')->with('error', 'Anda tidak diizinkan menghapus data ini.');
        }
        // Pertimbangkan aturan tambahan, misal hanya boleh hapus jika status 'pending' atau 'cancelled'
        // if (!$petBoarding->canBeModified() && $petBoarding->status !== PetBoarding::STATUS_CANCELLED) {
        //     return redirect()->route('customer.pet-boarding.index')->with('error', 'Data penitipan ini tidak dapat dihapus.');
        // }

        if ($petBoarding->payment_proof_path) {
            Storage::disk('public')->delete($petBoarding->payment_proof_path);
        }
        $petBoarding->delete(); // Menghapus record dari database secara permanen

        return redirect()->route('customer.pet-boarding.index')->with('success', 'Data penitipan hewan berhasil dihapus permanen.');
    }
}
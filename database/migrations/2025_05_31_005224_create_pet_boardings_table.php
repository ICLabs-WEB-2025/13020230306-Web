<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pet_boardings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke tabel users (pemilik)
            $table->string('pet_name');
            $table->string('owner_name'); // Bisa diambil dari Auth::user()->name, tapi bisa juga input manual
            $table->string('pet_type'); // Jenis hewan (kucing, anjing, dll.)
            $table->string('pet_age'); // Umur hewan (misal: "2 tahun", "6 bulan")
            $table->string('service_package'); // Nama paket layanan (misal: "Paket Basic", "Paket Premium")
            $table->string('payment_method'); // Metode pembayaran (misal: "Transfer Bank", "Cash")
            $table->decimal('total_cost', 15, 2);
            $table->string('payment_proof_path')->nullable(); // Path ke file bukti pembayaran
            $table->enum('status', ['pending', 'verified', 'rejected', 'completed', 'cancelled'])->default('pending');
            $table->text('admin_notes')->nullable(); // Catatan dari admin jika ada
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pet_boardings');
    }
};
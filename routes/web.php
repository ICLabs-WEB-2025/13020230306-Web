<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\landingPage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Customer\PetBoardingController;
use App\Http\Controllers\Admin\AdminPetBoardingController;


Route::get('/',[landingPage::class, 'index'])->name('landingPage.index'); 

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rute Dasbor Admin
// Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
//     Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
//     // Tambahkan rute admin lainnya di sini
// });

// Rute Dasbor Pelanggan
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
    // Tambahkan rute pelanggan lainnya di sini
    
    // Rute untuk Penitipan Hewan
    Route::get('/pet-boarding', [PetBoardingController::class, 'index'])->name('pet-boarding.index');
    Route::get('/pet-boarding/create', [PetBoardingController::class, 'create'])->name('pet-boarding.create');
    Route::post('/pet-boarding', [PetBoardingController::class, 'store'])->name('pet-boarding.store');
    Route::get('/pet-boarding/{petBoarding}/edit', [PetBoardingController::class, 'edit'])->name('pet-boarding.edit');
    Route::put('/pet-boarding/{petBoarding}', [PetBoardingController::class, 'update'])->name('pet-boarding.update');

    Route::delete('/pet-boarding/{petBoarding}/cancel', [PetBoardingController::class, 'cancel'])->name('pet-boarding.cancel');

    Route::delete('/pet-boarding/{petBoarding}/delete', [PetBoardingController::class, 'destroy'])->name('pet-boarding.destroy');

    Route::get('/pet-boarding/{petBoarding}/receipt', [PetBoardingController::class, 'generateReceipt'])->name('pet-boarding.receipt');
    
}); 

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

   // Rute untuk Admin Kelola Penitipan Hewan
    Route::get('/pet-boardings', [AdminPetBoardingController::class, 'index'])->name('pet-boardings.index');
    Route::get('/pet-boardings/{petBoarding}/show', [AdminPetBoardingController::class, 'show'])->name('pet-boardings.show'); // Untuk lihat detail
    Route::put('/pet-boardings/{petBoarding}/update-status', [AdminPetBoardingController::class, 'updateStatus'])->name('pet-boardings.update-status');
    // Anda bisa menambahkan rute untuk admin mengedit semua detail jika perlu,
    // atau rute untuk admin menambahkan catatan.
});
    
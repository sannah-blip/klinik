<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KunjunganPasienController;
use Illuminate\Support\Facades\Route;

// Otomatis arahkan ke login jika belum terautentikasi
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Dashboard (Diproteksi Auth)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [KunjunganPasienController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
/*
|--------------------------------------------------------------------------
| Profile (Diproteksi Auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Kunjungan Pasien - Khusus User (Mendaftar Kunjungan)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/kunjunganpasien/create', [KunjunganPasienController::class, 'create'])->name('kunjunganpasien.create');
    Route::post('/kunjunganpasien', [KunjunganPasienController::class, 'store'])->name('kunjunganpasien.store');
});

/*
|--------------------------------------------------------------------------
| Kunjungan Pasien & Administrasi - Khusus Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/kunjunganpasien', [KunjunganPasienController::class, 'index'])->name('kunjunganpasien.index');
    Route::get('/kunjunganpasien/{kunjunganpasien}/edit', [KunjunganPasienController::class, 'edit'])->name('kunjunganpasien.edit');
    Route::put('/kunjunganpasien/{kunjunganpasien}', [KunjunganPasienController::class, 'update'])->name('kunjunganpasien.update');
    Route::delete('/kunjunganpasien/{kunjunganpasien}', [KunjunganPasienController::class, 'destroy'])->name('kunjunganpasien.destroy');

    // CRUD Dokter Spesialis
    Route::resource('dokter', \App\Http\Controllers\DokterController::class);

    // Edit Informasi Klinik
    Route::get('/clinic-info/edit', [\App\Http\Controllers\ClinicInfoController::class, 'edit'])->name('clinic-info.edit');
    Route::put('/clinic-info', [\App\Http\Controllers\ClinicInfoController::class, 'update'])->name('clinic-info.update');
});

require __DIR__.'/auth.php';
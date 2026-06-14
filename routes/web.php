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
| Kunjungan Pasien - Bisa Dilihat Semua Orang (Diproteksi Auth)
|--------------------------------------------------------------------------
*/
Route::get('/kunjunganpasien', [KunjunganPasienController::class, 'index'])
    ->middleware('auth')
    ->name('kunjunganpasien.index');

/*
|--------------------------------------------------------------------------
| Kunjungan Pasien - Khusus Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/kunjunganpasien/create', [KunjunganPasienController::class, 'create'])->name('kunjunganpasien.create');
    Route::post('/kunjunganpasien', [KunjunganPasienController::class, 'store'])->name('kunjunganpasien.store');
    Route::get('/kunjunganpasien/{kunjunganpasien}/edit', [KunjunganPasienController::class, 'edit'])->name('kunjunganpasien.edit');
    Route::put('/kunjunganpasien/{kunjunganpasien}', [KunjunganPasienController::class, 'update'])->name('kunjunganpasien.update');
    Route::delete('/kunjunganpasien/{kunjunganpasien}', [KunjunganPasienController::class, 'destroy'])->name('kunjunganpasien.destroy');
});

require __DIR__.'/auth.php';
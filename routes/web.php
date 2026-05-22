<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KunjunganPasienController;

Route::resource(
    'kunjungan',
    KunjunganPasienController::class
);

Route::get('/', function () {
    return redirect('/kunjungan');
});
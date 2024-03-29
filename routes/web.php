<?php

use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanController;

Route::get('/', function () {
    return view('welcome');
});

//route::resource
Route::resource('/siswa', \App\Http\Controllers\SiswaController::class);
Route::resource('/barang', \App\Http\Controllers\BarangController::class);

Route::get('peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
Route::get('peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
Route::post('peminjaman/store', [PeminjamanController::class, 'store'])->name('peminjaman.store');
Route::delete('peminjaman/{peminjaman}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
Route::get('peminjaman/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');

Route::get('/sesi', [SessionController::class, 'index']);
Route::post('/sesi/login', [SessionController::class, 'login']);
Route::get('/sesi/logout', [SessionController::class, 'logout']);
Route::get('/sesi/register', [SessionController::class, 'register']);
Route::post('/sesi/create', [SessionController::class, 'create']);

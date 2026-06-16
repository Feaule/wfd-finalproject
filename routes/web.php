<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PenghuniController as AdminPenghuniController;
use App\Http\Controllers\Admin\TagihanController as AdminTagihanController;
use App\Http\Controllers\Admin\PembayaranController as AdminPembayaranController;
use App\Http\Controllers\Penghuni\TagihanPenghuniController;
use App\Http\Controllers\Penghuni\PembayaranPenghuniController;

// === HALAMAN UTAMA ===
Route::get('/', function () {
    return redirect()->route('login');
});

// === AUTH ROUTES ===
Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// === ROUTE ADMIN ===
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', function () {
        return redirect()->route('admin.penghuni.index');
    })->name('dashboard');

    // CRUD Penghuni
    Route::resource('penghuni', AdminPenghuniController::class);

    // CRUD Tagihan + Generate
    Route::get('tagihan/generate', [AdminTagihanController::class, 'showGenerate'])
         ->name('tagihan.generate.form');
    Route::post('tagihan/generate', [AdminTagihanController::class, 'generate'])
         ->name('tagihan.generate');
    Route::resource('tagihan', AdminTagihanController::class);

    // Verifikasi Pembayaran
    Route::post('pembayaran/{pembayaran}/verifikasi', [AdminPembayaranController::class, 'verifikasi'])
         ->name('pembayaran.verifikasi');
    Route::post('pembayaran/{pembayaran}/tolak', [AdminPembayaranController::class, 'tolak'])
         ->name('pembayaran.tolak');
});

// === ROUTE PENGHUNI ===
Route::prefix('penghuni')->middleware(['auth', 'role:penghuni'])->name('penghuni.')->group(function () {

    // Dashboard
    Route::get('/', function () {
        return redirect()->route('penghuni.tagihan.index');
    })->name('dashboard');

    // Lihat Tagihan
    Route::get('tagihan', [TagihanPenghuniController::class, 'index'])
         ->name('tagihan.index');

    // Upload Bukti Pembayaran
    Route::get('tagihan/{tagihan}/bayar', [PembayaranPenghuniController::class, 'create'])
         ->name('pembayaran.create');
    Route::post('tagihan/{tagihan}/bayar', [PembayaranPenghuniController::class, 'store'])
         ->name('pembayaran.store');
});


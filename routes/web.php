<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PenghuniController as AdminPenghuniController;
use App\Http\Controllers\Admin\TagihanController as AdminTagihanController;
use App\Http\Controllers\Admin\PembayaranController as AdminPembayaranController;
use App\Http\Controllers\Penghuni\TagihanPenghuniController;
use App\Http\Controllers\Penghuni\PembayaranPenghuniController;
use App\Http\Controllers\Auth\AuthController;

// === HALAMAN UTAMA ===
Route::get('/', function () {
    return view('landing');
});

// === AUTH ROUTES ===
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

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


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
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Approval Penghuni
    Route::post('/users/{id}/approve', [\App\Http\Controllers\Admin\DashboardController::class, 'approveUser'])->name('users.approve');
    Route::post('/users/{id}/reject', [\App\Http\Controllers\Admin\DashboardController::class, 'rejectUser'])->name('users.reject');

    // CRUD Lantai
    Route::resource('lantai', \App\Http\Controllers\Admin\LantaiController::class);
    
    // CRUD Unit
    Route::resource('unit', \App\Http\Controllers\Admin\UnitController::class);

    // CRUD Penghuni
    Route::resource('penghuni', AdminPenghuniController::class);

    // Pengaduan
    Route::get('pengaduan', [\App\Http\Controllers\Admin\PengaduanController::class, 'index'])
         ->name('pengaduan.index');
    Route::get('pengaduan/{pengaduan}', [\App\Http\Controllers\Admin\PengaduanController::class, 'show'])
         ->name('pengaduan.show');
    Route::put('pengaduan/{pengaduan}', [\App\Http\Controllers\Admin\PengaduanController::class, 'update'])
         ->name('pengaduan.update');

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
    Route::get('/', [\App\Http\Controllers\Penghuni\DashboardPenghuniController::class, 'index'])
         ->name('dashboard');

    // Info Unit
    Route::get('/unit', [\App\Http\Controllers\Penghuni\UnitPenghuniController::class, 'index'])
         ->name('unit');

    // Lihat Tagihan
    Route::get('tagihan', [TagihanPenghuniController::class, 'index'])
         ->name('tagihan.index');

    // Upload Bukti Pembayaran
    Route::get('tagihan/{tagihan}/bayar', [PembayaranPenghuniController::class, 'create'])
         ->name('pembayaran.create');
    Route::post('tagihan/{tagihan}/bayar', [PembayaranPenghuniController::class, 'store'])
         ->name('pembayaran.store');

    // Pengaduan
    Route::resource('pengaduan', \App\Http\Controllers\Penghuni\PengaduanPenghuniController::class)
         ->only(['index', 'create', 'store', 'show', 'destroy']);
});


<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

//landing page
Route::get('/', function () {
    return view('landing');
});

//auth routes (login & register)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//admin routes 
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

//penghuni routes 
Route::middleware(['auth', 'penghuni'])->prefix('penghuni')->group(function () {
    Route::get('/dashboard', function () {
        return view('penghuni.dashboard');
    })->name('penghuni.dashboard');
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LlaController;


Route::get('/', function () {
    return view('login');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/lla', [LlaController::class, 'index'])->name('lla.index');

Route::get('/admin/menu', [App\Http\Controllers\MenuController::class, 'index'])->name('menu.index');

Route::post('/admin/menu', [App\Http\Controllers\MenuController::class, 'store'])->name('menu.store');

// Tampilan Halaman Login
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');

// Proses Kirim Data Login (POST)
Route::post('/login', [LoginController::class, 'login']);

// Proses Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



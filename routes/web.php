<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DynamicTableController;
use App\Http\Controllers\MenuController;


Route::get('/', function () {
    return view('login');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/admin/menu', [App\Http\Controllers\MenuController::class, 'index'])->name('menu.index');

Route::post('/admin/menu', [App\Http\Controllers\MenuController::class, 'store'])->name('menu.store');

// Tampilan Halaman Login
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');

// Proses Kirim Data Login (POST)
Route::post('/login', [LoginController::class, 'login']);

// Proses Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Jalur untuk menyimpan data pembuatan tabel dinamis baru
Route::post('/dynamic-table/store', [DynamicTableController::class, 'store'])->name('dynamic-table.store');

// Jalur untuk menampilkan isi tabel secara dinamis berdasarkan halaman sub-menu yang diklik
Route::get('/dashboard/view-data/{menu_id}', [DynamicTableController::class, 'show'])->name('dynamic-table.show');

Route::delete('/admin/menu/{id}', [MenuController::class, 'destroy'])
    ->name('menu.destroy');

    // Jalur untuk meng-update tabel dinamis yang sudah ada
Route::put('/dynamic-table/update/{id}', [App\Http\Controllers\DynamicTableController::class, 'update'])->name('dynamic-table.update');

// Jalur jika ingin menghapus seluruh tabel di halaman tersebut
Route::delete('/dynamic-table/destroy/{id}', [App\Http\Controllers\DynamicTableController::class, 'destroyTable'])->name('dynamic-table.destroy');

// Export Excel
Route::get(
    'dashboard/export-tabel/{menu_id}',
    [DynamicTableController::class, 'export']
)->name('dynamic-table.export');

// Import Excel
Route::post(
    'dashboard/import-tabel/{menu_id}',
    [DynamicTableController::class, 'import']
)->name('dynamic-table.import');

Route::put('/dynamic-table/{id}', [DynamicTableController::class, 'update'])
    ->name('dynamic-table.update');

Route::get('/dynamic-table/{id}/chart',
    [DynamicTableController::class,'chart'])
    ->name('dynamic-table.chart');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\DashboardController;






/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Mendefinisikan route untuk HTTP GET request ke URL root ('/')
Route::get('/', [MenuController::class, 'index']);

// Halaman login
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Halaman logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute dashboard dengan middleware checkRole
Route::get('/dashboard-pemilik', [DashboardController::class, 'pemilikDashboard'])->middleware('checkRole:pemilik')->name('dashboard_pemilik');

// Route untuk laporan keuangan dan laporan penjualan, hanya bisa diakses oleh role "pemilik"
Route::get('/laporan-keuangan', [DashboardController::class, 'laporanKeuangan'])->middleware('checkRole:pemilik')->name('laporan_keuangan');
Route::get('/laporan-penjualan', [DashboardController::class, 'laporanPenjualan'])->middleware('checkRole:pemilik')->name('laporan_penjualan');

Route::get('/dashboard-koki', [DashboardController::class, 'kokiDashboard'])->middleware('checkRole:koki')->name('dashboard_koki');

// Rute untuk keranjang
Route::post('/tambah-ke-keranjang', [PesananController::class, 'tambahKeKeranjang'])->name('pesanan.tambah')->middleware('checkRole:waiters,kasir');
Route::get('/keranjang', [PesananController::class, 'lihatKeranjang'])->name('pesanan.keranjang')->middleware('checkRole:waiters,kasir');
Route::post('/keranjang/update', [PesananController::class, 'updateKeranjang'])->name('pesanan.update');
Route::post('/simpan-pesanan', [PesananController::class, 'simpanPesanan'])->name('pesanan.simpan')->middleware('checkRole:waiters,kasir');
Route::get('/list-pesanan', [PesananController::class, 'listPesanan'])->name('pesanan.list-pesanan')->middleware('checkRole:koki,kasir');


// Route untuk mengupdate status pesanan
Route::put('/update-status/{kodePesanan}', [PesananController::class, 'updateStatus'])->name('update.status');
Route::get('/pesanan/{kode_pesanan}', [PesananController::class, 'show'])->name('pesanan.detail');
// Rute profil pengguna
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show')->middleware('auth');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');

// Rute pembayaran
Route::get('/pembayaran/{kodePesanan}', [PembayaranController::class, 'formPembayaran'])->name('pembayaran.form')->middleware('checkRole:kasir');
Route::post('/pembayaran', [PembayaranController::class, 'prosesPembayaran'])->name('pembayaran.proses')->middleware('checkRole:kasir');
Route::get('/list-pembayaran', [PembayaranController::class, 'listPembayaran'])->name('list-pembayaran');




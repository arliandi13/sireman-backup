<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProfileController;





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

Route::get('/', [MenuController::class, 'index']);

Route::get('/login', function () {
  return view('login');
})->name('login');

Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::get('/dashboard-pemilik', function () {
    return 'Dashboard Pemilik';
})->middleware('checkRole:pemilik');

Route::get('/dashboard-kasir', function () {
    return 'Dashboard Kasir';
})->middleware('checkRole:kasir');

Route::get('/dashboard-koki', function () {
    return 'Dashboard Koki';
})->middleware('checkRole:koki');

Route::get('/', [PesananController::class, 'index'])->name('pesanan.index');
Route::post('/tambah-ke-keranjang', [PesananController::class, 'tambahKeKeranjang'])->name('pesanan.tambah');
Route::get('/keranjang', [PesananController::class, 'lihatKeranjang'])->name('pesanan.keranjang');
Route::post('/keranjang/update', [PesananController::class, 'updateKeranjang'])->name('pesanan.update');
Route::post('/keranjang/simpan', [PesananController::class, 'simpanPesanan'])->name('pesanan.simpan');
Route::get('/list-pesanan', [PesananController::class, 'listPesanan'])->name('pesanan.list');

Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');



Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

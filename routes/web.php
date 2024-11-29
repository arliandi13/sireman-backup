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

Route::get('/', [MenuController::class, 'index'])->middleware('checkRole:kasir,waiters');

Route::get('/login', function () {
  return view('login');
})->name('login');

Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::get('/dashboard-pemilik', function () {
    return 'Dashboard Pemilik';
})->middleware('checkRole:pemilik');

Route::get('/', function () {
    return 'Dashboard Kasir';
})->middleware('checkRole:kasir');

Route::get('/dashboard-koki', function () {
    return 'Dashboard Koki';
})->middleware('checkRole:koki');

Route::get('/', [PesananController::class, 'index'])->middleware('checkRole:waiters,kasir');
Route::post('/tambah-ke-keranjang', [PesananController::class, 'tambahKeKeranjang'])->name('pesanan.tambah')->middleware('checkRole:waiters,kasir');
Route::get('/keranjang', [PesananController::class, 'lihatKeranjang'])->name('pesanan.keranjang')->middleware('checkRole:waiters,kasir');
Route::post('/update-keranjang', [PesananController::class, 'updateKeranjang'])->name('keranjang.update')->middleware('checkRole:waiters,kasir');
Route::post('/keranjang/update', [PesananController::class, 'updateKeranjang'])->name('pesanan.update');
Route::post('/simpan-pesanan', [PesananController::class, 'simpanPesanan'])->name('pesanan.simpan')->middleware('checkRole:waiters,kasir');
Route::get('/list-pesanan', [PesananController::class, 'listPesanan'])->name('pesanan.list')->middleware('checkRole:waiters,kasir');;


Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');



Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

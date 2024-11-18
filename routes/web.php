<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;



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


Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

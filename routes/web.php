<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataBarangController;
use App\Http\Controllers\DataSupplierController;
use App\Http\Controllers\DataUserController;
use App\Http\Controllers\PenerimaanBarangController;
use App\Http\Controllers\PengeluaranBarangController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'index'])->name('Login');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('master-barang', DataBarangController::class);
Route::resource('master-supplier', DataSupplierController::class);
Route::resource('master-user', DataUserController::class);
Route::resource('penerimaan-barang', PenerimaanBarangController::class);
Route::resource('pengeluaran-barang', PengeluaranBarangController::class);

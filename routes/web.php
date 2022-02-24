<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataBarangController;
use App\Http\Controllers\DataSupplierController;
use App\Http\Controllers\DataUserController;
use App\Http\Controllers\PenerimaanBarangController;
use App\Http\Controllers\PengeluaranBarangController;
use App\Http\Controllers\DivisiController;

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

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/check-login', [LoginController::class, 'checklogin'])->name('check-login');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('master-barang', DataBarangController::class);
    Route::resource('master-supplier', DataSupplierController::class);
    
    Route::resource('master-users', DataUserController::class);
    Route::get('get-data-users',[DataUserController::class,'dataTable'])->name('master-users.getDataAll');
    
    Route::resource('master-divisi', DivisiController::class);
    Route::get('get-data-divisi',[DivisiController::class,'dataTable'])->name('master-divisi.getDataAll');
   
    Route::resource('penerimaan-barang', PenerimaanBarangController::class);
    Route::resource('pengeluaran-barang', PengeluaranBarangController::class);
    Route::get('/laporan-penerimaan-barang', [PenerimaanBarangController::class, 'laporan'])->name('laporan-penerimaan');
    Route::get('/laporan-pengeluaran-barang', [PengeluaranBarangController::class, 'laporan'])->name('laporan-pengeluaran');
});
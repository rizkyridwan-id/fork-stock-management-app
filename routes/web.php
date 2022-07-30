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

Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('CheckSession');
Route::post('/check-login', [LoginController::class, 'checklogin'])->name('check-login');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('master-barang', DataBarangController::class);
    Route::post('get-barang-by-kode-supplier',[DataBarangController::class,'getBarangSupplier'])->name('master-barang.getBarangSupplier');
   
    Route::get('get-data-barang',[DataBarangController::class,'dataTable'])->name('master-barang.getDataAll');
    Route::post('get-dataBarangAjax',[DataBarangController::class,'dataBarangAjax'])->name('master-barang.dataBarangAjax');
    Route::post('get-datasupplierAjax',[DataBarangController::class,'datasupplierAjax'])->name('master-barang.datasupplierAjax');
    
    Route::post('get-datadivisiAjax',[DivisiController::class,'dataDivisiAjax'])->name('master-barang.dataDivisiAjax');
    Route::resource('master-supplier', DataSupplierController::class);
    Route::get('get-data-supplier',[DataSupplierController::class,'dataTable'])->name('master-supplier.getDataAll');
    
    Route::resource('master-users', DataUserController::class);
    Route::get('get-data-users',[DataUserController::class,'dataTable'])->name('master-users.getDataAll');
    
    Route::resource('master-divisi', DivisiController::class);
    Route::get('get-data-divisi',[DivisiController::class,'dataTable'])->name('master-divisi.getDataAll');
    
    Route::resource('penerimaan-barang', PenerimaanBarangController::class);
    Route::get('get-data-penerimaan-barang',[PenerimaanBarangController::class,'dataTable'])->name('master-penerimaan-barang.getDataAll');
    
    Route::get('get-data-pengeluaran-barang',[PengeluaranBarangController::class,'dataTable'])->name('master-pengeluaran-barang.getDataAll');
   
    Route::resource('pengeluaran-barang', PengeluaranBarangController::class);
    Route::post('/delete-penerimaan-barang', [PenerimaanBarangController::class, 'deletePenerimaanBarang'])->name('deletePenerimaanBarang');
    Route::get('/laporan-penerimaan-barang', [PenerimaanBarangController::class, 'laporan'])->name('laporan-penerimaan');
    Route::post('/cetak-laporan-penerimaan-barang',[PenerimaanBarangController::class,'generatePDFPenerimaanBarang'])->name('cetak-laporan-penerimaan');
    Route::post('/cetak-laporan-pengeluaran',[PengeluaranBarangController::class,'generatePDFPengeluaranBarang'])->name('cetak-laporan-pengeluaran');
    Route::post('/cetak-laporan-barang-paling-banyak',[PengeluaranBarangController::class,'generatePDFPengeluaranBarangPalingBanyak'])->name('cetak-laporan-barang-paling-banyak');
    
    Route::get('/laporan-pengeluaran-barang', [PengeluaranBarangController::class, 'laporan'])->name('laporan-pengeluaran');
    Route::get('/laporan-barang-paling-banyak-digunakan', [PengeluaranBarangController::class, 'laporanpalingbanyak'])->name('laporan-barang-paling-banyak-digunakan');
});
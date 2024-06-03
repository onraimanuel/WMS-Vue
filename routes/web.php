<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TransaksiWarehouseController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['web'])->group(function () {
    Route::get('/', [DashboardController::class, 'Dashboard'])->name("Dashboard");

    Route::get('/ProdukToko', [ProdukController::class, 'produk'])->name("produk.toko");
    Route::get('/PembelianProduk', [ProdukController::class, 'pembelianProduk'])->name("pembelian.produk");
    Route::get('/TambahProduk', [ProdukController::class, 'create'])->name('tambah.produk');
    Route::get('/Notifikasi', [ProdukController::class, 'notifikasi'])->name("notifikasi.produk");
    Route::get('/notifications', [ProdukController::class, 'getNotifications'])->name("getNotifications.produk");

    Route::get('/LaporanPemesanan', [LaporanController::class, 'laporanPemesanan'])->name("laporan.pemesanan");
    Route::get('/LaporanStok', [LaporanController::class, 'laporanStok'])->name("laporan.stok");
    Route::get('/LaporandataStok', [StokController::class, 'LaporanStok']);

    Route::get('/stok', [StokController::class, 'index']);
    Route::get('/searchByDate', [StokController::class, 'searchByDate']);
    Route::post('/addstock', [StokController::class, 'addStock']);
    Route::get('/stok/{id}', [StokController::class, 'show']);
    Route::delete('/stok/{id}', [StokController::class, 'destroy']);
    Route::put('/stok/{id}', [StokController::class, 'update']);

    Route::delete('/deleteTransaksi/{id}', [TransaksiWarehouseController::class, 'deleteTransaksi'])->name("deleteTransaksi");
    Route::get('/getTransaksi/{id}', [TransaksiWarehouseController::class, 'getTransaksiById']);
    Route::put('/updateTransaksi/{id}', [TransaksiWarehouseController::class, 'updateTransaksi'])->name("updateTransaksi");

    Route::get('/TransaksiWarehouse', [TransaksiWarehouseController::class, 'index'])->name("TransaksiWarehouse");
    Route::get('/dataTransaksi', [TransaksiWarehouseController::class, 'dataTransaksi'])->name("dataTransaksi");
    Route::get('/TambahTransaksi', [TransaksiWarehouseController::class, 'TambahTransaksi'])->name("TambahTransaksi");
    Route::post('/AddTransaksi', [TransaksiWarehouseController::class, 'AddTransaksi'])->name("AddTransaksi");

    Route::post('/ReportBarang', [TransaksiWarehouseController::class, 'reportBarang'])->name("reportBarang");

});

Route::get('/login', [LoginController::class, 'login'])->name("login");
Route::post('/postLogin', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

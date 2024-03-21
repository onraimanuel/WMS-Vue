<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\LaporanController;

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

Route::get('/',[DashboardController::class, 'Dashboard'])->name("Dashboard");
Route::get('/ProdukToko',[ProdukController::class, 'Produk'])->name("ProdukToko");
Route::get('/PembelianProduk',[ProdukController::class, 'PembelianProduk'])->name("PembelianProduk");
Route::get('/LaporanPemesanan',[LaporanController::class, 'LaporanPemesanan'])->name("LaporanPemesanan");
Route::get('/LaporanStok',[LaporanController::class, 'LaporanStok'])->name("LaporanStok");


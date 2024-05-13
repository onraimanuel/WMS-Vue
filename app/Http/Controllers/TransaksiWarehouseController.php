<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\Stock;
use App\Models\Merchants;
use App\Models\Transaksi;

use Illuminate\Http\Request;

class TransaksiWarehouseController extends Controller
{
    public function index(){
        return view('TransaksiWarehouse');
    }

    public function dataTransaksi()
{
    $transaksis = Transaksi::select(
        'transaksi.transaksi_id',
        'products.product_name',
        'merchants.nama_merchant',
        'transaksi.jumlah_barang_keluar',
        'transaksi.tanggal_keluar'
    )
    ->join('stocks', 'transaksi.stock_id', '=', 'stocks.stock_id')
    ->join('products', 'stocks.product_id', '=', 'products.product_id')
    ->join('merchants', 'stocks.merchant_id', '=', 'merchants.merchant_id')
    ->get();

    return response()->json($transaksis);
}

    public function TambahTransaksi(){
        return view('/TambahTransaksi');
    }

    public function AddTransaksi(Request $request){
        try {
            $transaksi = new Transaksi();
            $transaksi->transaksi_id = $request->transaksi_id;
            $transaksi->stock_id = $request->stock_id;
            $transaksi->jumlah_barang_keluar = $request->jumlah_barang_keluar;
            $transaksi->tanggal_keluar = now();
            $transaksi->save();
    
            return response()->json(['message' => 'Data berhasil ditambahkan'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    

}

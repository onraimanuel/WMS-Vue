<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\Stock;
use App\Models\Merchants;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

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
        ->orderBy('transaksi.tanggal_keluar', 'desc') 
        ->get();
    
        return response()->json($transaksis);
    }
    

    public function TambahTransaksi(){
        return view('/TambahTransaksi');
    }

    public function AddTransaksi(Request $request){
        try {
            DB::beginTransaction();
    
            $stock = Stock::where('stock_id', $request->stock_id)->first();
            
            if (!$stock) {
                return response()->json(['error' => 'Stok tidak ditemukan'], 404);
            }
    
            if ($stock->sisa_stok < $request->jumlah_barang_keluar) {
                return response()->json(['error' => 'Jumlah stok tidak mencukupi'], 400);
            }
    
            $stock->sisa_stok -= $request->jumlah_barang_keluar;
            $stock->save();
    
            $transaksi = new Transaksi();
            $transaksi->transaksi_id = $request->transaksi_id;
            $transaksi->stock_id = $request->stock_id;
            $transaksi->jumlah_barang_keluar = $request->jumlah_barang_keluar;
            $transaksi->tanggal_keluar = $request->tanggal_keluar;
            $transaksi->save();
    
            DB::commit();
    
            return response()->json(['message' => 'Data berhasil ditambahkan'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

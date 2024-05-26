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

    public function deleteTransaksi($id)
{
    try {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();
        return response()->json(['message' => 'Transaksi berhasil dihapus'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function getTransaksiById($id)
{
    try {
        $transaksi = Transaksi::select(
            'transaksi.transaksi_id',
            'products.product_name',
            'merchants.nama_merchant',
            'transaksi.jumlah_barang_keluar',
            DB::raw("DATE_FORMAT(transaksi.tanggal_keluar, '%Y-%m-%d') as tanggal_keluar")
        )
        ->join('stocks', 'transaksi.stock_id', '=', 'stocks.stock_id')
        ->join('products', 'stocks.product_id', '=', 'products.product_id')
        ->join('merchants', 'stocks.merchant_id', '=', 'merchants.merchant_id')
        ->where('transaksi.transaksi_id', $id)
        ->first();

        if (!$transaksi) {
            return response()->json(['error' => 'Transaksi tidak ditemukan'], 404);
        }

        return response()->json($transaksi);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function updateTransaksi(Request $request, $id)
{
    try {
        DB::beginTransaction();

        // Temukan transaksi berdasarkan ID
        $transaksi = Transaksi::findOrFail($id);

        // Temukan stok berdasarkan stock_id dari transaksi
        $stock = Stock::where('stock_id', $transaksi->stock_id)->first();

        if (!$stock) {
            return response()->json(['error' => 'Stok tidak ditemukan'], 404);
        }

        // Kembalikan stok lama sebelum mengupdate jumlah barang keluar
        $stock->sisa_stok += $transaksi->jumlah_barang_keluar;

        // Pastikan jumlah_barang_keluar dan tanggal_keluar tidak kosong
        if (!$request->filled(['jumlah_barang_keluar', 'tanggal_keluar'])) {
            return response()->json(['error' => 'Lengkapi data jumlah barang keluar dan tanggal transaksi'], 400);
        }

        // Periksa apakah stok mencukupi untuk jumlah barang keluar baru
        if ($stock->sisa_stok < $request->jumlah_barang_keluar) {
            return response()->json(['error' => 'Jumlah stok tidak mencukupi'], 400);
        }

        // Update sisa stok
        $stock->sisa_stok -= $request->jumlah_barang_keluar;
        $stock->save();

        // Update transaksi
        $transaksi->jumlah_barang_keluar = $request->jumlah_barang_keluar;
        $transaksi->tanggal_keluar = $request->tanggal_keluar;
        $transaksi->save();

        DB::commit();

        return response()->json(['message' => 'Transaksi berhasil diperbarui'], 200);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    
    
}

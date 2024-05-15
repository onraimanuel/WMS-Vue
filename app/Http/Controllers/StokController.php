<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\Stock;
use App\Models\Merchants;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        try {
            $stocks = Stock::with(['product.category', 'merchant'])
                ->where('sisa_stok', '>', 0)
                ->get();

            $data = $stocks->map(function ($stock) {
                return [
                    'stock_id' => $stock->stock_id,
                    'product_name' => $stock->product->product_name,
                    'merchant_name' => $stock->merchant->nama_merchant,
                    'stok' => $stock->jumlah_stok,
                    'sisa_stok' => $stock->sisa_stok,
                    'kategori' => $stock->product->category ? $stock->product->category->nama_kategori : null,
                    'spesifikasi' => $stock->product->product_description,
                    'hargamodal' => $stock->hargamodal,
                    'hargajual' => $stock->hargajual,
                    'tanggal_masuk' => $stock->tanggal_masuk,
                    'tanggal_expired' => $stock->tanggal_expired,
                ];
            });

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function addStock(Request $request){
        try {
            $request->validate([
                'product_id' => 'required|exists:products,product_id',
                'jumlah' => 'required|numeric|min:1',
                'hargamodal' => 'required|numeric|min:1',
                'hargajual' => 'required|numeric|min:1',
                'tanggal_expired' => 'required|date',
            ]);
    
            $stock = new Stock();
            $stock->product_id = $request->product_id;
            $stock->merchant_id = $request->merchant_id;
            $stock->jumlah_stok = $request->jumlah;
            $stock->sisa_stok = $request->jumlah;
            $stock->hargamodal = $request->hargamodal;
            $stock->hargajual = $request->hargajual;
            $stock->tanggal_masuk = now();
            $stock->tanggal_expired = $request->tanggal_expired;
            $stock->lokasi = $request->lokasi;
            $stock->save();
    
            return response()->json(['message' => 'Stok berhasil ditambahkan'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function LaporanStok()
    {
        try {
            $stocks = Stock::with(['product.category', 'merchant', 'transaksi'])->get();

            $data = $stocks->map(function ($stock) {
                $totalBarangKeluar = $stock->transaksi->sum('jumlah_barang_keluar');

                // Menghitung stok yang tersisa, pastikan tidak negatif
                $stokTersisa = max($stock->jumlah_stok - $totalBarangKeluar, 0);

                return [
                    'stock_id' => $stock->stock_id,
                    'product_name' => $stock->product->product_name,
                    'merchant_name' => $stock->merchant->nama_merchant,
                    'stok' => $stock->jumlah_stok,
                    'kategori' => $stock->product->category ? $stock->product->category->nama_kategori : null,
                    'hargamodal' => $stock->hargamodal,
                    'hargajual' => $stock->hargajual,
                    'tanggal_expired' => $stock->tanggal_expired,
                    'transaksi_terakhir' => $stock->updated_at,
                    'total_barang_keluar' => $totalBarangKeluar,
                    'stok_tersisa' => $stokTersisa, // Menambahkan stok tersisa ke data
                ];
            });

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



}










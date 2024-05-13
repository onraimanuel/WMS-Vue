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
            $stocks = Stock::with(['product.category', 'merchant'])->get();
            $data = $stocks->map(function ($stock) {
                return [
                    'product_name' => $stock->product->product_name,
                    'merchant_name' => $stock->merchant->nama_merchant, // Ubah merchant_id menjadi nama_merchant
                    'stok' => $stock->jumlah_stok,
                    'kategori' => $stock->product->category ? $stock->product->category->nama_kategori : null,
                    'spesifikasi' => $stock->product->product_description,
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
                'tanggal_expired' => 'required|date',
            ]);
    
            $stock = new Stock();
            $stock->product_id = $request->product_id;
            $stock->merchant_id = $request->merchant_id;
            $stock->jumlah_stok = $request->jumlah;
            $stock->tanggal_masuk = now();
            $stock->tanggal_expired = $request->tanggal_expired;
            $stock->lokasi = $request->lokasi;
            $stock->save();
    
            return response()->json(['message' => 'Stok berhasil ditambahkan'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}






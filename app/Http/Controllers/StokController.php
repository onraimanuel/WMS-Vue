<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\categories;
use App\Models\Stocks;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        try {
            $stocks = Stocks::with('product.category')->get();
            
            // Menyiapkan data yang akan dijadikan respons JSON
            $data = $stocks->map(function ($stock) {
                return [
                    'product_name' => $stock->product->product_name,
                    'stok' => $stock->jumlah_stok,
                    'kategori' => $stock->product->category ? $stock->product->category->nama_kategori : null,
                    'spesifikasi' => $stock->product->description,
                    'tanggal_masuk' => $stock->tanggal_masuk,
                    'tanggal_expired' => $stock->tanggal_expired,
                ];
            });
    
            return response()->json($data);
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

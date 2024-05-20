<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\Stock;
use App\Models\Merchants;
use Illuminate\Http\Request;
use GuzzleHttp\Client;


class StokController extends Controller
{
    public function index()
    {
        try {
            $stocks = Stock::with(['merchant'])
                ->where('sisa_stok', '>', 0)
                ->get();

            $client = new Client();

            $response_product = $client->get('https://kreatif.tobakab.go.id/api/listdaftarproduk');
            $response_category = $client->get('https://kreatif.tobakab.go.id/api/pilihkategori');

            if ($response_product->getStatusCode() !== 200 || $response_category->getStatusCode() !== 200) {
                throw new \Exception('Gagal mengambil data produk atau kategori dari API');
            }

            $products = json_decode($response_product->getBody()->getContents(), true);
            $categories = json_decode($response_category->getBody()->getContents(), true);

            $productMap = collect($products)->keyBy('product_id');
            $categoryMap = collect($categories)->keyBy('category_id');

            $data = $stocks->map(function ($stock) use ($productMap, $categoryMap) {
                $product = $productMap->get($stock->product_id);

                $categoryId = $product['category_id'] ?? null;

                $categoryName = $categoryMap->get($categoryId)['nama_kategori'] ?? 'Kategori Tidak Ditemukan';

                return [
                    'stock_id' => $stock->stock_id,
                    'product_name' => $product['product_name'] ?? 'Produk Tidak Ditemukan',
                    'merchant_name' => $stock->merchant->nama_merchant,
                    'stok' => $stock->jumlah_stok,
                    'sisa_stok' => $stock->sisa_stok,
                    'kategori' => $categoryName,
                    'spesifikasi' => $stock->spesifikasi,
                    'hargamodal' => $stock->hargamodal,
                    'hargajual' => $stock->hargajual,
                    'tanggal_masuk' => $stock->tanggal_masuk,
                    'tanggal_expired' => $stock->tanggal_expired,
                ];
            });

            $data = $data->sortByDesc('stock_id')->values()->all();

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function addStock(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|numeric',
                'jumlah' => 'required|numeric|min:1',
                'hargamodal' => 'required|numeric|min:1',
                'hargajual' => 'required|numeric|min:1',
                'tanggal_expired' => 'required|date',
            ]);
    
            $client = new Client();
            $response_product = $client->get('https://kreatif.tobakab.go.id/api/listdaftarproduk');
    
            if ($response_product->getStatusCode() !== 200) {
                throw new \Exception('Gagal mengambil data produk dari API');
            }
    
            $products = json_decode($response_product->getBody()->getContents(), true);
    
            $productId = $request->input('product_id');
            $product = collect($products)->firstWhere('product_id', $productId);
    
            if (!$product) {
                throw new \Exception('Produk tidak ditemukan dalam database eksternal');
            }
    
            $stock = new Stock();
            $stock->product_id = $productId; 
            $stock->merchant_id = $request->merchant_id;
            $stock->jumlah_stok = $request->jumlah;
            $stock->spesifikasi = $request->spesifikasi;
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
            $client = new Client();
    
            // Ambil data produk dari API eksternal
            $response_product = $client->get('https://kreatif.tobakab.go.id/api/listdaftarproduk');
            if ($response_product->getStatusCode() !== 200) {
                throw new \Exception('Gagal mengambil data produk dari API');
            }
            $products = json_decode($response_product->getBody()->getContents(), true);
    
            // Ambil data kategori dari API eksternal
            $response_category = $client->get('https://kreatif.tobakab.go.id/api/pilihkategori');
            if ($response_category->getStatusCode() !== 200) {
                throw new \Exception('Gagal mengambil data kategori dari API');
            }
            $categories = json_decode($response_category->getBody()->getContents(), true);
    
            // Buat peta kategori berdasarkan category_id
            $categoryMap = collect($categories)->keyBy('category_id');
    
            // Ambil data stok dari database
            $stocks = Stock::with(['merchant', 'transaksi'])->get();
    
            // Map data stok dengan data produk dari API
            $data = $stocks->map(function ($stock) use ($products, $categoryMap) {
                // Cari produk berdasarkan product_id
                $product = collect($products)->firstWhere('product_id', $stock->product_id);
    
                // Cari kategori berdasarkan category_id produk
                $category = $product ? $categoryMap->get($product['category_id']) : null;
    
                // Hitung total barang keluar
                $totalBarangKeluar = $stock->transaksi->sum('jumlah_barang_keluar');
    
                // Hitung stok tersisa
                $stokTersisa = max($stock->jumlah_stok - $totalBarangKeluar, 0);
    
                // Ambil transaksi terakhir
                $transaksiTerakhir = $stock->transaksi->max('created_at');
    
                // Pastikan tanggal transaksi terakhir valid
                $transaksiTerakhir = $transaksiTerakhir ? $transaksiTerakhir->toDateTimeString() : null;
    
                return [
                    'stock_id' => $stock->stock_id,
                    'product_name' => $product['product_name'] ?? 'Produk Tidak Ditemukan',
                    'merchant_name' => $stock->merchant->nama_merchant,
                    'stok' => $stock->jumlah_stok,
                    'kategori' => $category['nama_kategori'] ?? 'Belum dikategorikan',
                    'hargamodal' => $stock->hargamodal,
                    'hargajual' => $stock->hargajual,
                    'tanggal_expired' => $stock->tanggal_expired,
                    'transaksi_terakhir' => $transaksiTerakhir,
                    'total_barang_keluar' => $totalBarangKeluar,
                    'tanggal_masuk' => $stock->tanggal_masuk,
                    'stok_tersisa' => $stokTersisa,
                ];
            });
    
            $data = $data->sortByDesc('tanggal_masuk')->values()->all();
    
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}










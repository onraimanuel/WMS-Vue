<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\Stock;
use App\Models\Merchants;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


use Illuminate\Http\Request;

class TransaksiWarehouseController extends Controller
{
    private $baseApiUrl;

    public function __construct()
    {
        $this->baseApiUrl = 'https://kreatif.tobakab.go.id/api';
    }


    public function index(){
        return view('TransaksiWarehouse');
    }

    public function dataTransaksi()
    {
        $response = Http::get($this->baseApiUrl . '/listdaftarproduk');
        
        if ($response->successful()) {
            $products = $response->json(); 
            $productMap = [];
            
            foreach ($products as $product) {
                $productMap[$product['product_id']] = $product['product_name'];
            }
            
            $transaksis = Transaksi::select(
                'transaksi.transaksi_id',
                'stocks.product_id',
                'merchants.nama_merchant',
                'transaksi.jumlah_barang_keluar',
                'transaksi.tanggal_keluar'
            )
            ->join('stocks', 'transaksi.stock_id', '=', 'stocks.stock_id')
            ->join('merchants', 'stocks.merchant_id', '=', 'merchants.merchant_id')
            ->orderBy('transaksi.tanggal_keluar', 'desc') 
            ->get();

            foreach ($transaksis as $transaksi) {
                $transaksi->product_name = $productMap[$transaksi->product_id] ?? 'Unknown Product';
            }
            
            return response()->json($transaksis);
        } else {
            return response()->json(['error' => 'Failed to fetch products from external API'], 500);
        }
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
            $transaksi = Transaksi::findOrFail($id);
            $stock = Stock::where('stock_id', $transaksi->stock_id)->first();
            if (!$stock) {
                return response()->json(['error' => 'Stok tidak ditemukan'], 404);
            }
            $stock->sisa_stok += $transaksi->jumlah_barang_keluar;
            if (!$request->filled(['jumlah_barang_keluar', 'tanggal_keluar'])) {
                return response()->json(['error' => 'Lengkapi data jumlah barang keluar dan tanggal transaksi'], 400);
            }
            if ($stock->sisa_stok < $request->jumlah_barang_keluar) {
                return response()->json(['error' => 'Jumlah stok tidak mencukupi'], 400);
            }
            $stock->sisa_stok -= $request->jumlah_barang_keluar;
            $stock->save();
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

    public function reportBarang(Request $request)
    {
        $request->validate([
            'stock_id' => 'required|exists:stocks,stock_id',
            'nama_penanggung_jawab' => 'required|string|max:255',
            'kondisi_barang' => 'required|in:rusak,hilang',
            'jumlah_barang_keluar' => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
        ]);

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
            $transaksi->stock_id = $request->stock_id;
            $transaksi->nama_penanggung_jawab = $request->nama_penanggung_jawab;
            $transaksi->kondisi_barang = $request->kondisi_barang;
            $transaksi->jumlah_barang_keluar = $request->jumlah_barang_keluar;
            $transaksi->tanggal_keluar = $request->tanggal_keluar;
            $transaksi->save();

            DB::commit();

            return response()->json(['message' => 'Report berhasil ditambahkan'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    
    
}

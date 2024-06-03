<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class ProdukController extends Controller
{
    public function Produk(){
        return view('ProdukToko');
    }
    public function PembelianProduk(){
        return view('PembelianProduk');
    }

    public function Create(){
        return view('TambahProduk');
    }

    public function notifikasi(){
        return view('Notifikasi');
    }

    public function getNotifications()
    {
        $today = Carbon::today();
        $barangMasuk = Carbon::today()->subDays(1)->toDateString();
        $barangExp = Carbon::today()->addDays(30)->toDateString();
    
        $newProducts = DB::table('stocks')
                        ->where('tanggal_masuk', '>=', $barangMasuk)
                        ->get();
    
        $expiringProducts = DB::table('stocks')
                              ->where('tanggal_expired', '<=', $barangExp)
                              ->get();
        $damagedProducts = DB::table('transaksis')
                            ->select('stocks.*', 'transaksis.kondisi_barang')
                            ->join('stocks', 'transaksis.stock_id', '=', 'stocks.stock_id')
                            ->where('transaksis.kondisi_barang', 'rusak') // or 'hilang'
                            ->whereDate('transaksis.tanggal_keluar', $today)
                            ->get();
    
        $notifications = [
            'new_products' => $newProducts,
            'expiring_products' => $expiringProducts,
            'damaged_products' => $damagedProducts,
        ];
    
        return response()->json($notifications);
    }

}

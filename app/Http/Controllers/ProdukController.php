<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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


}

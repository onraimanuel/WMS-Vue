<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function LaporanPemesanan(){
        return view('LaporanPemesanan');
    }
    public function LaporanStok(){
        return view('LaporanStok');
    }
}

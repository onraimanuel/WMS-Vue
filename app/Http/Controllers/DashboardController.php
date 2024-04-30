<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Stocks;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function Dashboard()
    {
        $products = Product::all();
        return view('Dashboard');
    }

}

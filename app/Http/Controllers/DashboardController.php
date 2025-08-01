<?php

namespace App\Http\Controllers;

use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $guest = session('guest');

        $products = Product::all();
        return view('pages.index', compact('products'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $guest = session('guest');
        $order = session('order');

        $category = $request->query('category');

        $products = Product::query()
            ->when($category, function ($query, $category) {
                $query->where('category', $category);
            })
            ->where('is_available', true)
            ->latest()
            ->paginate(12);

        return view('pages.index', compact('products', 'order', 'category'));
    }
}

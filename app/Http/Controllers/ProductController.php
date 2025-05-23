<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('pages.product.index');
    }

    public function checkout()
    {
        return view('pages.product.checkout');
    }

    public function confirm()
    {
        return view('pages.product.confirm');
    }

    public function wait()
    {
        return view('pages.product.wait');
    }
}

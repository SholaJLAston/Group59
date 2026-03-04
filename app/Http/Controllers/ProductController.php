<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Controller to handle logic with product interaction
    public function index(Request $request) {
        $products = Product::all();
        return view('products', ['products' => $products]);
    }

    public function show(Product $product) {
        return view('products', ['product' => $product]);
    }
}

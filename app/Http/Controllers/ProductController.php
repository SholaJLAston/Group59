<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Controller to handle logic with product interaction
    public function index() {
        $products = Product::all();
        return view('product.index', ['products' => $products]);
    }

    public function show($product) {
        return view('products.show', compact('product'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Controller to handle logic with product interaction
    public function index(Request $request)
    {
        // base query with category relationship eager loaded
        $query = Product::with('category');

        // search by name or description
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%");
            });
        }

        // category filter using slug generated from name
        if ($request->filled('category') && $request->category !== 'all') {
            $slug = $request->category;
            $query->whereHas('category', function ($q) use ($slug) {
                $q->whereRaw("LOWER(REPLACE(name,' ','-')) = ?", [strtolower($slug)]);
            });
        }

        $products = $query->get();
        $categories = \App\Models\Category::all();

        return view('products', compact('products', 'categories'))
            ->with(['search' => $request->search ?? '', 'selectedCategory' => $request->category ?? 'all']);
    }

    public function show(Product $product)
    {
        // make sure category is available
        $product->load('category');
        return view('productdetails', compact('product'));
    }
}

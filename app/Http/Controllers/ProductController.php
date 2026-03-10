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

        // forward any filter form values so the UI can initialize
        return view('products', compact('products', 'categories'))
            ->with([
                'search' => $request->search ?? '',
                'selectedCategory' => $request->category ?? 'all',
                'minPrice' => $request->minPrice ?? '',
                'maxPrice' => $request->maxPrice ?? '',
                'inStockOnly' => $request->inStockOnly ?? false,
            ]);
    }

    public function show(Product $product)
    {
        // make sure category is available and eager load any reviews with reviewer
        $product->load(['category', 'reviews.user']);
        return view('productdetails', compact('product'));
    }
}

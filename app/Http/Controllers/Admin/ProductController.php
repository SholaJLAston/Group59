<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // View all products
    public function index()
    {
        //
    }

    // Show form to create new product
    public function create()
    {
        //
    }

    // Store new product
    public function store(Request $request)
    {
        //
    }

    // Show product details
    public function show(Product $product)
    {
        //
    }

    // Show form to edit product
    public function edit(Product $product)
    {
        //
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        //
    }

    // Delete product
    public function destroy(Product $product)
    {
        //
    }

    // Manage stock levels
    public function manageStock(Product $product)
    {
        //
    }

    // Update stock level
    public function updateStock(Request $request, Product $product)
    {
        //
    }

}

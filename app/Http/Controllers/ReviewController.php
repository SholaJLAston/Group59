<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        //
    }

    public function update(Request $request, ProductReview $review)
    {
        //
    }

    public function destroy(ProductReview $review)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $validated['user_id'] = $request->user()->id;
        $validated['product_id'] = $product->id;

        // ensure a user can only leave one review per product
        $review = ProductReview::updateOrCreate(
            ['product_id' => $product->id, 'user_id' => $validated['user_id']],
            ['rating' => $validated['rating'], 'comment' => $validated['comment']]
        );

        $message = $review->wasRecentlyCreated
            ? 'Your review has been submitted.'
            : 'Your review has been updated.';

        return back()->with('status', $message);
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

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
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);
        try {
            ProductReview::create([
                'product_id' => $product->id,
                'user_id' => $request->user()->id,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
            ]);
        } catch (\Exception $e) {
            return back()->with("error", "Failed to submit review: " . $e->getMessage());
        }
        return back()->with("success", "Review submitted successfully!");
    }

    public function update(Request $request, ProductReview $review)
    {
        //
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);
        $review->update($validated);
        return back()->with("success", "Review updated successfully!");
    }

    public function destroy(ProductReview $review)
    {
        //
        $review->delete();
        return back()->with("success", "Review deleted successfully!");
    }
}

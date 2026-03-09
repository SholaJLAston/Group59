<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    public function index()
    {
        // 
        $basket = Auth::user()->basket->with('basketItems.product')->first();

        $basketItems = $basket ? $basket->basketItems : collect();

        $total = $basketItems->sum(function (BasketItem $item) {
            return $item->quantity * $item->product->price;
        });

        return view(
            'basket.index',
            [
                'basket' => $basket,
                'basketItems' => $basketItems,
                'total' => $total,
            ]
        );
    }
    //
    public function add(Product $product) {
        $basket = Auth::user()->basket->firstOrCreate(['user_id' => Auth::id()]);

        $basketItem = $basket->basketItems()->where('product_id', $product->id)->first();

        if ($basketItem) {
            $basketItem->increment('quantity');
        } else {
            $basket->basketItems()->create([
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return back()->with('Product added to basket successfully.');
    }

    public function remove(BasketItem $basketItem) {
    
        $basketItem->delete();

        return back()->with('Product removed from basket successfully.');
    }

    public function update(BasketItem $basketItem, Request $request) {
        $validated = $request->validated(['quantity'=> 'required|integer|min:1']);

        $basketItem->update(['quantity' => $validated['quantity']]);

        return back()->with('Product updated successfully.');
    }

    public function store(Request $request)
    {
        // 
    }

    public function clear()
    {
        // 
        $basket = Auth::user()->basket;

        if ($basket) {
            $basket->basketItems()->delete();
        }

        return back()->with('Basket cleared successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    //
    public function add(Product $product): Basket {
        $basket = Auth::user()->baskets()->firstOrCreate(['user_id' => Auth::id()]);

        $basketItem = $basket->basketItems()->where('product_id', $product->id)->first();

        if ($basketItem) {
            $basketItem->quantity += 1;
            $basketItem->save();
        } else {
            $basketItem = BasketItem::create([ 'basket_id'=> $basket->id, 'product_id'=> $product->id, 'quantity'=> 1 ]);
        }

        return back()->with('Product added to basket successfully.');
    }

    public function remove(BasketItem $basketItem): Basket {
        $basketItem->delete();

        return back()->with('Product removed from basket successfully.');
    }

    public function update(BasketItem $basketItem, Request $request): Basket {
        $validated = $request->validated(['quantity'=> 'required|integer|min:1']);

        if ($validated['quantity'] == 0) {
            $basketItem->delete();
            return back()->with('Product removed from basket successfully.');
        }

        $basketItem->update(['quantity' => $validated['quantity']]);

        return back()->with('Product updated successfully.');
    }

}

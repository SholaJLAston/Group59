<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    public function add(Product $product) {
        $basket = Auth::user()->basket()->firstOrCreate(['user_id' => Auth::id()]);

        $basketItem = $basket->items()->where('product_id', $product->id)->first();

        if ($basketItem) {
            $basketItem->quantity += 1;
            $basketItem->save();
        } else {
            $basketItem = BasketItem::create([
              'basket_id' => $basket->id,
              'product_id' => $product->id,
              'quantity' => 1,
            ]);
        }

        return back()->with('Item added to basket');
    }

    public function remove(BasketItem $basketItem) {
        $basketItem->delete();

        return back()->with('Item removed from basket');
    }

    public function update(Request $request, BasketItem $basketItem) {
        $request->validate(['quantity' => 'required|numeric']);

        $basketItem->update(['quantity' => $request->quantity]);

        return back()->with('Item updated to basket');
    }

    public function removeAll() {

    }
}

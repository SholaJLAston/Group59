<?php

namespace App\Http\Controllers;

use App\Models\BasketItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BasketController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $basket = $user
            ? $user->basket()->with('basketItems.product')->first()
            : null;
        $items = $basket?->basketItems ?? collect();

        $total = $items->sum(function (BasketItem $item) {
            $price = (float) ($item->product->price ?? 0);
            return $price * $item->quantity;
        });

        return view('basket', compact('items', 'total'));
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => 'nullable|integer|min:1|max:99',
        ]);

        $quantityToAdd = $validated['quantity'] ?? 1;

        if ($product->stock_quantity <= 0) {
            return back()->with('error', 'This product is currently out of stock.');
        }

        $basket = Auth::user()->basket()->firstOrCreate();
        $basketItem = $basket->basketItems()->firstOrNew(['product_id' => $product->id]);

        $currentQty = $basketItem->exists ? $basketItem->quantity : 0;
        $newQty = $currentQty + $quantityToAdd;

        if ($newQty > $product->stock_quantity) {
            return back()->with('error', 'Requested quantity exceeds available stock.');
        }

        $basketItem->quantity = $newQty;
        $basketItem->save();

        return back()->with('status', 'Product added to basket successfully.');
    }

    public function update(Request $request, BasketItem $basketItem): RedirectResponse
    {
        $this->assertOwnership($basketItem);

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $quantity = $validated['quantity'];
        $availableStock = (int) ($basketItem->product->stock_quantity ?? 0);

        if ($quantity > $availableStock) {
            return back()->with('error', 'Requested quantity exceeds available stock.');
        }

        $basketItem->update(['quantity' => $quantity]);

        return back()->with('status', 'Basket updated successfully.');
    }

    public function remove(BasketItem $basketItem): RedirectResponse
    {
        $this->assertOwnership($basketItem);
        $basketItem->delete();

        return back()->with('status', 'Product removed from basket successfully.');
    }

    public function clear(): RedirectResponse
    {
        $basket = Auth::user()->basket;

        if ($basket) {
            $basket->basketItems()->delete();
        }

        return back()->with('status', 'Basket cleared successfully.');
    }

    private function assertOwnership(BasketItem $basketItem): void
    {
        $userBasketId = Auth::user()->basket?->id;

        if (!$userBasketId || $basketItem->basket_id !== $userBasketId) {
            abort(403);
        }
    }
}

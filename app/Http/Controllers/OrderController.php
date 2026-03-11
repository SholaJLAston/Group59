<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //
    public function index() {
        $orders =Auth::user()->orders()->latest()->get();

        return view('order.index', compact('orders'));
    }

    public function show(Order $order) {
        if ($order->user_id != Auth::id()) {
            abort(403);
        }
        $order->load('orderItems.product');

        return view('order.show', compact('order'));
    }

    public function store() {
        $basket = Auth::user()->basket()->with('basketItems.product')->first();

        if (!$basket || $basket->basketItems->isEmpty()) {
            return back()->with('error', 'Basket is empty');
        }

        $total = 0;

        foreach ($basket->basketItems as $basketItem) {
                $unitPrice = (float) $basketItem->product->price;
                $total += $unitPrice * $basketItem->quantity;
        }

        $order = Order::create([
           'user_id' => Auth::id(),
              'price' => $total,
           'status' => 'pending'
        ]);

        foreach ($basket->basketItems as $basketItem) {
                $unitPrice = (float) $basketItem->product->price;

            OrderItem::create([
               'order_id' => $order->id,
               'product_id' => $basketItem->product_id,
               'quantity' => $basketItem->quantity,
                    'purchase_price' => $unitPrice,
            ]);

            $basketItem->product->decrement('stock_quantity', $basketItem->quantity);
        }

        // Clear basket
          $basket->basketItems()->delete();

        return redirect()->route('order.show', $order);
    }

}

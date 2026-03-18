<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingAddress;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
        $order->load('orderItems.product', 'shippingAddress', 'user');

        return view('order.show', compact('order'));
    }

    public function checkout(): View
    {
        $user = Auth::user();
        $basket = $user->basket()->with('basketItems.product')->first();

        if (!$basket || $basket->basketItems->isEmpty()) {
            return redirect()->route('basket')->with('error', 'Basket is empty. Add items before checkout.');
        }

        $items = $basket->basketItems;
        $total = $items->sum(function ($item) {
            return (float) $item->product->price * $item->quantity;
        });

        // Try to load last order's shipping address
        $lastShippingAddress = null;
        if ($user->orders()->count() > 0) {
            $lastOrder = $user->orders()->latest()->first();
            $lastShippingAddress = $lastOrder->shippingAddress;
        }

        return view('checkout', compact('items', 'total', 'user', 'lastShippingAddress'));
    }

    public function processCheckout(Request $request)
    {
        $user = Auth::user();
        $basket = $user->basket()->with('basketItems.product')->first();

        if (!$basket || $basket->basketItems->isEmpty()) {
            return redirect()->route('basket')->with('error', 'Basket is empty');
        }

        // Validate address fields
        $validated = $request->validate([
            'street_address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'phone_number' => 'required|string|max:20',
        ]);

        $total = 0;

        foreach ($basket->basketItems as $basketItem) {
            $unitPrice = (float) $basketItem->product->price;
            $total += $unitPrice * $basketItem->quantity;

            // Verify stock is still available
            if ($basketItem->product->stock_quantity < $basketItem->quantity) {
                return back()->with('error', "Insufficient stock for {$basketItem->product->name}. Available: {$basketItem->product->stock_quantity}");
            }
        }

        // Generate unique order number for user
        $orderNumber = Order::generateOrderNumber(Auth::id());

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => $orderNumber,
            'price' => $total,
            'status' => 'pending'
        ]);

        // Create shipping address
        ShippingAddress::create([
            'order_id' => $order->id,
            'street_address' => $validated['street_address'],
            'city' => $validated['city'],
            'postal_code' => $validated['postal_code'],
            'phone_number' => $validated['phone_number'],
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

            StockMovement::create([
                'product_id' => $basketItem->product_id,
                'type' => 'out',
                'quantity' => $basketItem->quantity,
                'reference' => 'Customer order #' . $order->id,
            ]);
        }

        // Clear basket
        $basket->basketItems()->delete();

        return redirect()->route('order.show', $order)->with('success', 'Order created successfully!');
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

            StockMovement::create([
                'product_id' => $basketItem->product_id,
                'type' => 'out',
                'quantity' => $basketItem->quantity,
                'reference' => 'Customer order #' . $order->id,
            ]);
        }

        // Clear basket
          $basket->basketItems()->delete();

        return redirect()->route('order.show', $order);
    }

}


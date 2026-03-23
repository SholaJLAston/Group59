<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ShippingAddress;
use App\Models\StockMovement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $order->load('orderItems.product', 'shippingAddress', 'user', 'returns');

        return view('order.show', compact('order'));
    }

    public function checkout(): View|RedirectResponse
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

        try {
            $order = DB::transaction(function () use ($basket, $user, $validated) {
                $lines = [];
                $total = 0.0;

                foreach ($basket->basketItems as $basketItem) {
                    $product = Product::query()->lockForUpdate()->find($basketItem->product_id);

                    if (!$product || $product->stock_quantity < $basketItem->quantity) {
                        $productName = $basketItem->product?->name ?? 'selected product';
                        $available = $product?->stock_quantity ?? 0;

                        throw new \RuntimeException("Insufficient stock for {$productName}. Available: {$available}");
                    }

                    $unitPrice = (float) $product->price;
                    $lines[] = [
                        'product' => $product,
                        'product_id' => $product->id,
                        'quantity' => $basketItem->quantity,
                        'purchase_price' => $unitPrice,
                    ];
                    $total += $unitPrice * $basketItem->quantity;
                }

                $order = Order::create([
                    'user_id' => $user->id,
                    'order_number' => Order::generateOrderNumber(),
                    'price' => $total,
                    'status' => 'pending',
                ]);

                ShippingAddress::create([
                    'order_id' => $order->id,
                    'street_address' => $validated['street_address'],
                    'city' => $validated['city'],
                    'postal_code' => $validated['postal_code'],
                    'phone_number' => $validated['phone_number'],
                ]);

                foreach ($lines as $line) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $line['product_id'],
                        'quantity' => $line['quantity'],
                        'purchase_price' => $line['purchase_price'],
                    ]);

                    $line['product']->decrement('stock_quantity', $line['quantity']);

                    StockMovement::create([
                        'product_id' => $line['product_id'],
                        'type' => 'out',
                        'quantity' => $line['quantity'],
                        'reference' => 'Customer order #' . $order->id,
                    ]);
                }

                $basket->basketItems()->delete();

                return $order;
            });
        } catch (\RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        return redirect()->route('order.show', $order)->with('success', 'Order created successfully!');
    }

    public function store() {
        return redirect()
            ->route('checkout')
            ->with('error', 'Please complete your order through checkout.');
    }

}


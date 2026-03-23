<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatbotController extends Controller
{
    public function query(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:500'],
        ]);

        $message = trim($validated['message']);
        $normalized = strtolower($message);

        if ($this->isGreeting($normalized)) {
            return response()->json([
                'reply' => 'Hi! I can help with product prices, stock status, and your order updates. Ask things like: "price of drill", "is hammer in stock", or "my latest order".',
            ]);
        }

        if ($this->isOrderIntent($normalized)) {
            return response()->json([
                'reply' => $this->buildOrderReply(),
            ]);
        }

        if ($this->isStockIntent($normalized) || $this->isProductIntent($normalized)) {
            return response()->json([
                'reply' => $this->buildProductReply($message, $normalized),
            ]);
        }

        if (str_contains($normalized, 'delivery') || str_contains($normalized, 'shipping')) {
            return response()->json([
                'reply' => 'We provide fast dispatch on most items. For exact delivery timing, check stock availability on the product page and your order status in My Orders after purchase.',
            ]);
        }

        if (str_contains($normalized, 'return') || str_contains($normalized, 'refund')) {
            return response()->json([
                'reply' => 'You can request returns for purchased products from your account area. Go to My Orders, open the order details, and follow the return process.',
            ]);
        }

        return response()->json([
            'reply' => 'I can help with products, stock, and orders. Try asking: "show in-stock products", "stock for screwdriver", or "what is my order status".',
        ]);
    }

    private function isGreeting(string $normalized): bool
    {
        return str_contains($normalized, 'hello')
            || str_contains($normalized, 'hi')
            || str_contains($normalized, 'hey');
    }

    private function isOrderIntent(string $normalized): bool
    {
        return str_contains($normalized, 'order')
            || str_contains($normalized, 'track')
            || str_contains($normalized, 'status');
    }

    private function isStockIntent(string $normalized): bool
    {
        return str_contains($normalized, 'stock')
            || str_contains($normalized, 'available')
            || str_contains($normalized, 'availability');
    }

    private function isProductIntent(string $normalized): bool
    {
        return str_contains($normalized, 'product')
            || str_contains($normalized, 'price')
            || str_contains($normalized, 'cost')
            || str_contains($normalized, 'show');
    }

    private function buildOrderReply(): string
    {
        if (!Auth::check()) {
            return 'Please log in to check your orders. After login, open My Orders to see full tracking and status updates.';
        }

        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->take(3)
            ->get(['id', 'status', 'price', 'created_at']);

        if ($orders->isEmpty()) {
            return 'You have no orders yet. Start shopping from Products, then place your first order from your basket.';
        }

        $latest = $orders->first();
        $summary = "Your latest order is #{$latest->id} with status: {$latest->status}.";

        if ($orders->count() === 1) {
            return $summary . ' You can open My Orders for details.';
        }

        $more = $orders
            ->slice(1)
            ->map(fn ($order) => "#{$order->id} ({$order->status})")
            ->implode(', ');

        return $summary . " Recent orders: {$more}.";
    }

    private function buildProductReply(string $message, string $normalized): string
    {
        $query = $this->extractProductQuery($message);

        if ($query !== '') {
            $product = Product::query()
                ->where('name', 'like', '%' . $query . '%')
                ->orWhere('description', 'like', '%' . $query . '%')
                ->first();

            if ($product) {
                $status = ((int) $product->stock_quantity) > 0 ? 'In Stock' : 'Out of Stock';

                return "{$product->name}: {$status} ({$product->stock_quantity} available), price £" . number_format((float) $product->price, 2) . '.';
            }
        }

        if (str_contains($normalized, 'in stock') || str_contains($normalized, 'available') || str_contains($normalized, 'show')) {
            $inStock = Product::query()
                ->where('stock_quantity', '>', 0)
                ->orderByDesc('stock_quantity')
                ->take(5)
                ->get(['name', 'price']);

            if ($inStock->isEmpty()) {
                return 'No products are currently marked in stock.';
            }

            $list = $inStock
                ->map(fn ($item) => "{$item->name} (£" . number_format((float) $item->price, 2) . ')')
                ->implode(', ');

            return 'Top in-stock products right now: ' . $list . '.';
        }

        return 'Tell me the product name and I will check stock and price for you. Example: "stock for cordless drill".';
    }

    private function extractProductQuery(string $message): string
    {
        $query = strtolower($message);
        $query = preg_replace('/[^a-z0-9\s]/', ' ', $query) ?? '';

        $stopWords = [
            'price', 'cost', 'stock', 'availability', 'available', 'show', 'product',
            'for', 'of', 'the', 'is', 'in', 'a', 'an', 'please', 'check', 'me', 'my',
        ];

        $parts = array_filter(explode(' ', $query), function ($part) use ($stopWords) {
            return $part !== '' && !in_array($part, $stopWords, true);
        });

        return trim(implode(' ', $parts));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    // Dashboard view with current stock levels and real-time status
    public function dashboard(): View
    {
        $totalRevenue = (float) Order::where('status', 'delivered')->sum('price');
        $totalOrders = Order::count();
        $processingOrders = Order::where('status', 'processing')->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $productsCount = Product::count();
        $customersCount = DB::table('users')->where('role', 'customer')->count();
        $recentOrders = Order::with('user')->latest()->take(8)->get();

        return view('admin.dashboard-overview', compact('totalRevenue', 'totalOrders', 'processingOrders', 'pendingOrders', 'productsCount', 'customersCount', 'recentOrders'));
    }

    // View all stock levels
    public function index(Request $request): View
    {
        $query = Product::query()->with('category');

        if ($search = trim((string) $request->input('q'))) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        if ($status = $request->input('status')) {
            if ($status === 'out') {
                $query->where('stock_quantity', '<=', 0);
            } elseif ($status === 'low') {
                $query->whereColumn('stock_quantity', '<=', 'low_stock_threshold')
                    ->where('stock_quantity', '>', 0);
            } elseif ($status === 'in') {
                $query->whereColumn('stock_quantity', '>', 'low_stock_threshold');
            }
        }

        $products = $query->orderBy('name')->paginate(20)->withQueryString();
        $categories = DB::table('categories')->orderBy('name')->get(['id', 'name']);

        return view('admin.inventory.inventory-stock-levels', compact('products', 'categories'));
    }

    // Create incoming stock movement
    public function createIncoming(): View
    {
        $products = Product::orderBy('name')->get(['id', 'name', 'stock_quantity']);

        return view('admin.inventory.inventory-stock-incoming', compact('products'));
    }

    // Store incoming stock movement
    public function storeIncoming(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'reference' => ['nullable', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($validated) {
            $product = Product::lockForUpdate()->findOrFail($validated['product_id']);
            $product->increment('stock_quantity', (int) $validated['quantity']);

            StockMovement::create([
                'product_id' => $product->id,
                'type' => 'in',
                'quantity' => (int) $validated['quantity'],
                'reference' => $validated['reference'] ?: 'Manual incoming stock',
            ]);
        });

        return redirect()->route('admin.inventory.movements')
            ->with('status', 'Incoming stock processed successfully.');
    }

    // View stock movement history
    public function movements(Request $request): View
    {
        $query = StockMovement::query()->with('product')->latest();

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        if ($search = trim((string) $request->input('q'))) {
            $query->where(function ($inner) use ($search) {
                $inner->where('reference', 'like', '%' . $search . '%')
                    ->orWhereHas('product', function ($productQuery) use ($search) {
                        $productQuery->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        $movements = $query->paginate(25)->withQueryString();

        return view('admin.inventory.inventory-stock-movements', compact('movements'));
    }

    // Manage low stock alerts
    public function lowStockAlerts(): View
    {
        $lowStockProducts = Product::with('category')
            ->whereColumn('stock_quantity', '<=', 'low_stock_threshold')
            ->orderBy('stock_quantity')
            ->paginate(20);

        return view('admin.inventory.inventory-stock-alerts', compact('lowStockProducts'));
    }

    // Update low stock threshold
    public function updateThreshold(Request $request, Product $product)
    {
        $validated = $request->validate([
            'low_stock_threshold' => ['required', 'integer', 'min:1', 'max:10000'],
        ]);

        $product->update([
            'low_stock_threshold' => $validated['low_stock_threshold'],
        ]);

        return back()->with('status', 'Low stock threshold updated.');
    }

    // View detailed stock information for a product
    public function viewProduct(Product $product): View
    {
        $product->load('category');
        $movements = $product->stockMovements()->latest()->paginate(20);

        return view('admin.inventory.inventory-product-detail', compact('product', 'movements'));
    }
}

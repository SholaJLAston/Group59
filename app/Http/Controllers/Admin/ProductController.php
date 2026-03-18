<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\StockMovement;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // View all products
    public function index(Request $request): View
    {
        $query = Product::query()->with('category');

        if ($search = trim((string) $request->input('q'))) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', (int) $request->input('category_id'));
        }

        $products = $query->latest()->paginate(20)->withQueryString();
        $categories = Category::orderBy('name')->get(['id', 'name']);

        return view('admin.products.products-catalog', compact('products', 'categories'));
    }

    // Show form to create new product
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.product-form-create', compact('categories'));
    }

    // Store new product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'low_stock_threshold' => ['required', 'integer', 'min:1', 'max:10000'],
            'image_url' => ['nullable', 'string', 'max:255'],
        ]);

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('status', 'Product created successfully.');
    }

    // Show product details
    public function show(Product $product): View
    {
        $product->load('category');

        return view('admin.products.product-detail', compact('product'));
    }

    // Show form to edit product
    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.product-form-edit', compact('product', 'categories'));
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'low_stock_threshold' => ['required', 'integer', 'min:1', 'max:10000'],
            'image_url' => ['nullable', 'string', 'max:255'],
        ]);

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('status', 'Product updated successfully.');
    }

    // Delete product
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('status', 'Product deleted successfully.');
    }

    // Manage stock levels
    public function manageStock(Product $product): View
    {
        return view('admin.products.product-stock-manage', compact('product'));
    }

    // Update stock level
    public function updateStock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'action' => ['required', 'in:set,increase,decrease'],
            'quantity' => ['required', 'integer', 'min:1'],
            'reference' => ['nullable', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($product, $validated) {
            $product->refresh();

            $quantity = (int) $validated['quantity'];
            $action = $validated['action'];

            if ($action === 'set') {
                $newStock = $quantity;
                $diff = $newStock - (int) $product->stock_quantity;
                $product->update(['stock_quantity' => $newStock]);

                if ($diff !== 0) {
                    StockMovement::create([
                        'product_id' => $product->id,
                        'type' => $diff > 0 ? 'in' : 'out',
                        'quantity' => abs($diff),
                        'reference' => $validated['reference'] ?: 'Manual stock set',
                    ]);
                }

                return;
            }

            if ($action === 'increase') {
                $product->increment('stock_quantity', $quantity);

                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'in',
                    'quantity' => $quantity,
                    'reference' => $validated['reference'] ?: 'Manual increase',
                ]);

                return;
            }

            if ($product->stock_quantity < $quantity) {
                abort(422, 'Cannot decrease below zero stock.');
            }

            $product->decrement('stock_quantity', $quantity);

            StockMovement::create([
                'product_id' => $product->id,
                'type' => 'out',
                'quantity' => $quantity,
                'reference' => $validated['reference'] ?: 'Manual decrease',
            ]);
        });

        return redirect()->route('admin.products.stock', $product)->with('status', 'Stock updated successfully.');
    }

}

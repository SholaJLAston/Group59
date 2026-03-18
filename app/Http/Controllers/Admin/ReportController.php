<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Contracts\View\View;

class ReportController extends Controller
{
    // Generate and display stock level report
    public function stockLevels(): View
    {
        $products = Product::with('category')->orderBy('name')->get();
        $summary = [
            'total_products' => $products->count(),
            'total_units' => $products->sum('stock_quantity'),
            'in_stock' => $products->where('stock_status', 'In Stock')->count(),
            'low_stock' => $products->where('stock_status', 'Low Stock')->count(),
            'out_of_stock' => $products->where('stock_status', 'Out of Stock')->count(),
        ];

        return view('admin.reports.stock-levels', compact('products', 'summary'));
    }

    // Generate and display incoming orders report
    public function incomingOrders(): View
    {
        $incoming = StockMovement::with('product')
            ->where('type', 'in')
            ->latest()
            ->paginate(25);

        return view('admin.reports.incoming-orders', compact('incoming'));
    }

    // Generate and display outgoing orders report
    public function outgoingOrders(): View
    {
        $outgoing = StockMovement::with('product')
            ->where('type', 'out')
            ->latest()
            ->paginate(25);

        return view('admin.reports.outgoing-orders', compact('outgoing'));
    }



}

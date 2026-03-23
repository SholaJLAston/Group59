@extends('layouts.admin')

@section('title', 'Stock Levels Report')
@section('page-title', 'Stock Levels Report')

@section('extra-css')
<style>
.stock-grid { display:grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 18px; margin-bottom: 20px; }
.stock-card { background:#fff; border:1px solid #ddd; border-radius:18px; min-height:130px; padding:24px 28px; }
.stock-card .label { color:#6a6a6a; font-size:14px; margin-bottom:8px; font-weight:500; }
.stock-card .value { font-size:32px; font-weight:700; line-height:1.1; color:#111827; }
.stock-card .note { margin-top:8px; color:#6b7280; font-size:13px; }
.stock-table-box { background:#fff; border:1px solid #ddd; border-radius:18px; overflow:auto; }
.stock-table { width:100%; border-collapse:collapse; }
.stock-table th, .stock-table td { padding:14px 16px; text-align:left; border-bottom:1px solid #f1f5f9; }
.stock-table th { background:#f9f9f9; color:#6b7280; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:.03em; }
.stock-status-in { display:inline-block; background:#dcf5e5; color:#187748; padding:6px 10px; border-radius:6px; font-size:12px; font-weight:600; }
.stock-status-low { display:inline-block; background:#fff4d6; color:#9a6900; padding:6px 10px; border-radius:6px; font-size:12px; font-weight:600; }
.stock-status-out { display:inline-block; background:#fee2e2; color:#991b1b; padding:6px 10px; border-radius:6px; font-size:12px; font-weight:600; }

@media (max-width: 1240px) {
    .stock-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}

@media (max-width: 720px) {
    .stock-grid { grid-template-columns: 1fr; }
    .stock-card .value { font-size:28px; }
}
</style>
@endsection

@section('content')
<div class="stock-grid">
    <div class="stock-card">
        <div class="label">Total Products</div>
        <div class="value">{{ $summary['total_products'] }}</div>
    </div>

    <div class="stock-card">
        <div class="label">Total Units</div>
        <div class="value">{{ $summary['total_units'] }}</div>
    </div>

    <div class="stock-card">
        <div class="label">Out of Stock</div>
        <div class="value">{{ $summary['out_of_stock'] }}</div>
        <div class="note">Products with 0 units</div>
    </div>

    <div class="stock-card">
        <div class="label">Low Stock</div>
        <div class="value">{{ $summary['low_stock'] }}</div>
        <div class="note">Below threshold</div>
    </div>
</div>

<div class="stock-table-box">
    <table class="stock-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Category</th>
                <th>Stock Qty</th>
                <th>Threshold</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td><strong>{{ $product->name }}</strong></td>
                <td>{{ $product->category->name ?? '-' }}</td>
                <td>{{ $product->stock_quantity }}</td>
                <td>{{ $product->low_stock_threshold }}</td>
                <td>
                    @if($product->stock_status === 'In Stock')
                        <span class="stock-status-in">In Stock</span>
                    @elseif($product->stock_status === 'Low Stock')
                        <span class="stock-status-low">Low Stock</span>
                    @else
                        <span class="stock-status-out">Out of Stock</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection


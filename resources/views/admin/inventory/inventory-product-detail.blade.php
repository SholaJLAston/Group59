@extends('layouts.admin')

@section('title', 'Inventory Product')
@section('page-title', 'Inventory Product')

@section('content')
<div class="admin-container" style="max-width:1100px;">
    <div class="admin-card" style="margin-bottom:12px;">
        <h2 style="margin:0 0 12px;font-size:22px;font-weight:800;">Inventory Detail: {{ $product->name }}</h2>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:10px;">
            <div><strong>Category:</strong> {{ $product->category->name ?? '-' }}</div>
            <div><strong>Current Stock:</strong> {{ $product->stock_quantity }}</div>
            <div>
                <strong>Status:</strong>
                @if($product->stock_status === 'Out of Stock')
                    <span class="status-pill status-out">Out of Stock</span>
                @elseif($product->stock_status === 'Low Stock')
                    <span class="status-pill status-low">Low Stock</span>
                @else
                    <span class="status-pill status-in">In Stock</span>
                @endif
            </div>
            <div><strong>Low Stock Threshold:</strong> {{ $product->low_stock_threshold }}</div>
        </div>

        <div style="margin-top:12px;">
            <a href="{{ route('admin.products.stock', $product) }}" class="admin-btn admin-btn-primary">Manage Stock</a>
        </div>
    </div>

    <div class="admin-table-card">
        <table class="admin-table">
            <thead><tr><th>Date</th><th>Type</th><th>Qty</th><th>Reference</th></tr></thead>
            <tbody>
            @forelse($movements as $move)
                <tr>
                    <td>{{ $move->created_at->format('d M Y H:i') }}</td>
                    <td>{{ strtoupper($move->type) }}</td>
                    <td>{{ $move->quantity }}</td>
                    <td>{{ $move->reference }}</td>
                </tr>
            @empty
                <tr><td colspan="4">No movements found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-wrap">{{ $movements->links('pagination::bootstrap-5') }}</div>
</div>
@endsection


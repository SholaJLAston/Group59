@extends('layouts.admin')

@section('title', 'Low Stock Alerts')
@section('page-title', 'Low Stock Alerts')

@section('content')
<div class="admin-container" style="max-width:1100px;">

    @if(session('status'))<div style="margin-bottom:10px;color:#065f46;">{{ session('status') }}</div>@endif

    <div class="admin-table-card">
        <table class="admin-table">
            <thead><tr><th>Product</th><th>Category</th><th>Stock</th><th>Threshold</th><th>Update</th></tr></thead>
            <tbody>
            @forelse($lowStockProducts as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td>
                        {{ $product->stock_quantity }}
                        @if($product->stock_status === 'Out of Stock')
                            <span class="status-pill status-out">Out of Stock</span>
                        @elseif($product->stock_status === 'Low Stock')
                            <span class="status-pill status-low">Low Stock</span>
                        @else
                            <span class="status-pill status-in">In Stock</span>
                        @endif
                    </td>
                    <td>{{ $product->low_stock_threshold }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.inventory.threshold.update', $product) }}" class="admin-form-row" style="flex-wrap:nowrap;">
                            @csrf @method('PATCH')
                            <input class="admin-input" type="number" name="low_stock_threshold" value="{{ $product->low_stock_threshold }}" min="1" style="width:110px;">
                            <button type="submit" class="admin-btn admin-btn-dark">Save</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No low stock alerts.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">{{ $lowStockProducts->links('pagination::bootstrap-5') }}</div>
</div>
@endsection


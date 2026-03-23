@extends('layouts.admin')

@section('title', 'Inventory Status')
@section('page-title', 'Inventory Status')

@section('content')
<div class="admin-container">
    <div class="admin-toolbar">
        <form method="GET" action="{{ route('admin.inventory.index') }}" class="admin-form-row">
            <input class="admin-input" name="q" value="{{ request('q') }}" placeholder="Search product">
            <select class="admin-select" name="category_id">
                <option value="">All categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ (string)request('category_id') === (string)$category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            <select class="admin-select" name="status">
                <option value="">All statuses</option>
                <option value="in" {{ request('status')==='in' ? 'selected' : '' }}>In Stock</option>
                <option value="low" {{ request('status')==='low' ? 'selected' : '' }}>Low Stock</option>
                <option value="out" {{ request('status')==='out' ? 'selected' : '' }}>Out Of Stock</option>
            </select>
            <button type="submit" class="admin-btn admin-btn-dark">Filter</button>
        </form>
        <a href="{{ route('admin.inventory.incoming.create') }}" class="admin-btn admin-btn-primary">Process Incoming Stock</a>
    </div>

    <div class="admin-table-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Threshold</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse($products as $product)
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
                    <td>{{ $product->low_stock_threshold ?? 5 }}</td>
                    <td><a class="admin-btn admin-btn-dark" href="{{ route('admin.inventory.products.show', $product) }}">View</a></td>
                </tr>
            @empty
                <tr><td colspan="5">No products found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">{{ $products->links('pagination::bootstrap-5') }}</div>
</div>
@endsection


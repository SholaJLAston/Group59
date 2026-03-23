@extends('layouts.app')

@section('title', 'Inventory Status')

@section('content')
<div style="max-width:1200px;margin:0 auto;padding:28px 16px 50px;">
    <h1 style="margin:0 0 14px;">Inventory Management</h1>
    @include('admin._menu')

    <div style="display:flex;justify-content:space-between;gap:8px;flex-wrap:wrap;margin-bottom:12px;">
        <form method="GET" action="{{ route('admin.inventory.index') }}" style="display:flex;gap:8px;flex-wrap:wrap;">
            <input name="q" value="{{ request('q') }}" placeholder="Search product" style="padding:8px 10px;border:1px solid #ddd;border-radius:8px;">
            <select name="category_id" style="padding:8px 10px;border:1px solid #ddd;border-radius:8px;">
                <option value="">All categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ (string)request('category_id') === (string)$category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            <select name="status" style="padding:8px 10px;border:1px solid #ddd;border-radius:8px;">
                <option value="">All statuses</option>
                <option value="in" {{ request('status')==='in' ? 'selected' : '' }}>In Stock</option>
                <option value="low" {{ request('status')==='low' ? 'selected' : '' }}>Low Stock</option>
                <option value="out" {{ request('status')==='out' ? 'selected' : '' }}>Out Of Stock</option>
            </select>
            <button type="submit" style="padding:8px 12px;border:none;border-radius:8px;background:#111827;color:#fff;">Filter</button>
        </form>
        <a href="{{ route('admin.inventory.incoming.create') }}" style="padding:8px 12px;border-radius:8px;background:#d47c17;color:#fff;text-decoration:none;">Process Incoming Stock</a>
    </div>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">
        <table style="width:100%;border-collapse:collapse;">
            <thead><tr><th style="padding:10px;text-align:left;">Product</th><th style="padding:10px;text-align:left;">Category</th><th style="padding:10px;text-align:left;">Stock</th><th style="padding:10px;text-align:left;">Threshold</th><th style="padding:10px;text-align:left;">Action</th></tr></thead>
            <tbody>
            @forelse($products as $product)
                <tr>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">{{ $product->name }}</td>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">{{ $product->category->name ?? '-' }}</td>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">{{ $product->stock_quantity }} ({{ $product->stock_status }})</td>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">{{ $product->low_stock_threshold ?? 5 }}</td>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;"><a href="{{ route('admin.inventory.products.show', $product) }}">View</a></td>
                </tr>
            @empty
                <tr><td colspan="5" style="padding:10px;">No products found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:12px;">{{ $products->links() }}</div>
</div>
@endsection
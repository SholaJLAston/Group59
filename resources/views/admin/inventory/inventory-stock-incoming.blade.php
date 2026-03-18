@extends('layouts.admin')

@section('title', 'Incoming Stock')
@section('page-title', 'Incoming Stock')

@section('content')
<div class="admin-container" style="max-width:920px;">
    <div class="admin-card" style="border-radius:22px;padding:22px;">
        <h2 style="margin:0 0 14px;font-size:24px;font-weight:800;color:#111827;">Process Incoming Stock</h2>

        <form method="POST" action="{{ route('admin.inventory.incoming.store') }}" style="display:grid;gap:12px;">
        @csrf
        <select class="admin-select" name="product_id">
            @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }} (current: {{ $product->stock_quantity }})</option>
            @endforeach
        </select>
        <input class="admin-input" name="quantity" type="number" min="1" value="1" placeholder="Quantity">
        <input class="admin-input" name="reference" placeholder="Supplier invoice/reference">

            <div style="display:flex;justify-content:flex-end;">
                <button type="submit" class="admin-btn admin-btn-primary">Add Incoming Stock</button>
            </div>
        </form>
    </div>
</div>
@endsection


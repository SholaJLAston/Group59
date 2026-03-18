@extends('layouts.admin')

@section('title', 'Incoming Stock')
@section('page-title', 'Incoming Stock')

@section('content')
<div style="max-width:760px;margin:0 auto;padding:28px 16px 50px;">
    <h1 style="margin:0 0 14px;">Process Incoming Stock</h1>

    <form method="POST" action="{{ route('admin.inventory.incoming.store') }}" style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:16px;display:grid;gap:10px;">
        @csrf
        <select name="product_id" style="padding:9px 10px;border:1px solid #ddd;border-radius:8px;">
            @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }} (current: {{ $product->stock_quantity }})</option>
            @endforeach
        </select>
        <input name="quantity" type="number" min="1" value="1" style="padding:9px 10px;border:1px solid #ddd;border-radius:8px;">
        <input name="reference" placeholder="Supplier invoice/reference" style="padding:9px 10px;border:1px solid #ddd;border-radius:8px;">
        <button type="submit" style="border:none;background:#d47c17;color:#fff;padding:10px 12px;border-radius:8px;">Add Incoming Stock</button>
    </form>
</div>
@endsection


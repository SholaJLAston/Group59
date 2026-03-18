@extends('layouts.admin')

@section('title', $product->name)

@section('content')
<div style="max-width:900px;margin:0 auto;padding:28px 16px 50px;">
    <h1 style="margin:0 0 14px;">Product Details</h1>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:16px;">
        <div><strong>Name:</strong> {{ $product->name }}</div>
        <div><strong>Category:</strong> {{ $product->category->name ?? '-' }}</div>
        <div><strong>Price:</strong> &pound;{{ number_format($product->price, 2) }}</div>
        <div><strong>Stock:</strong> {{ $product->stock_quantity }} ({{ $product->stock_status }})</div>
        <div><strong>Low Stock Threshold:</strong> {{ $product->low_stock_threshold ?? 5 }}</div>
        <div style="margin-top:10px;"><strong>Description:</strong><br>{{ $product->description }}</div>
    </div>
</div>
@endsection



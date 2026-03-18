@extends('layouts.admin')

@section('title', 'Manage Stock')
@section('page-title', 'Manage Stock')

@section('content')
<div style="max-width:760px;margin:0 auto;padding:28px 16px 50px;">
    <h1 style="margin:0 0 14px;">Manage Stock: {{ $product->name }}</h1>

    @if(session('status'))<div style="margin-bottom:10px;color:#065f46;">{{ session('status') }}</div>@endif

    <form method="POST" action="{{ route('admin.products.stock.update', $product) }}" style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:16px;display:grid;gap:10px;">
        @csrf @method('PATCH')
        <div><strong>Current Stock:</strong> {{ $product->stock_quantity }} | <strong>Status:</strong> {{ $product->stock_status }}</div>
        <select name="action" style="padding:9px 10px;border:1px solid #ddd;border-radius:8px;">
            <option value="set">Set exact stock</option>
            <option value="increase">Increase stock</option>
            <option value="decrease">Decrease stock</option>
        </select>
        <input name="quantity" type="number" min="1" value="1" style="padding:9px 10px;border:1px solid #ddd;border-radius:8px;">
        <input name="reference" placeholder="Reference (optional)" style="padding:9px 10px;border:1px solid #ddd;border-radius:8px;">
        <button type="submit" style="border:none;background:#d47c17;color:#fff;padding:10px 12px;border-radius:8px;">Apply Stock Update</button>
    </form>
</div>
@endsection


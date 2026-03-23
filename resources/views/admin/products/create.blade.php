@extends('layouts.admin')

@section('title', 'Add Product')
@section('page-title', 'Products')

@section('content')
<div style="max-width:760px;margin:0 auto;padding:28px 16px 50px;">
    <h1 style="margin:0 0 14px;">Add Product</h1>

    <form method="POST" action="{{ route('admin.products.store') }}" style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:16px;display:grid;gap:10px;">
        @csrf
        <input name="name" placeholder="Name" value="{{ old('name') }}" style="padding:9px 10px;border:1px solid #ddd;border-radius:8px;">
        <select name="category_id" style="padding:9px 10px;border:1px solid #ddd;border-radius:8px;">
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
        <textarea name="description" placeholder="Description" style="padding:9px 10px;border:1px solid #ddd;border-radius:8px;min-height:90px;">{{ old('description') }}</textarea>
        <input name="price" type="number" step="0.01" min="0" placeholder="Price (&pound;)" value="{{ old('price') }}" style="padding:9px 10px;border:1px solid #ddd;border-radius:8px;">
        <input name="stock_quantity" type="number" min="0" placeholder="Stock quantity" value="{{ old('stock_quantity', 0) }}" style="padding:9px 10px;border:1px solid #ddd;border-radius:8px;">
        <input name="low_stock_threshold" type="number" min="1" placeholder="Low stock threshold" value="{{ old('low_stock_threshold', 5) }}" style="padding:9px 10px;border:1px solid #ddd;border-radius:8px;">
        <input name="image_url" placeholder="Image URL (optional)" value="{{ old('image_url') }}" style="padding:9px 10px;border:1px solid #ddd;border-radius:8px;">
        <button type="submit" style="border:none;background:#d47c17;color:#fff;padding:10px 12px;border-radius:8px;">Create Product</button>
    </form>
</div>
@endsection
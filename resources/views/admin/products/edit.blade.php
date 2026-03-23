@extends('layouts.admin')

@section('title', 'Edit Product')
@section('page-title', 'Products')

@section('extra-css')
<style>
.overlay-wrap{max-width:980px;margin:0 auto}
.modal-card{background:#fff;border:1px solid #ddd;border-radius:18px;padding:24px 28px}
.modal-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px}
.modal-head h2{margin:0;font-family:'Oswald',sans-serif;font-size:30px;text-transform:uppercase}
.close-link{color:#6b7280;text-decoration:none;font-size:24px;line-height:1}
.close-link:hover{color:#111}
.field{margin-bottom:12px}
.field label{display:block;font-weight:600;color:#2d2d2d;margin-bottom:6px}
.input,.select,.textarea{width:100%;padding:10px 12px;border:1px solid #d8d8d8;border-radius:10px;font-size:15px;background:#fff}
.textarea{min-height:96px;resize:vertical}
.input:focus,.select:focus,.textarea:focus{outline:none;border-color:#d88411;box-shadow:0 0 0 3px #f7e8d1}
.grid-2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.submit-btn{width:100%;border:none;background:#d88411;color:#fff;font-weight:700;padding:12px;border-radius:10px;font-size:16px;cursor:pointer}
.submit-btn:hover{background:#be730f}

@media (max-width:760px){.grid-2{grid-template-columns:1fr}.modal-card{padding:18px}}
</style>
@endsection

@section('content')
<div class="overlay-wrap">
    <form method="POST" action="{{ route('admin.products.update', $product) }}" class="modal-card">
        @csrf
        @method('PATCH')

        <div class="modal-head">
            <h2>Edit Product</h2>
            <a href="{{ route('admin.products.index') }}" class="close-link">&times;</a>
        </div>

        <div class="field">
            <label for="name">Product Name</label>
            <input id="name" class="input" name="name" value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="field">
            <label for="description">Description</label>
            <textarea id="description" class="textarea" name="description" required>{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="grid-2">
            <div class="field">
                <label for="price">Price (&pound;)</label>
                <input id="price" class="input" name="price" type="number" step="0.01" min="0" value="{{ old('price', $product->price) }}" required>
            </div>
            <div class="field">
                <label for="category_id">Category</label>
                <select id="category_id" class="select" name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="field">
            <label for="image_url">Image URL</label>
            <input id="image_url" class="input" name="image_url" value="{{ old('image_url', $product->image_url) }}">
        </div>

        <div class="grid-2">
            <div class="field">
                <label for="stock_quantity">Stock Quantity</label>
                <input id="stock_quantity" class="input" name="stock_quantity" type="number" min="0" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
            </div>
            <div class="field">
                <label for="low_stock_threshold">Low Stock Threshold</label>
                <input id="low_stock_threshold" class="input" name="low_stock_threshold" type="number" min="1" value="{{ old('low_stock_threshold', $product->low_stock_threshold ?? 5) }}" required>
            </div>
        </div>

        <button type="submit" class="submit-btn">Update Product</button>
    </form>
</div>
@endsection
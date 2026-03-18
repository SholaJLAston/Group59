@extends('layouts.admin')

@section('title', 'Add Product')
@section('page-title', 'Add Product')

@section('extra-css')
<style>
.edit-wrap{max-width:920px;margin:0 auto}
.edit-card{background:#fff;border:1px solid #e8e8e8;border-radius:22px;padding:22px}
.edit-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px}
.edit-title{margin:0;font-size:24px;font-weight:800;color:#111827}
.close-btn{display:inline-flex;align-items:center;justify-content:center;width:34px;height:34px;border-radius:999px;border:1px solid #ececec;color:#6b7280;text-decoration:none}
.close-btn:hover{background:#fff4e8;color:#d88411;border-color:#ffe1ba}
.grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.field{display:flex;flex-direction:column;gap:7px}
.field.full{grid-column:1 / -1}
.field label{font-size:13px;font-weight:700;color:#374151}
.input,.select,.textarea{width:100%;padding:12px 13px;border:1px solid #dbdbdb;border-radius:12px;background:#fff;font-size:14px;color:#111827}
.textarea{min-height:100px;resize:vertical}
.input:focus,.select:focus,.textarea:focus{outline:none;border-color:#d88411;box-shadow:0 0 0 3px #f8e8cf}
.image-preview{width:84px;height:84px;border-radius:12px;object-fit:cover;border:1px solid #ececec;background:#f6f6f6}
.actions{display:flex;justify-content:flex-end;gap:10px;margin-top:16px}
.btn{padding:11px 16px;border-radius:12px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;border:1px solid transparent}
.btn-cancel{background:#fff;border-color:#e5e7eb;color:#374151}
.btn-cancel:hover{background:#f9fafb}
.btn-save{background:#d88411;color:#fff}
.btn-save:hover{background:#be730f}

@media (max-width: 900px){
    .grid{grid-template-columns:1fr}
}
</style>
@endsection

@section('content')
<div class="edit-wrap">
    <div class="edit-card">
        <div class="edit-head">
            <h1 class="edit-title">Add Product</h1>
            <a href="{{ route('admin.products.index') }}" class="close-btn" title="Close"><i class="fa-solid fa-xmark"></i></a>
        </div>

        <form method="POST" action="{{ route('admin.products.store') }}">
            @csrf

            <div class="grid">
                <div class="field full">
                    <label for="name">Product Name</label>
                    <input id="name" class="input" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="field">
                    <label for="category_id">Category</label>
                    <select id="category_id" name="category_id" class="select" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label for="price">Price (&pound;)</label>
                    <input id="price" class="input" name="price" type="number" step="0.01" min="0" value="{{ old('price') }}" required>
                </div>

                <div class="field full">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="textarea">{{ old('description') }}</textarea>
                </div>

                <div class="field">
                    <label for="stock_quantity">Stock Quantity</label>
                    <input id="stock_quantity" class="input" name="stock_quantity" type="number" min="0" value="{{ old('stock_quantity', 0) }}" required>
                </div>

                <div class="field">
                    <label for="low_stock_threshold">Low Stock Threshold</label>
                    <input id="low_stock_threshold" class="input" name="low_stock_threshold" type="number" min="1" value="{{ old('low_stock_threshold', 5) }}" required>
                </div>

                <div class="field full">
                    <label for="image_url">Image URL</label>
                    <input id="image_url" class="input" name="image_url" value="{{ old('image_url') }}" placeholder="https://...">
                </div>

                @php
                    $createRawImage = trim((string) old('image_url'));
                    $createPreview = $createRawImage === ''
                        ? asset('images/logo.png')
                        : (\Illuminate\Support\Str::startsWith($createRawImage, ['http://', 'https://', '/'])
                            ? $createRawImage
                            : asset(ltrim($createRawImage, '/')));
                @endphp
                <div class="field full">
                    <label>Preview</label>
                    <img class="image-preview" src="{{ $createPreview }}" alt="Product image" onerror="this.onerror=null;this.src='{{ asset('images/logo.png') }}';">
                </div>
            </div>

            <div class="actions">
                <a href="{{ route('admin.products.index') }}" class="btn btn-cancel">Cancel</a>
                <button type="submit" class="btn btn-save">Save Product</button>
            </div>
        </form>
    </div>
</div>
@endsection


@extends('layouts.admin')

@section('title', 'Products')
@section('page-title', 'Products')

@section('extra-css')
<style>
.products-wrap{max-width:1520px;margin:0 auto}
.top-actions{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;gap:10px;flex-wrap:wrap}
.add-btn{display:inline-flex;align-items:center;gap:10px;padding:11px 16px;border-radius:12px;background:#d88411;color:#fff;text-decoration:none;font-weight:700}
.add-btn:hover{background:#be730f}
.filters{display:grid;grid-template-columns:1fr 240px;gap:12px;margin-bottom:12px}
.search-wrap{position:relative}
.search-wrap i{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#777}
.search-input,.cat-select{width:100%;padding:12px 14px;border:1px solid #dbdbdb;border-radius:12px;background:#fff;font-size:15px}
.search-input{padding-left:40px}
.search-input:focus,.cat-select:focus{outline:none;border-color:#d88411;box-shadow:0 0 0 3px #f8e8cf}
.table-card{background:#fff;border:1px solid #e5e5e5;border-radius:18px;overflow:auto}
.table{width:100%;border-collapse:collapse;min-width:1100px}
.table th,.table td{padding:14px 18px;text-align:left;border-top:1px solid #efefef}
.table th{border-top:none;font-size:12px;letter-spacing:.04em;color:#6b7280;text-transform:uppercase}
.product-cell{display:flex;align-items:center;gap:14px}
.product-img{width:58px;height:58px;border-radius:10px;object-fit:cover;border:1px solid #ececec;background:#f6f6f6}
.product-name{font-size:17px;font-weight:700;color:#1f2937}
.product-desc{font-size:13px;color:#6b7280;max-width:380px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.price{font-size:16px;font-weight:700}
.stock-chip{display:inline-flex;align-items:center;justify-content:center;min-width:84px;padding:6px 10px;border-radius:999px;font-size:12px;font-weight:700}
.stock-in{background:#dcf5e5;color:#187748}
.stock-low{background:#fff4d6;color:#9a6900}
.stock-out{background:#fee2e2;color:#991b1b}
.actions{display:flex;gap:8px}
.icon-link,.icon-btn{display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:999px;background:transparent;border:none;color:#313131;text-decoration:none;cursor:pointer}
.icon-link:hover,.icon-btn:hover{background:#fff3e3;color:#d88411}
.icon-btn.delete:hover{background:#fee2e2;color:#dc2626}

@media (max-width: 980px){
    .filters{grid-template-columns:1fr}
}
</style>
@endsection

@section('content')
<div class="products-wrap">
    <div class="top-actions">
        <div></div>
        <a href="{{ route('admin.products.create') }}" class="add-btn"><i class="fa-solid fa-plus"></i> Add Product</a>
    </div>

    @if(session('status'))<div style="margin-bottom:10px;color:#065f46;">{{ session('status') }}</div>@endif

    <form method="GET" action="{{ route('admin.products.index') }}" class="filters">
        <div class="search-wrap">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input class="search-input" name="q" value="{{ request('q') }}" placeholder="Search products...">
        </div>

        <select name="category_id" class="cat-select" onchange="this.form.submit()">
            <option value="">All categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ (string)request('category_id') === (string)$category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
    </form>

    <div class="table-card">
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($products as $product)
                @php
                    $rawImage = trim((string) $product->image_url);
                    $productImage = $rawImage === ''
                        ? asset('images/logo.png')
                        : (\Illuminate\Support\Str::startsWith($rawImage, ['http://', 'https://', '/'])
                            ? $rawImage
                            : asset(ltrim($rawImage, '/')));
                @endphp
                <tr>
                    <td>
                        <div class="product-cell">
                            <img class="product-img" src="{{ $productImage }}" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='{{ asset('images/logo.png') }}';">
                            <div>
                                <div class="product-name">{{ $product->name }}</div>
                                <div class="product-desc">{{ $product->description }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td class="price">&pound;{{ number_format((float) $product->price, 2) }}</td>
                    <td>{{ $product->stock_quantity }}</td>
                    <td>
                        @if($product->stock_status === 'Out of Stock')
                            <span class="stock-chip stock-out">Out of Stock</span>
                        @elseif($product->stock_status === 'Low Stock')
                            <span class="stock-chip stock-low">Low Stock</span>
                        @else
                            <span class="stock-chip stock-in">In Stock</span>
                        @endif
                    </td>
                    <td>
                        <div class="actions">
                            <a class="icon-link" href="{{ route('admin.products.edit', $product) }}" title="Edit"><i class="fa-regular fa-pen-to-square"></i></a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete product?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="icon-btn delete" type="submit" title="Delete"><i class="fa-regular fa-trash-can"></i></button>
                            </form>
                            <a class="icon-link" href="{{ route('admin.products.stock', $product) }}" title="Stock"><i class="fa-solid fa-boxes-stacked"></i></a>
                            <a class="icon-link" href="{{ route('admin.products.show', $product) }}" title="View"><i class="fa-regular fa-eye"></i></a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" style="padding:10px;">No products found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:12px;">{{ $products->links('pagination::bootstrap-5') }}</div>
</div>
@endsection

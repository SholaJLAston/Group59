@extends('layouts.admin')

@section('title', 'Products')
@section('page-title', 'Products')

@section('extra-css')
<style>
.products-wrap{max-width:1520px;margin:0 auto}
.top-row{display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:14px}
.add-btn{background:#d88411;color:#fff;text-decoration:none;border-radius:12px;padding:11px 16px;font-weight:600;display:inline-flex;align-items:center;gap:8px}
.add-btn:hover{background:#be730f}
.filters{display:grid;grid-template-columns:1fr 240px;gap:10px;margin-bottom:12px}
.search-box,.cat-select{background:#fff;border:1px solid #dcdcdc;border-radius:12px;padding:12px 14px;font-size:15px}
.cat-select:hover,.cat-select:focus,.search-box:focus{border-color:#d88411;box-shadow:0 0 0 3px #f8e8cf;outline:none}
.table-card{background:#fff;border:1px solid #e3e3e3;border-radius:18px;overflow:auto}
.table{width:100%;border-collapse:collapse;min-width:980px}
.table th,.table td{padding:14px 16px;border-top:1px solid #f0f0f0;text-align:left}
.table th{border-top:none;font-size:12px;text-transform:uppercase;color:#666;letter-spacing:.04em}
.prod-cell{display:flex;align-items:center;gap:12px}
.prod-cell img{width:58px;height:58px;object-fit:cover;border-radius:10px;border:1px solid #ececec}
.prod-name{font-size:16px;font-weight:700;color:#1a1a1a}
.prod-desc{font-size:13px;color:#6b7280;max-width:420px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.price{font-weight:700;font-size:20px}
.stock-box{display:flex;align-items:center;gap:10px}
.stock-btn{display:inline-flex;width:30px;height:30px;align-items:center;justify-content:center;border:1px solid #dfdfdf;border-radius:8px;text-decoration:none;color:#202020}
.stock-btn:hover{border-color:#d88411;color:#d88411;background:#fff8ef}
.status-pill{display:inline-flex;padding:6px 10px;border-radius:999px;font-size:12px;font-weight:700}
.status-in{background:#dcf5e5;color:#187748}
.status-low{background:#fff4d6;color:#9a6900}
.status-out{background:#fee2e2;color:#991b1b}
.actions{display:flex;gap:10px}
.icon-link,.icon-btn{display:inline-flex;align-items:center;justify-content:center;width:34px;height:34px;border-radius:999px;border:none;background:transparent;color:#2b2b2b;text-decoration:none;cursor:pointer}
.icon-link:hover,.icon-btn:hover{background:#fff1dd;color:#d88411}
.icon-btn.delete:hover{color:#dc2626;background:#fee2e2}

@media (max-width:960px){.filters{grid-template-columns:1fr}}
</style>
@endsection

@section('content')
<div class="products-wrap">
    <div class="top-row">
        <div></div>
        <a class="add-btn" href="{{ route('admin.products.create') }}"><i class="fa-solid fa-plus"></i> Add Product</a>
    </div>

    @if(session('status'))<div style="margin-bottom:10px;color:#065f46;">{{ session('status') }}</div>@endif

    <form method="GET" action="{{ route('admin.products.index') }}" class="filters">
        <div style="position:relative;">
            <i class="fa-solid fa-magnifying-glass" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#777;"></i>
            <input class="search-box" name="q" value="{{ request('q') }}" placeholder="Search products..." style="width:100%;padding-left:38px;">
        </div>
        <select class="cat-select" name="category_id" onchange="this.form.submit()">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ (string)request('category_id') === (string)$category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
    </form>

    <div class="table-card">
        <table class="table">
            <thead>
                <tr><th>Product</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @forelse($products as $product)
                <tr>
                    <td>
                        <div class="prod-cell">
                            <img src="{{ $product->image_url ?: asset('images/logo.png') }}" alt="{{ $product->name }}">
                            <div>
                                <div class="prod-name">{{ $product->name }}</div>
                                <div class="prod-desc">{{ $product->description }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td class="price">&pound;{{ number_format((float) $product->price,2) }}</td>
                    <td>
                        <div class="stock-box">
                            <a class="stock-btn" href="{{ route('admin.products.stock', $product) }}" title="Manage stock"><i class="fa-solid fa-minus"></i></a>
                            <span>{{ $product->stock_quantity }}</span>
                            <a class="stock-btn" href="{{ route('admin.products.stock', $product) }}" title="Manage stock"><i class="fa-solid fa-plus"></i></a>
                        </div>
                    </td>
                    <td>
                        @if($product->stock_status === 'Out of Stock')
                            <span class="status-pill status-out">Out of Stock</span>
                        @elseif($product->stock_status === 'Low Stock')
                            <span class="status-pill status-low">Low Stock</span>
                        @else
                            <span class="status-pill status-in">In Stock</span>
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
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" style="padding:14px 16px;">No products found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:12px;">{{ $products->links() }}</div>
</div>
@endsection
@extends('layouts.admin')

@section('title', 'Products')
@section('page-title', 'Products')

@section('extra-css')
<style>
.products-wrap{max-width:1520px;margin:0 auto}
.top-actions{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;gap:10px;flex-wrap:wrap}
.top-actions-right{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
.add-btn{display:inline-flex;align-items:center;gap:10px;padding:11px 16px;border-radius:12px;background:#d88411;color:#fff;text-decoration:none;font-weight:700}
.add-btn:hover{background:#be730f}
.cat-btn{display:inline-flex;align-items:center;gap:10px;padding:11px 16px;border-radius:12px;background:#111827;color:#fff;text-decoration:none;font-weight:700;border:none;cursor:pointer}
.cat-btn:hover{background:#1f2937}
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

.category-modal{position:fixed;inset:0;background:rgba(17,24,39,.45);display:none;align-items:center;justify-content:center;z-index:1200}
.category-modal.show{display:flex}
.category-modal-card{width:min(520px,92vw);background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:18px}
.category-modal-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:10px}
.category-modal-title{margin:0;font-size:20px;font-weight:800;color:#111827}
.category-close{width:34px;height:34px;border-radius:999px;border:1px solid #ececec;background:#fff;color:#6b7280;cursor:pointer}
.category-close:hover{background:#fff4e8;color:#d88411}
.category-help{font-size:13px;color:#6b7280;margin:0 0 10px}
.category-input{width:100%;padding:12px 13px;border:1px solid #dbdbdb;border-radius:12px;background:#fff;font-size:14px;color:#111827}
.category-input:focus{outline:none;border-color:#d88411;box-shadow:0 0 0 3px #f8e8cf}
.category-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:14px}
.btn-lite{padding:10px 14px;border-radius:12px;border:1px solid #e5e7eb;background:#fff;color:#374151;font-weight:700;cursor:pointer}
.btn-lite:hover{background:#f9fafb}
.btn-cat-save{padding:10px 14px;border-radius:12px;border:none;background:#d88411;color:#fff;font-weight:700;cursor:pointer}
.btn-cat-save:hover{background:#be730f}
.category-list{margin-top:16px;border-top:1px solid #eee;padding-top:12px}
.category-list-title{margin:0 0 8px;font-size:14px;font-weight:700;color:#374151}
.category-items{list-style:none;margin:0;padding:0;display:grid;gap:8px}
.category-item{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:10px 12px;border:1px solid #ececec;border-radius:12px}
.category-meta{display:flex;align-items:center;gap:8px;min-width:0}
.category-name{font-size:14px;font-weight:700;color:#111827;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.category-count{font-size:12px;color:#6b7280}
.btn-cat-delete{padding:7px 10px;border:1px solid #fecaca;border-radius:10px;background:#fff1f2;color:#b91c1c;font-size:12px;font-weight:700;cursor:pointer}
.btn-cat-delete:hover{background:#ffe4e6}
.toast{position:fixed;top:18px;right:18px;z-index:1500;max-width:min(380px,calc(100vw - 24px));padding:12px 14px;border-radius:12px;border:1px solid transparent;color:#fff;box-shadow:0 10px 24px rgba(0,0,0,.18);font-weight:700;opacity:1;transform:translateY(0);transition:opacity .25s ease,transform .25s ease}
.toast-success{background:#047857;border-color:#065f46}
.toast-error{background:#b91c1c;border-color:#991b1b}
.toast.hide{opacity:0;transform:translateY(-10px)}

@media (max-width: 980px){
    .filters{grid-template-columns:1fr}
}
</style>
@endsection

@section('content')
<div class="products-wrap">
    <div class="top-actions">
        <div></div>
        <div class="top-actions-right">
            <button type="button" class="cat-btn" id="openCategoryModal"><i class="fa-solid fa-folder-plus"></i> Add Category</button>
            <a href="{{ route('admin.products.create') }}" class="add-btn"><i class="fa-solid fa-plus"></i> Add Product</a>
        </div>
    </div>

    @if(session('status') || session('error'))
        <div id="flashToast" class="toast {{ session('error') ? 'toast-error' : 'toast-success' }}">
            {{ session('error') ?: session('status') }}
        </div>
    @endif

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

<div class="category-modal" id="categoryModal" aria-hidden="true">
    <div class="category-modal-card">
        <div class="category-modal-head">
            <h2 class="category-modal-title">Add Category</h2>
            <button type="button" class="category-close" id="closeCategoryModal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <p class="category-help">Create a category once, then it will appear in the Add Product category dropdown.</p>

        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <input class="category-input" name="name" value="{{ old('name') }}" placeholder="Category name" required>
            @error('name')
                <small style="color:#b91c1c;display:block;margin-top:6px;">{{ $message }}</small>
            @enderror

            <div class="category-actions">
                <button type="button" class="btn-lite" id="cancelCategoryModal">Cancel</button>
                <button type="submit" class="btn-cat-save">Save Category</button>
            </div>
        </form>

        <div class="category-list">
            <p class="category-list-title">Existing Categories</p>
            <ul class="category-items">
                @foreach($categories as $category)
                    <li class="category-item">
                        <div class="category-meta">
                            <span class="category-name">{{ $category->name }}</span>
                            <span class="category-count">({{ $category->products_count }} products)</span>
                        </div>

                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Remove category {{ addslashes($category->name) }}? Products in it will be moved to another category.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-cat-delete" title="Remove category and keep products safe">Remove</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<script>
(() => {
    const modal = document.getElementById('categoryModal');
    const openBtn = document.getElementById('openCategoryModal');
    const closeBtn = document.getElementById('closeCategoryModal');
    const cancelBtn = document.getElementById('cancelCategoryModal');
    if (!modal || !openBtn || !closeBtn || !cancelBtn) {
        return;
    }

    const openModal = () => {
        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');
    };

    const closeModal = () => {
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
    };

    openBtn.addEventListener('click', openModal);
    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });

    @if($errors->has('name'))
        openModal();
    @endif

    const flashToast = document.getElementById('flashToast');
    if (flashToast) {
        window.setTimeout(() => {
            flashToast.classList.add('hide');
        }, 2000);

        window.setTimeout(() => {
            flashToast.remove();
        }, 2350);
    }
})();
</script>
@endsection

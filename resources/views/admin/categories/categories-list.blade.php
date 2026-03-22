@extends('layouts.admin')

@section('title', 'Categories')
@section('page-title', 'Categories')

@section('extra-css')
<style>
.categories-wrap{max-width:1320px;margin:0 auto}
.top-actions{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;gap:10px;flex-wrap:wrap}
.add-btn{display:inline-flex;align-items:center;gap:10px;padding:11px 16px;border-radius:12px;background:#d88411;color:#fff;text-decoration:none;font-weight:700}
.add-btn:hover{background:#be730f}
.search-form{margin-bottom:12px}
.search-wrap{position:relative;max-width:380px}
.search-wrap i{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#777}
.search-input{width:100%;padding:12px 14px 12px 40px;border:1px solid #dbdbdb;border-radius:12px;background:#fff;font-size:15px}
.search-input:focus{outline:none;border-color:#d88411;box-shadow:0 0 0 3px #f8e8cf}
.table-card{background:#fff;border:1px solid #e5e5e5;border-radius:18px;overflow:auto}
.table{width:100%;border-collapse:collapse;min-width:920px}
.table th,.table td{padding:14px 18px;text-align:left;border-top:1px solid #efefef}
.table th{border-top:none;font-size:12px;letter-spacing:.04em;color:#6b7280;text-transform:uppercase}
.category-row.active{background:#fff7eb}
.category-cell{display:flex;align-items:center;gap:12px}
.category-img{width:52px;height:52px;border-radius:10px;object-fit:cover;border:1px solid #ececec;background:#f6f6f6}
.category-name{font-size:16px;font-weight:700;color:#1f2937}
.category-slug{font-size:12px;color:#6b7280}
.category-desc{max-width:320px;color:#4b5563;font-size:13px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.badge{display:inline-flex;align-items:center;justify-content:center;padding:6px 10px;border-radius:999px;font-size:12px;font-weight:700;background:#f3f4f6;color:#374151}
.actions{display:flex;gap:8px}
.icon-link,.icon-btn{display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:999px;background:transparent;border:none;color:#313131;text-decoration:none;cursor:pointer}
.icon-link:hover,.icon-btn:hover{background:#fff3e3;color:#d88411}
.icon-btn.delete:hover{background:#fee2e2;color:#dc2626}
.toast{position:fixed;top:18px;right:18px;z-index:1500;max-width:min(380px,calc(100vw - 24px));padding:12px 14px;border-radius:12px;border:1px solid transparent;color:#fff;box-shadow:0 10px 24px rgba(0,0,0,.18);font-weight:700;opacity:1;transform:translateY(0);transition:opacity .25s ease,transform .25s ease}
.toast-success{background:#047857;border-color:#065f46}
.toast.hide{opacity:0;transform:translateY(-10px)}

@media (max-width: 1080px){
    .category-desc{display:none}
}
</style>
@endsection

@section('content')
<div class="categories-wrap">
    <div class="top-actions">
        <div></div>
        <a href="{{ route('admin.categories.create') }}" class="add-btn"><i class="fa-solid fa-plus"></i> Add Category</a>
    </div>

    @if(session('status'))
        <div id="flashToast" class="toast toast-success">{{ session('status') }}</div>
    @endif

    <form method="GET" action="{{ route('admin.categories.index') }}" class="search-form">
        <div class="search-wrap">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input class="search-input" name="q" value="{{ request('q') }}" placeholder="Search categories...">
        </div>
    </form>

    <div class="table-card">
        <table class="table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Products</th>
                    <th>Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($categories as $category)
                @php
                    $rawImage = trim((string) $category->image);
                    $categoryImage = $rawImage === ''
                        ? asset('images/logo.png')
                        : (\Illuminate\Support\Str::startsWith($rawImage, ['http://', 'https://', '/'])
                            ? $rawImage
                            : asset(ltrim($rawImage, '/')));
                @endphp
                <tr class="category-row" 
                onclick="document.querySelectorAll('.category-row').forEach(r=>r.classList.remove('active')); this.classList.add('active');" style="cursor:pointer;">
                    <td>
                        <div class="category-cell">
                            <img class="category-img" src="{{ $categoryImage }}" alt="{{ $category->name }}" onerror="this.onerror=null;this.src='{{ asset('images/logo.png') }}';">
                            <div>
                                <div class="category-name">{{ $category->name }}</div>
                                <div class="category-slug">{{ $category->slug }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="category-desc">{{ $category->description ?: '-' }}</div>
                    </td>
                    <td><span class="badge">{{ $category->products_count }} products</span></td>
                    <td>{{ $category->updated_at?->format('n/j/Y') ?: '-' }}</td>
                    <td>
                        <div class="actions">
                            <a class="icon-link" href="{{ route('admin.categories.edit', $category) }}" title="Edit"><i class="fa-regular fa-pen-to-square"></i></a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Remove category {{ addslashes($category->name) }}? Products in it will be moved to another category.');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="icon-btn delete" type="submit" title="Delete"><i class="fa-regular fa-trash-can"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="padding:14px 18px;">No categories found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:12px;">{{ $categories->links('pagination::bootstrap-5') }}</div>
</div>

<script>
(() => {
    const flashToast = document.getElementById('flashToast');
    if (!flashToast) {
        return;
    }

    window.setTimeout(() => {
        flashToast.classList.add('hide');
    }, 2000);

    window.setTimeout(() => {
        flashToast.remove();
    }, 2350);
})();
</script>
@endsection

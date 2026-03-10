@extends('layouts.app')

@section('title', 'products')

@section('extra-css')
<style>
    :root {
      --hero-bg: url('{{ asset('images/hardware.avif') }}');
    }
  </style>
  
  <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
@endsection
@section('content')
  <!-- Shop Hero (unchanged) -->
  <section class="shop-hero">
    <div class="shop-hero-content">
      <h1>Our Products</h1>
      <p>Discover high-quality tools, materials, and equipment for every project — from professionals to DIY enthusiasts.</p>
    </div>
  </section>

  <!-- Products Section with sidebar filters -->
  <section class="products-section">
    <div class="container shop-layout">
      <!-- Sidebar filters (unchanged) -->
      <aside class="shop-sidebar">
        <div class="sidebar-block">
          <h4>Search</h4>
          <div class="search-input-wrapper">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" value="{{ $search ?? '' }}" placeholder="Search products...">
          </div>
        </div>

        <div class="sidebar-block">
          <h4>Category</h4>
          <select class="category" id="categoryFilter">
            <option value="all"{{ ($selectedCategory ?? 'all') === 'all' ? ' selected' : '' }}>All Categories</option>
            @foreach($categories as $cat)
              @php $slug = \Illuminate\Support\Str::slug($cat->name); @endphp
              <option value="{{ $slug }}"{{ ($selectedCategory ?? '') === $slug ? ' selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="sidebar-block">
          <h4>Price Range</h4>
          <div class="price-range">
            <input type="number" id="priceMin" value="{{ $minPrice ?? '' }}" placeholder="0" min="0">
            <span class="dash">—</span>
            <input type="number" id="priceMax" value="{{ $maxPrice ?? '' }}" placeholder="0" min="0">
          </div>
        </div>

        <div class="sidebar-block in-stock-block">
          <label><input type="checkbox" id="inStockOnly" {{ !empty($inStockOnly) ? 'checked' : '' }}> In Stock Only</label>
        </div>

        <button type="button" id="clearFiltersBtn" class="clear-all">Clear all</button>
      </aside>

      <!-- Products Grid -->
      <div class="products-grid" id="productsGrid">
        @forelse($products as $product)
          @php
            $slug = \Illuminate\Support\Str::slug($product->category->name ?? 'uncategorized');
            $statusLower = strtolower($product->stock_status ?? 'in stock');
            $isInStock = !str_contains($statusLower, 'out');
          @endphp

          <div class="product-card"
               data-category="{{ $slug }}"
               data-price="{{ $product->price }}"
               data-stock="{{ $isInStock ? 'in stock' : 'out of stock' }}"
               data-name="{{ addslashes(strtolower($product->name)) }}">

            <div class="product-image-wrapper">
              <a href="{{ route('products.show', $product) }}">
                <img class="product-image" src="{{ asset($product->image_url ?: 'images/placeholder.png') }}" alt="{{ $product->name }}">
              </a>
            </div>

            <div class="stock-badge-wrapper">
              <div class="stock-badge {{ $isInStock ? 'in-stock' : 'out-of-stock' }}">
                {{ $isInStock ? 'In Stock' : 'Out of Stock' }}
              </div>
            </div>

            <div class="product-body">
              <h3 class="product-name">{{ $product->name }}</h3>

              <div class="product-footer">
                <div class="product-price">£{{ number_format($product->price, 2) }}</div>
                <button class="add-to-cart-btn" onclick="addToBasket('{{ addslashes($product->name) }}')">
                  <i class="fas fa-shopping-cart"></i>
                </button>
              </div>
            </div>
          </div>
        @empty
          <p style="grid-column: 1 / -1; text-align: center; padding: 3rem 0;">No products found.</p>
        @endforelse
      </div>
    </div>
  </section>
@endsection

@section('extra-js')
  <script>
    // Filters – fixed search to be case-insensitive and use data-name properly
    const searchInput    = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const priceMin       = document.getElementById('priceMin');
    const priceMax       = document.getElementById('priceMax');
    const inStockOnly    = document.getElementById('inStockOnly');
    const clearBtn       = document.getElementById('clearFiltersBtn');
    const cards          = document.querySelectorAll('.product-card');

    function filterProducts() {
      const term   = searchInput.value.toLowerCase().trim();
      const cat    = categoryFilter.value;
      const min    = parseFloat(priceMin.value) || 0;
      const max    = parseFloat(priceMax.value) || Infinity;
      const stock  = inStockOnly.checked;

      cards.forEach(card => {
        const name   = card.dataset.name || '';
        const c      = card.dataset.category || '';
        const p      = parseFloat(card.dataset.price) || 0;
        const s      = card.dataset.stock || '';

        const matchName  = name.includes(term);
        const matchCat   = cat === 'all' || c === cat;
        const matchPrice = p >= min && p <= max;
        const matchStock = !stock || s === 'in stock';

        card.style.display = (matchName && matchCat && matchPrice && matchStock) ? '' : 'none';
      });
    }

    // Real-time listeners
    searchInput.addEventListener('input', filterProducts);
    categoryFilter.addEventListener('change', filterProducts);
    priceMin.addEventListener('input', filterProducts);
    priceMax.addEventListener('input', filterProducts);
    inStockOnly.addEventListener('change', filterProducts);

    clearBtn.addEventListener('click', () => {
      searchInput.value = '';
      categoryFilter.value = 'all';
      priceMin.value = '';
      priceMax.value = '';
      inStockOnly.checked = false;
      filterProducts();
    });

    function addToBasket(name) {
      alert(`Added "${name}" to basket!`);
    }

    // Initial filter on page load
    filterProducts();
  </script>
@endsection
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
  <!-- Shop Hero with combined search + filter -->
  <section class="shop-hero">
    <div class="shop-hero-content">
      <h1>Our Products</h1>
      <p>Discover high-quality tools, materials, and equipment for every project — from professionals to DIY enthusiasts.</p>

      <div class="hero-controls">
        <div class="search-input-wrapper">
          <i class="fas fa-search"></i>
          <input type="text" id="searchInput" placeholder="Search products...">
        </div>

        <select class="category" id="categoryFilter">
          <option value="all">All Categories</option>
          <option value="general-tools">General Tools</option>
          <option value="electronic-hardware">Electronic Hardware</option>
          <option value="electronic-tools">Electronic Tools</option>
          <option value="gardening-tools">Gardening Tools</option>
          <option value="materials">Materials</option>
        </select>
      </div>
    </div>
  </section>

  <!-- Products Grid -->
  <section class="products-section">
    <div class="container">
      <div class="products-grid" id="productsGrid">
        <!-- Example products – add more as needed -->
        <div class="product-card" data-category="general-tools">
          <img src="{{ asset('images/products photo/General Tools/saws.avif') }}" alt="Saws">
          <div class="product-info">
            <div class="product-name-price">
              <div class="product-name">Saws</div>
              <div class="product-price">£89.99</div>
            </div>
            <div class="add-to-basket" onclick="addToBasket('Saws')">
              <i class="fas fa-shopping-cart"></i>
            </div>
          </div>
        </div>

        <!-- ... add all your other product cards the same way ... -->

      </div>

      <!-- Load More Arrow -->
      <div class="load-more" id="loadMoreSection">
        <button class="load-more-btn" id="loadMoreBtn">
          <i class="fas fa-arrow-down"></i>
        </button>
      </div>
    </div>
  </section>
@endsection

@section('extra-js')
  <script>
    // Search & Category Filter
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const productCards = document.querySelectorAll('.product-card');
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const loadMoreSection = document.getElementById('loadMoreSection');

    function filterProducts() {
      const searchTerm = searchInput.value.toLowerCase().trim();
      const selectedCategory = categoryFilter.value;

      let visibleCount = 0;

      productCards.forEach(card => {
        const name = card.querySelector('.product-name').textContent.toLowerCase();
        const category = card.dataset.category;

        const matchesSearch = name.includes(searchTerm);
        const matchesCategory = selectedCategory === 'all' || category === selectedCategory;

        if (matchesSearch && matchesCategory) {
          card.style.display = 'block';
          visibleCount++;
        } else {
          card.style.display = 'none';
        }
      });

      // Show load more button only if there are more products to show
      loadMoreSection.style.display = (visibleCount > 9) ? 'block' : 'none';
    }

    searchInput.addEventListener('input', filterProducts);
    categoryFilter.addEventListener('change', filterProducts);

    // Load More – show next 9 products (or all remaining)
    loadMoreBtn.addEventListener('click', () => {
      productCards.forEach(card => {
        if (card.style.display !== 'none') {
          card.style.display = 'block';
        }
      });
      loadMoreSection.style.display = 'none';
    });

    // Add to basket alert (placeholder)
    function addToBasket(name) {
      alert(`Added "${name}" to basket!`);
    }

    // Initial load
    filterProducts();
  </script>
@endsection
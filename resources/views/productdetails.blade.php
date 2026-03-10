@extends('layouts.app')

@section('title', $product->name)

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/shop.css') }}">
@endsection

@section('content')
  <section class="product-details product-details-page">
    <div class="product-container">
      <a href="{{ route('products') }}" class="back-link">
        &larr; Back to Products
      </a>

      @if(session('status'))
        <div class="success-message">
          {{ session('status') }}
        </div>
      @endif

      <div class="details-grid">
        <div class="product-image">
          <img src="{{ asset($product->image_url ?: 'images/placeholder.png') }}" alt="{{ $product->name }}">
        </div>

        <div class="product-info">
          <!-- Stock Badge at TOP -->
          <span class="stock-badge 
            {{ Str::contains(strtolower($product->stock_status ?? ''), 'out') ? 'out-of-stock' : 'in-stock' }}">
            {{ $product->stock_status ?? 'In Stock' }}
          </span>

          <!-- Product Name -->
          <h1>{{ $product->name }}</h1>

          <!-- Category -->
          <p class="category">Category: {{ $product->category->name ?? 'Uncategorized' }}</p>

          <!-- Rating Section with Stars -->
          <div class="rating">
            @php
              $count = $product->reviews->count();
              $avg = $count > 0 ? $product->reviews->avg('rating') : 0;
            @endphp
            <div class="stars-display">
              @for($i=1;$i<=5;$i++)
                <span class="star {{ $i <= round($avg) && $count > 0 ? 'active' : '' }}">★</span>
              @endfor
            </div>
            <span class="review-count">({{ $count }} review{{ $count === 1 ? '' : 's' }})</span>
          </div>

          <!-- Price -->
          <div class="price">£{{ number_format($product->price, 2) }}</div>

          <!-- Description -->
          <p class="description">{{ $product->description ?? '' }}</p>

          <!-- Quantity & Add to Cart in ONE ROW -->
          <div class="quantity-add-section">
            <div class="quantity-group">
              <button type="button" class="qty-btn" onclick="this.nextElementSibling.value = Math.max(1, parseInt(this.nextElementSibling.value) - 1)">−</button>
              <input type="number" value="1" min="1" class="quantity-input" id="qty">
              <button type="button" class="qty-btn" onclick="this.previousElementSibling.value = parseInt(this.previousElementSibling.value) + 1">+</button>
            </div>
            <button class="add-to-cart-btn" onclick="addToBasket('{{ addslashes($product->name) }}')">
              <i class="fas fa-shopping-cart"></i> ADD TO CART
            </button>
          </div>

          <!-- Trust Badges -->
          <div class="trust-badges">
            <div class="badge-box">
              <div class="badge-icon">🛫</div>
              <div class="badge-text">Free Shipping</div>
            </div>
            <div class="badge-box">
              <div class="badge-icon">🔒</div>
              <div class="badge-text">Secure Payment</div>
            </div>
            <div class="badge-box">
              <div class="badge-icon">↺</div>
              <div class="badge-text">Easy Returns</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Reviews Section -->
      <section class="reviews-section">
        <h2 class="reviews-title">Customer Reviews</h2>

        @auth
        <form method="POST" action="{{ route('reviews.store', $product) }}" class="review-form">
          @csrf
          <div class="form-group">
            <label class="form-label">Rating</label>
            <div class="stars">
              @for($i=1;$i<=5;$i++)
                <span data-value="{{ $i }}">★</span>
              @endfor
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Your Review</label>
            <textarea name="comment" class="review-textarea" placeholder="Share your experience with this product...">{{ old('comment') }}</textarea>
          </div>

          <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating',1) }}">
          <button class="submit-review-btn" type="submit">Submit Review</button>
        </form>
        @else
          <div class="login-review-box">
            <p>Please <a href="{{ route('login') }}" class="login-link">log in</a> to leave a review.</p>
          </div>
        @endauth

        @if($product->reviews->isEmpty())
          <div class="no-reviews">
            No reviews yet. Be the first to review this product!
          </div>
        @else
          @foreach($product->reviews as $review)
            <div class="review-item">
              <div class="review-header">
                @php
                  $reviewUser = $review->user;
                  $displayName = $reviewUser->name ?? $reviewUser->email ?? 'Guest';
                @endphp
                <div class="reviewer-avatar">{{ strtoupper(substr($displayName,0,1)) }}</div>
                <div class="reviewer-info">
                  <div class="reviewer-name">{{ $displayName }}</div>
                  <div class="reviewer-rating">
                    @for($i=1;$i<=5;$i++)
                      <span class="{{ $i <= $review->rating ? 'active' : '' }}">★</span>
                    @endfor
                  </div>
                </div>
                <div class="review-date">{{ $review->created_at->format('m/d/Y') }}</div>
              </div>
              <p class="review-text">{{ $review->comment }}</p>
            </div>
          @endforeach
        @endif
      </section>
    </div>
  </section>
@endsection

@section('extra-js')
<script>
  function addToBasket(name) {
    const qty = document.getElementById('qty')?.value || 1;
    alert(`Added "${name}" (Qty: ${qty}) to cart!`);
  }

  // rating stars interaction for review form
  document.querySelectorAll('.stars span').forEach(star => {
    star.addEventListener('click', function() {
      const value = this.dataset.value;
      document.querySelectorAll('.stars span').forEach(s => {
        s.classList.toggle('active', s.dataset.value <= value);
      });
      const input = document.getElementById('ratingInput');
      if (input) input.value = value;
    });
  });
  // auto-hide success message
  document.addEventListener('DOMContentLoaded', () => {
    const msg = document.querySelector('.success-message');
    if (msg) {
      setTimeout(() => {
        msg.style.transition = 'opacity 0.5s';
        msg.style.opacity = '0';
        setTimeout(() => msg.remove(), 500);
      }, 3000);
    }
  });</script>
@endsection

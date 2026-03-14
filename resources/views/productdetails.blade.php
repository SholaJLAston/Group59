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

      @if(session('error'))
        <div class="success-message" style="background:#fee2e2;color:#991b1b;">
          {{ session('error') }}
        </div>
      @endif

      <div class="details-grid">
        <div class="product-image">
          <img src="{{ asset($product->image_url ?: 'images/placeholder.png') }}" alt="{{ $product->name }}">
        </div>

        <div class="product-info">
          <!-- Stock Badge -->
          <span class="stock-badge
            {{ Str::contains(strtolower($product->stock_status ?? ''), 'out') ? 'out-of-stock' : 'in-stock' }}">
            {{ $product->stock_status ?? 'In Stock' }}
          </span>

          <!-- Product Name -->
          <h1>{{ $product->name }}</h1>

          <!-- Category -->
          <p class="category">Category: {{ $product->category->name ?? 'Uncategorized' }}</p>

          <!-- Rating -->
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

          <!-- Quantity & Add to Cart -->
          <div class="quantity-add-section">
            @auth
              <form method="POST" action="{{ route('basket.add', $product) }}" class="add-to-basket-form">
                @csrf
                <div class="quantity-group">
                  <button type="button" class="qty-btn" onclick="const qty = document.getElementById('qty'); qty.value = Math.max(1, parseInt(qty.value || 1) - 1);">−</button>
                  <input type="number" name="quantity" value="1" min="1" max="99" class="quantity-input" id="qty">
                  <button type="button" class="qty-btn" onclick="const qty = document.getElementById('qty'); qty.value = parseInt(qty.value || 1) + 1;">+</button>
                </div>
                <button class="add-to-cart-btn" type="submit" @disabled(($product->stock_quantity ?? 0) <= 0)>
                  <i class="fas fa-shopping-cart"></i> ADD TO BASKET
                </button>
              </form>
            @else
              <a class="add-to-cart-btn" href="{{ route('login') }}">
                <i class="fas fa-shopping-cart"></i> LOG IN TO ADD TO BASKET
              </a>
            @endauth
          </div>

          <!-- Trust Badges -->
          <div class="trust-badges">
            <div class="badge-box">
              <i class="fas fa-truck badge-icon"></i>
              <span class="badge-text">Free Shipping</span>
            </div>
            <div class="badge-box">
              <i class="fas fa-shield-alt badge-icon"></i>
              <span class="badge-text">Secure Payment</span>
            </div>
            <div class="badge-box">
              <i class="fas fa-undo badge-icon"></i>
              <span class="badge-text">Easy Returns</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Reviews Section -->
      <section class="reviews-section">
        <h2 class="reviews-title">Customer Reviews</h2>

        @auth
        <div class="review-form">
          
          <form method="POST" action="{{ route('reviews.store', $product) }}" id="reviewForm">
            @csrf

            <div class="form-group">
              <label class="form-label">Rating</label>
              <div class="stars" id="starContainer">
                @for($i=1;$i<=5;$i++)
                  <span data-value="{{ $i }}">★</span>
                @endfor
              </div>
              <small id="starError" style="color:#dc2626; font-size:0.85rem; margin-top:4px; display:none;">Please select a star rating.</small>
            </div>

            <div class="form-group">
              <label class="form-label">Your Review</label>
              <textarea name="comment" class="review-textarea" id="reviewComment" placeholder="Share your experience with this product...">{{ old('comment') }}</textarea>
            </div>

            <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating', 0) }}">
            <button class="submit-review-btn" type="submit">Submit Review</button>
          </form>
        </div>
        @else
          <p class="login-review-plain">
            Please <a href="{{ route('login') }}" class="login-link-plain">log in</a> to leave a review.
          </p>
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
  // Stars: hover preview + click to select
  let selectedRating = {{ old('rating', 0) }};

  document.querySelectorAll('.stars span').forEach(star => {

    star.addEventListener('mouseover', function () {
      const val = parseInt(this.dataset.value);
      document.querySelectorAll('.stars span').forEach(s => {
        s.style.color = parseInt(s.dataset.value) <= val ? '#f59e0b' : '#d1d5db';
      });
    });

    star.addEventListener('mouseout', function () {
      document.querySelectorAll('.stars span').forEach(s => {
        s.style.color = parseInt(s.dataset.value) <= selectedRating ? '#f59e0b' : '#d1d5db';
      });
    });

    star.addEventListener('click', function () {
      selectedRating = parseInt(this.dataset.value);
      document.getElementById('ratingInput').value = selectedRating;
      document.getElementById('starError').style.display = 'none';
      document.querySelectorAll('.stars span').forEach(s => {
        s.style.color = parseInt(s.dataset.value) <= selectedRating ? '#f59e0b' : '#d1d5db';
      });
    });
  });

  // Form validation – block submit if rating is missing
  const form = document.getElementById('reviewForm');
  if (form) {
    form.addEventListener('submit', function (e) {
      let valid = true;

      const rating  = parseInt(document.getElementById('ratingInput').value);

      if (rating < 1) {
        document.getElementById('starError').style.display = 'block';
        valid = false;
      } else {
        document.getElementById('starError').style.display = 'none';
      }

      if (!valid) e.preventDefault();
    });
  }

  // Auto-dismiss success toast after 3 seconds
  document.addEventListener('DOMContentLoaded', () => {
    const msg = document.querySelector('.success-message');
    if (msg) {
      setTimeout(() => {
        msg.style.transition = 'opacity 0.5s';
        msg.style.opacity = '0';
        setTimeout(() => msg.remove(), 500);
      }, 3000);
    }
  });
</script>
@endsection
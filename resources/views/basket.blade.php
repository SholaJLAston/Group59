@extends('layouts.app')

@section('title', 'Basket')

@section('extra-css')
<style>

  /* ── Page wrapper ───────────────────────── */
  .basket-page {
    min-height: 70vh;
    background: #f5f5f3;
    padding: 60px 20px;
  }

  .basket-inner {
    max-width: 1100px;
    margin: 0 auto;
  }

  /* ── Empty / Guest state (centred) ─────── */
  .basket-empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 55vh;
    text-align: center;
  }

  .basket-empty-state .basket-icon {
    width: 80px;
    height: 80px;
    color: #9ca3af;
    margin-bottom: 1.4rem;
  }

  .basket-empty-state h2 {
    font-size: 1.5rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #111;
    margin-bottom: 0.6rem;
  }

  .basket-empty-state p {
    color: #6b7280;
    font-size: 1rem;
    margin-bottom: 1.8rem;
  }

  .btn-primary {
    display: inline-block;
    background: #D47C17;
    color: #fff;
    font-weight: 700;
    font-size: 0.95rem;
    padding: 13px 32px;
    border-radius: 8px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: background 0.2s, transform 0.2s;
  }

  .btn-primary:hover {
    background: #b96d12;
    transform: translateY(-2px);
    color: #fff;
    text-decoration: none;
  }

  /* ── Filled cart layout ─────────────────── */
  .basket-layout {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 28px;
    align-items: start;
  }

  .basket-title {
    font-size: 1.6rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #111;
    margin-bottom: 1.4rem;
    grid-column: 1 / -1;
  }

  /* ── Alerts ─────────────────────────────── */
  .alert-success {
    margin-bottom: 1.2rem;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    background: #dcfce7;
    color: #166534;
    grid-column: 1 / -1;
  }

  .alert-error {
    margin-bottom: 1.2rem;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    background: #fee2e2;
    color: #991b1b;
    grid-column: 1 / -1;
  }

  /* ── Cart items ─────────────────────────── */
  .basket-items {
    display: flex;
    flex-direction: column;
    gap: 14px;
  }

  .basket-item {
    display: flex;
    align-items: center;
    gap: 16px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 16px;
  }

  .basket-item img {
    width: 90px;
    height: 90px;
    object-fit: cover;
    border-radius: 10px;
    flex-shrink: 0;
  }

  .basket-item-info {
    flex: 1;
  }

  .basket-item-info h3 {
    font-size: 1rem;
    font-weight: 700;
    color: #111;
    margin: 0 0 4px;
  }

  .basket-item-info .item-price {
    font-size: 0.9rem;
    color: #6b7280;
    margin: 0;
  }

  /* quantity controls */
  .qty-controls {
    display: flex;
    align-items: center;
    gap: 10px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 4px 10px;
    background: #f9fafb;
  }

  .qty-controls form { margin: 0; }

  .qty-btn-inline {
    background: none;
    border: none;
    font-size: 1.1rem;
    color: #374151;
    cursor: pointer;
    padding: 2px 6px;
    line-height: 1;
    transition: color 0.2s;
  }
  .qty-btn-inline:hover { color: #D47C17; }

  .qty-value {
    font-size: 1rem;
    font-weight: 600;
    color: #111;
    min-width: 24px;
    text-align: center;
  }

  /* item total */
  .item-total {
    font-size: 1rem;
    font-weight: 700;
    color: #111;
    min-width: 64px;
    text-align: right;
  }

  /* remove button */
  .btn-remove {
    background: none;
    border: none;
    cursor: pointer;
    color: #ef4444;
    font-size: 1.2rem;
    padding: 4px;
    transition: color 0.2s, transform 0.2s;
    line-height: 1;
  }
  .btn-remove:hover { color: #b91c1c; transform: scale(1.15); }

  /* ── Order Summary card ──────────────────── */
  .order-summary {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 24px;
  }

  .order-summary h3 {
    font-size: 1rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #111;
    margin-bottom: 1.2rem;
  }

  .summary-row {
    display: flex;
    justify-content: space-between;
    font-size: 0.95rem;
    color: #4b5563;
    margin-bottom: 0.8rem;
  }

  .summary-row .free { color: #16a34a; font-weight: 600; }

  .summary-divider {
    border: none;
    border-top: 1px solid #e5e7eb;
    margin: 1rem 0;
  }

  .summary-total {
    display: flex;
    justify-content: space-between;
    font-size: 1.05rem;
    font-weight: 700;
    color: #111;
    margin-bottom: 1.4rem;
  }

  .btn-checkout {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    background: #D47C17;
    color: #fff;
    font-weight: 800;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 14px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.2s, transform 0.2s;
    margin-bottom: 0.9rem;
  }
  .btn-checkout:hover {
    background: #b96d12;
    transform: translateY(-2px);
    color: #fff;
    text-decoration: none;
  }

  .btn-continue {
    display: block;
    text-align: center;
    color: #6b7280;
    font-size: 0.9rem;
    text-decoration: none;
    transition: color 0.2s;
  }
  .btn-continue:hover { color: #D47C17; text-decoration: none; }

  /* ── Bottom actions (clear basket) ──────── */
  .basket-actions {
    margin-top: 16px;
    display: flex;
    justify-content: flex-end;
  }

  .btn-clear {
    background: none;
    border: 1px solid #e5e7eb;
    color: #6b7280;
    font-size: 0.88rem;
    font-weight: 600;
    padding: 9px 20px;
    border-radius: 8px;
    cursor: pointer;
    transition: border-color 0.2s, color 0.2s, background 0.2s;
  }
  .btn-clear:hover {
    border-color: #ef4444;
    color: #ef4444;
    background: #fef2f2;
  }

  /* ── Responsive ──────────────────────────── */
  @media (max-width: 860px) {
    .basket-layout {
      grid-template-columns: 1fr;
    }

    .basket-page {
      padding: 42px 14px;
    }

    .basket-title {
      font-size: 1.35rem;
      margin-bottom: 1rem;
    }
  }

  @media (max-width: 560px) {
    .basket-item {
      flex-wrap: wrap;
      gap: 12px;
      padding: 12px;
    }

    .basket-item img { width: 70px; height: 70px; }

    .basket-item-info {
      min-width: 0;
      width: calc(100% - 82px);
    }

    .qty-controls {
      width: auto;
      margin-left: 82px;
    }

    .item-total {
      min-width: auto;
      margin-left: auto;
    }

    .btn-remove {
      margin-left: 4px;
    }

    .order-summary {
      padding: 18px;
    }
  }

  @media (max-width: 390px) {
    .basket-page {
      padding: 34px 10px;
    }

    .basket-title {
      font-size: 1.18rem;
    }

    .basket-item-info h3 {
      font-size: 0.92rem;
    }

    .btn-checkout {
      font-size: 0.82rem;
      padding: 12px;
    }
  }

  @media (max-width: 360px) {
    .qty-controls {
      margin-left: 0;
      width: 100%;
      justify-content: center;
    }

    .item-total {
      width: 100%;
      text-align: left;
      margin-left: 0;
    }

    .basket-actions {
      justify-content: stretch;
    }

    .btn-clear {
      width: 100%;
    }
  }

  @media (min-width: 768px) and (max-width: 1024px) {
    .basket-layout {
      grid-template-columns: 1fr;
    }

    .order-summary {
      max-width: 480px;
    }
  }

</style>
@endsection

@section('content')
<div class="basket-page">
  <div class="basket-inner">

    @guest
    {{-- ── NOT LOGGED IN ── --}}
    <div class="basket-empty-state">
      <svg class="basket-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993
             l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125
             1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0
             015.513 7.5h12.974c.576 0 1.059.435 1.119
             1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375
             0 01.75 0zm5.625 0a.375.375 0 11-.75 0 .375.375
             0 01.75 0z"/>
      </svg>
      <h2>Your Basket</h2>
      <p>Please log in to view your basket</p>
      <a href="{{ route('login') }}" class="btn-primary">Login to Continue</a>
    </div>
    @endguest

    @auth
    {{-- ── LOGGED IN ── --}}

    @if(session('status'))
      <div class="alert-success">{{ session('status') }}</div>
    @endif
    @if(session('error'))
      <div class="alert-error">{{ session('error') }}</div>
    @endif

    @if($items->isEmpty())
    {{-- Empty cart --}}
    <div class="basket-empty-state">
      <svg class="basket-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993
             l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125
             1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0
             015.513 7.5h12.974c.576 0 1.059.435 1.119
             1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375
             0 01.75 0zm5.625 0a.375.375 0 11-.75 0 .375.375
             0 01.75 0z"/>
      </svg>
      <h2>Your Basket is Empty</h2>
      <p>Looks like you haven't added any items to your basket yet.</p>
      <a href="{{ route('products') }}" class="btn-primary">Start Shopping</a>
    </div>

    @else
    {{-- Filled cart --}}
    <div class="basket-layout">

      <h2 class="basket-title">Shopping basket</h2>

      {{-- Left: items --}}
      <div>
        <div class="basket-items">
          @foreach($items as $item)
          <div class="basket-item">
            <img
              src="{{ asset($item->product->image_url ?: 'images/placeholder.png') }}"
              alt="{{ $item->product->name }}"
            >

            <div class="basket-item-info">
              <h3>{{ $item->product->name }}</h3>
              <p class="item-price">£{{ number_format($item->product->price, 2) }} each</p>
            </div>

            {{-- Quantity: − value + --}}
            <div class="qty-controls">
              {{-- Decrease --}}
              <form method="POST" action="{{ route('basket.update', $item) }}">
                @csrf @method('PATCH')
                <input type="hidden" name="quantity" value="{{ max(1, $item->quantity - 1) }}">
                <button type="submit" class="qty-btn-inline">−</button>
              </form>

              <span class="qty-value">{{ $item->quantity }}</span>

              {{-- Increase --}}
              <form method="POST" action="{{ route('basket.update', $item) }}">
                @csrf @method('PATCH')
                <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                <button type="submit" class="qty-btn-inline">+</button>
              </form>
            </div>

            <div class="item-total">£{{ number_format($item->product->price * $item->quantity, 2) }}</div>

            {{-- Remove --}}
            <form method="POST" action="{{ route('basket.remove', $item) }}">
              @csrf @method('DELETE')
              <button type="submit" class="btn-remove" title="Remove item">
                <i class="fas fa-trash-alt"></i>
              </button>
            </form>
          </div>
          @endforeach
        </div>

        {{-- Clear basket --}}
        <div class="basket-actions">
          <form method="POST" action="{{ route('basket.clear') }}">
            @csrf @method('DELETE')
            <button type="submit" class="btn-clear">
              <i class="fas fa-trash"></i> Clear Basket
            </button>
          </form>
        </div>
      </div>

      {{-- Right: order summary --}}
      <div class="order-summary">
        <h3>Order Summary</h3>

        <div class="summary-row">
          <span>Subtotal ({{ $items->sum('quantity') }} item{{ $items->sum('quantity') === 1 ? '' : 's' }})</span>
          <span>£{{ number_format($total, 2) }}</span>
        </div>
        <div class="summary-row">
          <span>Shipping</span>
          <span class="free">Free</span>
        </div>

        <hr class="summary-divider">

        <div class="summary-total">
          <span>Total</span>
          <span>£{{ number_format($total, 2) }}</span>
        </div>

       
          Proceed to Checkout <i class="fas fa-arrow-right"></i>
        </a>
        <a href="{{ route('products') }}" class="btn-continue">Continue Shopping</a>
      </div>

    </div>
    @endif
    @endauth

  </div>
</div>
@endsection
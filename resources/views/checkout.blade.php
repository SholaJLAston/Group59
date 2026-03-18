@extends('layouts.app')

@section('title', 'Checkout')

@section('extra-css')
<style>

  /* ── Page wrapper ───────────────────────── */
  .checkout-page {
    min-height: 70vh;
    background: #f5f5f3;
    padding: 60px 20px;
  }

  .checkout-inner {
    max-width: 1100px;
    margin: 0 auto;
  }

  .checkout-title {
    font-size: 1.6rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #111;
    margin-bottom: 1.4rem;
  }

  /* ── Alerts ─────────────────────────────── */
  .alert-success {
    margin-bottom: 1.2rem;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    background: #dcfce7;
    color: #166534;
  }

  .alert-error {
    margin-bottom: 1.2rem;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    background: #fee2e2;
    color: #991b1b;
  }

  /* ── Main layout (2 columns) ─────────────── */
  .checkout-layout {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 28px;
    align-items: start;
  }

  /* ── Order Summary (left side) ──────────── */
  .checkout-form-section {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 28px;
  }

  .form-section-title {
    font-size: 1.1rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #111;
    margin-bottom: 1.2rem;
  }

  /* ── Form fields ─────────────────────────── */
  .form-group {
    margin-bottom: 1.2rem;
  }

  .form-group:last-child {
    margin-bottom: 0;
  }

  .form-label {
    display: block;
    font-size: 0.9rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
  }

  .form-input {
    width: 100%;
    padding: 11px 14px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.95rem;
    color: #111;
    background: #ffffff;
    font-family: 'Inter', sans-serif;
    transition: border-color 0.2s, box-shadow 0.2s;
    box-sizing: border-box;
  }

  .form-input:focus {
    outline: none;
    border-color: #D47C17;
    box-shadow: 0 0 0 3px rgba(212, 124, 23, 0.1);
  }

  .form-input.error {
    border-color: #ef4444;
  }

  .form-error {
    font-size: 0.85rem;
    color: #ef4444;
    margin-top: 0.4rem;
  }

  .form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
  }

  .form-grid .form-group {
    margin-bottom: 1.2rem;
  }

  /* ── Actions ─────────────────────────────– */
  .checkout-actions {
    display: flex;
    gap: 12px;
    margin-top: 2rem;
  }

  .btn-submit {
    flex: 1;
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
    transition: background 0.2s, transform 0.2s;
  }

  .btn-submit:hover {
    background: #b96d12;
    transform: translateY(-2px);
  }

  .btn-back {
    display: block;
    color: #6b7280;
    font-size: 0.9rem;
    text-decoration: none;
    text-align: center;
    padding: 12px 20px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    background: #fff;
    cursor: pointer;
    transition: color 0.2s, border-color 0.2s;
  }

  .btn-back:hover {
    color: #D47C17;
    border-color: #D47C17;
    text-decoration: none;
  }

  /* ── Order Summary Card (right side) ────── */
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

  .summary-items {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 1.2rem;
    padding-bottom: 1.2rem;
    border-bottom: 1px solid #e5e7eb;
  }

  .summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
    color: #4b5563;
  }

  .summary-item-name {
    flex: 1;
  }

  .summary-item-qty {
    color: #9ca3af;
    font-size: 0.85rem;
  }

  .summary-item-price {
    font-weight: 600;
    color: #111;
    text-align: right;
    min-width: 60px;
  }

  .summary-row {
    display: flex;
    justify-content: space-between;
    font-size: 0.95rem;
    color: #4b5563;
    margin-bottom: 0.8rem;
  }

  .summary-row .free {
    color: #16a34a;
    font-weight: 600;
  }

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
  }

  /* ── Responsive ──────────────────────────── */
  @media (max-width: 968px) {
    .checkout-layout {
      grid-template-columns: 1fr;
    }

    .checkout-page {
      padding: 42px 14px;
    }

    .checkout-title {
      font-size: 1.35rem;
    }
  }

  @media (max-width: 640px) {
    .checkout-page {
      padding: 34px 14px;
    }

    .checkout-form-section,
    .order-summary {
      padding: 18px;
    }

    .form-grid {
      grid-template-columns: 1fr;
      gap: 0.8rem;
    }

    .checkout-actions {
      flex-direction: column-reverse;
      gap: 10px;
    }

    .btn-submit,
    .btn-back {
      width: 100%;
      padding: 12px;
    }
  }

  @media (max-width: 480px) {
    .checkout-title {
      font-size: 1.2rem;
      margin-bottom: 1rem;
    }

    .form-label {
      font-size: 0.85rem;
    }

    .form-input {
      font-size: 16px;
      padding: 10px 12px;
    }

    .checkout-form-section {
      padding: 14px;
    }

    .order-summary {
      padding: 14px;
    }

    .summary-item {
      font-size: 0.85rem;
    }
  }

</style>
@endsection

@section('content')
<div class="checkout-page">
  <div class="checkout-inner">

    <h1 class="checkout-title">Checkout</h1>

    @if(session('error'))
      <div class="alert-error">{{ session('error') }}</div>
    @endif

    <div class="checkout-layout">

      <!-- Left: Address Form -->
      <form method="POST" action="{{ route('checkout.process') }}">
        @csrf

        <div class="checkout-form-section">
          <h2 class="form-section-title">Shipping Address</h2>

          <!-- Street Address -->
          <div class="form-group">
            <label for="street_address" class="form-label">Street Address *</label>
            <input
              type="text"
              id="street_address"
              name="street_address"
              class="form-input @error('street_address') error @enderror"
              value="{{ old('street_address', $lastShippingAddress?->street_address ?? $user->street_address ?? '') }}"
              placeholder="Enter street address"
              required
            >
            @error('street_address')
              <div class="form-error">{{ $message }}</div>
            @enderror
          </div>

          <!-- City & Postal Code Grid -->
          <div class="form-grid">
            <div class="form-group">
              <label for="city" class="form-label">City *</label>
              <input
                type="text"
                id="city"
                name="city"
                class="form-input @error('city') error @enderror"
                value="{{ old('city', $lastShippingAddress?->city ?? $user->city ?? '') }}"
                placeholder="Enter city"
                required
              >
              @error('city')
                <div class="form-error">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="postal_code" class="form-label">Postal Code *</label>
              <input
                type="text"
                id="postal_code"
                name="postal_code"
                class="form-input @error('postal_code') error @enderror"
                value="{{ old('postal_code', $lastShippingAddress?->postal_code ?? $user->postal_code ?? '') }}"
                placeholder="Enter postal code"
                required
              >
              @error('postal_code')
                <div class="form-error">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <!-- Phone Number -->
          <div class="form-group">
            <label for="phone_number" class="form-label">Phone Number *</label>
            <input
              type="tel"
              id="phone_number"
              name="phone_number"
              class="form-input @error('phone_number') error @enderror"
              value="{{ old('phone_number', $lastShippingAddress?->phone_number ?? $user->phone_number ?? '') }}"
              placeholder="Enter phone number"
              required
            >
            @error('phone_number')
              <div class="form-error">{{ $message }}</div>
            @enderror
          </div>

          <!-- Actions -->
          <div class="checkout-actions">
            <a href="{{ route('basket') }}" class="btn-back">Back to Basket</a>
            <button type="submit" class="btn-submit">Complete Order</button>
          </div>
        </div>

      </form>

      <!-- Right: Order Summary -->
      <div class="order-summary">
        <h3>Order Summary</h3>

        <div class="summary-items">
          @foreach($items as $item)
            <div class="summary-item">
              <span class="summary-item-name">{{ $item->product->name }}</span>
              <span class="summary-item-qty">x{{ $item->quantity }}</span>
              <span class="summary-item-price">£{{ number_format($item->product->price * $item->quantity, 2) }}</span>
            </div>
          @endforeach
        </div>

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
      </div>

    </div>

  </div>
</div>
@endsection

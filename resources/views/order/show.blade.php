@extends('layouts.app')

@section('title', 'Order #' . $order->id)

@section('extra-css')
<style>
    .order-detail-page {
        background: #f4f4f4;
        min-height: calc(100vh - 200px);
        padding: 40px 16px 60px;
    }

    .order-detail-shell {
        max-width: 860px;
        margin: 0 auto;
    }

    .order-detail-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #6b7280;
        font-size: 14px;
        text-decoration: none;
        margin-bottom: 20px;
        transition: color 0.2s;
    }

    .order-detail-back:hover {
        color: #d47c17;
        text-decoration: none;
    }

    .order-detail-heading {
        font-size: 24px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.2px;
        color: #111827;
        margin: 0 0 6px;
    }

    .order-detail-meta {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .order-status {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 3px 10px;
        letter-spacing: 0.4px;
    }

    .order-status.pending    { background: #fef3c7; color: #92400e; }
    .order-status.processing { background: #dbeafe; color: #1e40af; }
    .order-status.shipped    { background: #ede9fe; color: #5b21b6; }
    .order-status.delivered  { background: #d1fae5; color: #065f46; }
    .order-status.cancelled  { background: #fee2e2; color: #991b1b; }

    .order-detail-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        margin-bottom: 20px;
        overflow: hidden;
    }

    .order-detail-card-title {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #111827;
        padding: 14px 20px;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
    }

    .order-items-list {
        padding: 0;
    }

    .order-item-row {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 20px;
        border-bottom: 1px solid #f3f4f6;
    }

    .order-item-row:last-child {
        border-bottom: none;
    }

    .order-item-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border: 1px solid #e5e7eb;
        flex-shrink: 0;
    }

    .order-item-info {
        flex: 1;
    }

    .order-item-name {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 2px;
    }

    .order-item-unit {
        font-size: 12px;
        color: #9ca3af;
    }

    .order-item-qty {
        font-size: 13px;
        color: #6b7280;
        min-width: 40px;
        text-align: center;
    }

    .order-item-subtotal {
        font-size: 14px;
        font-weight: 700;
        color: #111827;
        min-width: 70px;
        text-align: right;
    }

    .order-summary-rows {
        padding: 16px 20px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        color: #4b5563;
        margin-bottom: 10px;
    }

    .summary-row.total {
        font-size: 16px;
        font-weight: 700;
        color: #111827;
        border-top: 1px solid #e5e7eb;
        padding-top: 12px;
        margin-top: 4px;
    }

    .summary-row.total span:last-child {
        color: #d47c17;
    }

    @media (max-width: 640px) {
        .order-detail-heading {
            font-size: 20px;
        }

        .order-item-row {
            display: grid;
            grid-template-columns: 56px 1fr auto;
            gap: 6px 10px;
            align-items: center;
        }

        .order-item-info {
            min-width: 0;
        }

        .order-item-name {
            font-size: 13px;
        }

        .order-item-qty {
            grid-column: 2 / 3;
            justify-self: start;
        }

        .order-item-subtotal {
            grid-column: 3 / 4;
            justify-self: end;
            font-size: 13px;
            min-width: auto;
        }
    }

    @media (max-width: 390px) {
        .order-detail-page {
            padding: 30px 10px 44px;
        }

        .order-detail-heading {
            font-size: 18px;
        }

        .order-detail-card-title {
            padding: 12px 14px;
        }

        .order-summary-rows,
        .order-item-row {
            padding-left: 14px;
            padding-right: 14px;
        }
    }

    @media (min-width: 768px) and (max-width: 1024px) {
        .order-detail-shell {
            max-width: 760px;
        }
    }
</style>
@endsection

@section('content')
<div class="order-detail-page">
    <div class="order-detail-shell">

        <a href="{{ route('order.index') }}" class="order-detail-back">
            <i class="fas fa-arrow-left"></i> Back to My Orders
        </a>

        <h1 class="order-detail-heading">Order {{ $order->order_number }}</h1>

        <div class="order-detail-meta">
            <span>Placed on {{ $order->created_at->format('d M Y, H:i') }}</span>
            <span class="order-status {{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</span>
        </div>

        <div class="order-detail-card">
            <div class="order-detail-card-title">Items Ordered</div>
            <div class="order-items-list">
                @foreach ($order->orderItems as $item)
                    <div class="order-item-row">
                        <img
                            class="order-item-img"
                            src="{{ asset($item->product->image_url ?: 'images/placeholder.png') }}"
                            alt="{{ $item->product->name ?? 'Product' }}"
                        >
                        <div class="order-item-info">
                            <div class="order-item-name">{{ $item->product->name ?? 'Deleted product' }}</div>
                            <div class="order-item-unit">£{{ number_format($item->purchase_price, 2) }} each</div>
                        </div>
                        <div class="order-item-qty">× {{ $item->quantity }}</div>
                        <div class="order-item-subtotal">£{{ number_format($item->purchase_price * $item->quantity, 2) }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="order-detail-card">
            <div class="order-detail-card-title">Order Summary</div>
            <div class="order-summary-rows">
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>£{{ number_format($order->price, 2) }}</span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span style="color: #16a34a; font-weight: 600;">Free</span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span>£{{ number_format($order->price, 2) }}</span>
                </div>
            </div>
        </div>

        @if($order->shippingAddress)
        <div class="order-detail-card">
            <div class="order-detail-card-title">Shipping Address</div>
            <div style="padding: 16px 20px;">
                <p style="margin: 0 0 8px; font-weight: 500; color: #111827;">
                    {{ $order->user->first_name }} {{ $order->user->last_name }}
                </p>
                <p style="margin: 0 0 4px; color: #4b5563; font-size: 14px;">
                    {{ $order->shippingAddress->street_address }}
                </p>
                <p style="margin: 0 0 4px; color: #4b5563; font-size: 14px;">
                    {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->postal_code }}
                </p>
                <p style="margin: 0; color: #4b5563; font-size: 14px;">
                    {{ $order->shippingAddress->phone_number }}
                </p>
            </div>
        </div>
        @endif

        <div class="order-detail-card">
            <div class="order-detail-card-title">Returns</div>
            <div style="padding: 16px 20px;">
                @if (session('success'))
                    <div style="background:#ecfdf3;border:1px solid #9ae6b4;color:#14532d;padding:10px 12px;margin-bottom:12px;">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div style="background:#fff1f2;border:1px solid #fecdd3;color:#9f1239;padding:10px 12px;margin-bottom:12px;">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($order->returns->isNotEmpty())
                    <p style="margin:0 0 10px;color:#4b5563;font-size:14px;">
                        A return request already exists for this order.
                    </p>
                    <a href="{{ route('returns.show', $order->returns->first()) }}" style="color:#d47c17;font-weight:600;text-decoration:none;">
                        View return request
                    </a>
                @else
                    <p style="margin:0 0 10px;color:#4b5563;font-size:14px;">
                        Need to return this order? Submit a return request below.
                    </p>

                    <form method="POST" action="{{ route('returns.store', $order) }}" style="display:grid;gap:10px;max-width:540px;">
                        @csrf

                        <div>
                            <label for="reason" style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:4px;">Reason</label>
                            <select id="reason" name="reason" required style="width:100%;border:1px solid #d1d5db;padding:10px;font-size:14px;">
                                <option value="">Select a reason</option>
                                <option value="defective" {{ old('reason') === 'defective' ? 'selected' : '' }}>Defective</option>
                                <option value="wrong_item" {{ old('reason') === 'wrong_item' ? 'selected' : '' }}>Wrong item</option>
                                <option value="no_longer_needed" {{ old('reason') === 'no_longer_needed' ? 'selected' : '' }}>No longer needed</option>
                                <option value="other" {{ old('reason') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('reason')
                                <div style="color:#b91c1c;font-size:12px;margin-top:4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="comments" style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:4px;">Comments (optional)</label>
                            <textarea id="comments" name="comments" rows="3" style="width:100%;border:1px solid #d1d5db;padding:10px;font-size:14px;">{{ old('comments') }}</textarea>
                            @error('comments')
                                <div style="color:#b91c1c;font-size:12px;margin-top:4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
                            <button type="submit" style="background:#111827;color:#fff;border:0;padding:10px 14px;cursor:pointer;font-weight:600;">
                                Submit Return Request
                            </button>

                            <a href="{{ route('returns.index') }}" style="color:#d47c17;text-decoration:none;font-weight:600;">View all my returns</a>
                        </div>
                    </form>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection

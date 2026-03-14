@extends('layouts.app')

@section('title', 'My Orders')

@section('extra-css')
<style>
    .orders-page {
        background: #f4f4f4;
        min-height: calc(100vh - 200px);
        padding: 40px 16px 60px;
    }

    .orders-shell {
        max-width: 900px;
        margin: 0 auto;
    }

    .orders-heading {
        font-size: 28px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.2px;
        color: #111827;
        margin: 0 0 24px;
    }

    .orders-empty {
        background: #fff;
        border: 1px solid #e5e7eb;
        padding: 60px 24px;
        text-align: center;
    }

    .orders-empty i {
        font-size: 3rem;
        color: #d1d5db;
        margin-bottom: 16px;
        display: block;
    }

    .orders-empty p {
        color: #6b7280;
        margin-bottom: 20px;
        font-size: 15px;
    }

    .orders-empty a {
        display: inline-block;
        background: #d47c17;
        color: #fff;
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
        padding: 12px 28px;
        text-decoration: none;
        letter-spacing: 0.3px;
        transition: background 0.2s;
    }

    .orders-empty a:hover {
        background: #bc6f14;
    }

    .order-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        margin-bottom: 16px;
        overflow: hidden;
    }

    .order-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        gap: 12px;
        flex-wrap: wrap;
    }

    .order-number {
        font-weight: 700;
        font-size: 14px;
        color: #111827;
    }

    .order-date {
        font-size: 13px;
        color: #6b7280;
    }

    .order-status {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 4px 12px;
        letter-spacing: 0.4px;
    }

    .order-status.pending   { background: #fef3c7; color: #92400e; }
    .order-status.processing{ background: #dbeafe; color: #1e40af; }
    .order-status.shipped   { background: #ede9fe; color: #5b21b6; }
    .order-status.delivered { background: #d1fae5; color: #065f46; }
    .order-status.cancelled { background: #fee2e2; color: #991b1b; }

    .order-card-body {
        padding: 16px 20px;
    }

    .order-items-preview {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .order-item-row {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .order-item-img {
        width: 52px;
        height: 52px;
        object-fit: cover;
        border: 1px solid #e5e7eb;
        flex-shrink: 0;
    }

    .order-item-name {
        flex: 1;
        font-size: 14px;
        font-weight: 600;
        color: #111827;
    }

    .order-item-qty {
        font-size: 13px;
        color: #6b7280;
    }

    .order-item-price {
        font-size: 14px;
        font-weight: 700;
        color: #111827;
    }

    .order-more-items {
        font-size: 13px;
        color: #6b7280;
        margin-top: 4px;
        padding-left: 64px;
    }

    .order-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 20px;
        border-top: 1px solid #e5e7eb;
        background: #f9fafb;
        gap: 12px;
        flex-wrap: wrap;
    }

    .order-total {
        font-size: 15px;
        font-weight: 700;
        color: #111827;
    }

    .order-total span {
        color: #d47c17;
    }

    .btn-view-order {
        display: inline-block;
        background: #111827;
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 10px 20px;
        text-decoration: none;
        letter-spacing: 0.3px;
        transition: background 0.2s;
    }

    .btn-view-order:hover {
        background: #d47c17;
        color: #fff;
        text-decoration: none;
    }

    @media (max-width: 640px) {
        .order-card-header,
        .order-card-footer {
            flex-direction: column;
            align-items: flex-start;
        }

        .orders-heading {
            font-size: 22px;
        }

        .order-card-body {
            padding: 14px;
        }

        .order-item-row {
            display: grid;
            grid-template-columns: 52px 1fr auto;
            gap: 6px 10px;
            align-items: center;
        }

        .order-item-name {
            font-size: 13px;
        }

        .order-item-qty {
            grid-column: 2 / 3;
            justify-self: start;
        }

        .order-item-price {
            grid-column: 3 / 4;
            justify-self: end;
            font-size: 13px;
        }

        .order-more-items {
            padding-left: 0;
        }
    }

    @media (max-width: 390px) {
        .orders-page {
            padding: 30px 10px 44px;
        }

        .orders-heading {
            font-size: 19px;
            margin-bottom: 14px;
        }

        .btn-view-order {
            width: 100%;
            text-align: center;
        }
    }

    @media (min-width: 768px) and (max-width: 1024px) {
        .orders-shell {
            max-width: 760px;
        }
    }
</style>
@endsection

@section('content')
<div class="orders-page">
    <div class="orders-shell">
        <h1 class="orders-heading">My Orders</h1>

        @if ($orders->isEmpty())
            <div class="orders-empty">
                <i class="fas fa-shopping-bag"></i>
                <p>You haven't placed any orders yet.</p>
                <a href="{{ route('products') }}">Start Shopping</a>
            </div>
        @else
            @foreach ($orders as $order)
                <div class="order-card">
                    <div class="order-card-header">
                        <div>
                            <div class="order-number">Order #{{ $order->id }}</div>
                            <div class="order-date">{{ $order->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        <span class="order-status {{ strtolower($order->status) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    <div class="order-card-body">
                        <div class="order-items-preview">
                            @foreach ($order->orderItems->take(2) as $item)
                                <div class="order-item-row">
                                    <img
                                        class="order-item-img"
                                        src="{{ asset($item->product->image_url ?: 'images/placeholder.png') }}"
                                        alt="{{ $item->product->name ?? 'Product' }}"
                                    >
                                    <div class="order-item-name">{{ $item->product->name ?? 'Deleted product' }}</div>
                                    <div class="order-item-qty">× {{ $item->quantity }}</div>
                                    <div class="order-item-price">£{{ number_format($item->purchase_price * $item->quantity, 2) }}</div>
                                </div>
                            @endforeach
                        </div>

                        @if ($order->orderItems->count() > 2)
                            <div class="order-more-items">
                                +{{ $order->orderItems->count() - 2 }} more item{{ $order->orderItems->count() - 2 !== 1 ? 's' : '' }}
                            </div>
                        @endif
                    </div>

                    <div class="order-card-footer">
                        <div class="order-total">
                            Total: <span>£{{ number_format($order->price, 2) }}</span>
                        </div>
                        <a href="{{ route('order.show', $order) }}" class="btn-view-order">
                            View Details <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection

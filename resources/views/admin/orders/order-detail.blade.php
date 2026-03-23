@extends('layouts.admin')

@section('title', 'Order #' . $order->id)

@section('extra-css')
<style>
.admin-wrap{max-width:1100px;margin:0 auto;padding:28px 16px 50px}.card{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:14px;margin-bottom:14px}.row{display:flex;gap:10px;flex-wrap:wrap}.btn-admin{background:#111827;color:#fff;text-decoration:none;padding:8px 12px;border-radius:8px;font-size:13px;border:none;cursor:pointer}.btn-admin:hover{background:#d47c17;color:#fff}.table{width:100%;border-collapse:collapse}.table th,.table td{padding:8px;border-bottom:1px solid #f1f5f9;font-size:14px;text-align:left}
</style>
@endsection

@section('content')
<div class="admin-wrap">
    <h1 style="margin:0 0 14px;">Order #{{ $order->id }}</h1>

    @if(session('status'))<div class="card" style="color:#065f46;">{{ session('status') }}</div>@endif

    <div class="card">
        <div class="row" style="justify-content:space-between;align-items:center;">
            <div>
                <strong>Customer:</strong> {{ $order->user->first_name }} {{ $order->user->last_name }} ({{ $order->user->email }})<br>
                <strong>Total:</strong> &pound;{{ number_format($order->price, 2) }}<br>
                <strong>Placed:</strong> {{ $order->created_at->format('d M Y H:i') }}
            </div>
            <div>
                <form method="POST" action="{{ route('admin.orders.status', $order) }}" style="display:flex; gap:8px; align-items:center;">
                    @csrf @method('PATCH')
                    <select name="status" style="padding:8px 10px; border:1px solid #ddd; border-radius:8px;">
                        @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                            <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <button class="btn-admin" type="submit">Update Status</button>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <h3 style="margin-top:0;">Items</h3>
        <table class="table">
            <thead><tr><th>Product</th><th>Qty</th><th>Unit Price</th><th>Subtotal</th></tr></thead>
            <tbody>
                @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name ?? 'Deleted product' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>&pound;{{ number_format($item->purchase_price, 2) }}</td>
                        <td>&pound;{{ number_format($item->purchase_price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card">
        <h3 style="margin-top:0;">Shipping Address</h3>
        @if($order->shippingAddress)
            <div>
                <strong>{{ $order->user->first_name }} {{ $order->user->last_name }}</strong><br>
                {{ $order->shippingAddress->street_address }}<br>
                {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->postal_code }}<br>
                {{ $order->shippingAddress->phone_number }}
            </div>
        @else
            <p style="margin:0;color:#6b7280;">No shipping address recorded for this order.</p>
        @endif
    </div>
</div>
@endsection



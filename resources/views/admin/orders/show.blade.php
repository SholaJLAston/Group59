@extends('layouts.admin')

@section('title', 'Order #' . $order->id)
@section('page-title', 'Orders')

@section('extra-css')
<style>
.admin-wrap{max-width:1100px;margin:0 auto}.card{background:#fff;border:1px solid #e5e7eb;border-radius:18px;padding:16px;margin-bottom:14px}.row{display:flex;gap:10px;flex-wrap:wrap}.btn-admin{background:#111827;color:#fff;text-decoration:none;padding:10px 14px;border-radius:12px;font-size:13px;border:none;cursor:pointer}.btn-admin:hover{background:#d47c17;color:#fff}.table{width:100%;border-collapse:collapse}.table th,.table td{padding:10px;border-bottom:1px solid #f1f5f9;font-size:14px;text-align:left}.status-select{padding:10px 12px;border:1px solid #d7d7d7;border-radius:12px;background:#fff;min-width:180px;transition:border-color .2s ease, box-shadow .2s ease}.status-select:hover{border-color:#d88411;box-shadow:0 0 0 3px #f7e8d1}.status-select:focus{outline:none;border-color:#d88411;box-shadow:0 0 0 3px #f7e8d1}
</style>
@endsection

@section('content')
<div class="admin-wrap">
    <h1 style="margin:0 0 14px;font-family:'Oswald',sans-serif;text-transform:uppercase;">Order #{{ strtoupper(substr(md5((string) $order->id), 0, 8)) }}</h1>

    @if(session('status'))<div class="card" style="color:#065f46;">{{ session('status') }}</div>@endif

    <div class="card">
        <div class="row" style="justify-content:space-between;align-items:center;">
            <div>
                <strong>Customer:</strong> {{ $order->user->first_name }} {{ $order->user->last_name }} ({{ $order->user->email }})<br>
                <strong>Total:</strong> £{{ number_format($order->price, 2) }}<br>
                <strong>Placed:</strong> {{ $order->created_at->format('d M Y H:i') }}
            </div>
            <div>
                <form method="POST" action="{{ route('admin.orders.status', $order) }}" style="display:flex; gap:8px; align-items:center;">
                    @csrf @method('PATCH')
                    <select name="status" class="status-select">
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
                        <td>£{{ number_format($item->purchase_price, 2) }}</td>
                        <td>£{{ number_format($item->purchase_price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@extends('layouts.admin')

@section('title', 'Admin Orders')
@section('page-title', 'Orders')

@section('extra-css')
<style>
.orders-wrap{max-width:1500px;margin:0 auto;display:grid;gap:16px}
.orders-top{display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap}
.filter-select,.status-select{padding:10px 12px;border:1px solid #d7d7d7;border-radius:12px;background:#fff;min-width:180px;transition:border-color .2s ease, box-shadow .2s ease}
.filter-select:hover,.status-select:hover{border-color:#d88411;box-shadow:0 0 0 3px #f7e8d1}
.filter-select:focus,.status-select:focus{outline:none;border-color:#d88411;box-shadow:0 0 0 3px #f7e8d1}
.orders-grid{display:grid;grid-template-columns:2fr 1fr;gap:16px}
.card{background:#fff;border:1px solid #e4e4e4;border-radius:18px;overflow:hidden}
.table{width:100%;border-collapse:collapse}
.table th,.table td{padding:14px 16px;border-bottom:1px solid #f1f1f1;font-size:14px;text-align:left}
.table th{font-size:12px;text-transform:uppercase;letter-spacing:.04em;color:#6a6a6a}
.order-row.active{background:#fff7eb}
/*.order-row:hover { background: #fff7eb; } */
.order-id{font-size:34px;font-weight:700;color:#141414}
.item-count{color:#6e6e6e;font-size:13px}
.badge{padding:6px 10px;border-radius:999px;font-size:12px;font-weight:600}
.pending{background:#fff4d6;color:#9a6900}.processing{background:#e0ebff;color:#2452b2}.shipped{background:#efe8ff;color:#5a31b8}.delivered{background:#dcf5e5;color:#187748}.cancelled{background:#fee2e2;color:#991b1b}
.act-link{display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:999px;text-decoration:none;color:#222}
.act-link:hover{background:#fff1dd;color:#d88411}
.details{padding:16px;border-radius:18px}
.details h3{margin:0 0 14px;font-family:'Oswald',sans-serif;font-size:30px;line-height:1;text-transform:uppercase}
.details .sec{margin-bottom:16px; padding: 16px; background: #f9f9f9; border-radius: 12px;}
.detail-item{display:flex;align-items: center; gap: 12px; padding: 10px 0; border-bottom: 1px solid #e2e2e2;}
.detail-item:last-child { border-bottom: none; }
.shipping-address { display: flex; flex-direction: column; gap: 4px; }
.muted{color:#6e6e6e;font-size:13px}
.total-row{display:flex;justify-content:space-between;font-weight:700;font-size:20px;padding-top:12px;border-top:1px solid #ececec}
.empty-box{padding:42px 16px;color:#747474;text-align:center}

@media (max-width: 1100px){.orders-grid{grid-template-columns:1fr}}
</style>
@endsection

@section('content')
<div class="orders-wrap">
    <form method="GET" action="{{ route('admin.orders.search') }}" class="orders-top">
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <input name="q" value="{{ request('q') }}" placeholder="Search order or customer" class="filter-select" style="min-width:260px;">
            <select name="status" class="filter-select">
                <option value="">All Status</option>
                @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" style="padding:10px 14px;border:none;border-radius:12px;background:#111;color:#fff;">Apply</button>
    </form>

    <div class="orders-grid">
        <div class="card">
            <table class="table">
                <thead><tr><th>Order</th><th>Date</th><th>Status</th><th>Total</th></tr></thead>
                <tbody>
                @forelse($orders as $order)
                    @php
                        $query = request()->query();
                        $query['selected'] = $order->id;
                    @endphp
                    <tr class="order-row {{ ($selectedOrder?->id === $order->id) ? 'active' : '' }}"
                        onclick="window.location='{{ route('admin.orders', $query) }}'"
                        style="cursor:pointer;">
                        <td>
                            <div class="order-id">#{{ strtoupper(substr(md5((string) $order->id), 0, 8)) }}</div>
                            <div class="item-count">{{ $order->orderItems->sum('quantity') }} items</div>
                        </td>
                        <td>{{ $order->created_at->format('n/j/Y') }}</td>
                        <td><span class="badge {{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</span></td>
                        <td>&pound;{{ number_format((float) $order->price, 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5">No orders found.</td></tr>
                @endforelse
                </tbody>
            </table>

            <div style="padding:14px 16px;">{{ $orders->links() }}</div>
        </div>

        <div class="card details">
            @if($selectedOrder)
                <h3>Order #{{ strtoupper(substr(md5((string) $selectedOrder->id), 0, 8)) }}</h3>

                <div class="sec">
                    <label style="display:block;margin-bottom:8px;font-weight:600;">Update Status</label>
                    <form method="POST" action="{{ route('admin.orders.status', $selectedOrder) }}">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="status-select" style="width:100%;">
                            @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                                <option value="{{ $s }}" {{ $selectedOrder->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                        <button type="submit" style="margin-top:10px;padding:10px 14px;border:none;border-radius:12px;background:#111;color:#fff;">Save Status</button>
                    </form>
                </div>

                <div class="sec">
                    <div style="font-weight:700;margin-bottom:10px;">Items</div>
                    @foreach($selectedOrder->orderItems as $item)
                        <div class="detail-item" style="margin-bottom:10px;">
                            <div>
                                <div style="font-weight:600;">{{ $item->product->name ?? 'Deleted product' }}</div>
                                <div class="muted">{{ $item->quantity }} x &pound;{{ number_format((float) $item->purchase_price, 2) }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="sec">
                    <div style="font-weight:700;margin-bottom:8px;">Shipping Address</div>
                    @if($selectedOrder->shippingAddress)
                        <div class="muted">{{ $selectedOrder->shippingAddress->street_address }}</div>
                        <div class="muted">{{ trim($selectedOrder->shippingAddress->city . ' ' . $selectedOrder->shippingAddress->postal_code) }}</div>
                        <div class="muted">{{ $selectedOrder->shippingAddress->phone_number }}</div>
                    @else
                        <div class="muted">No shipping address recorded for this order.</div>
                    @endif
                </div>

                <div class="total-row">
                    <span>Total</span>
                    <span>&pound;{{ number_format((float) $selectedOrder->price, 2) }}</span>
                </div>
            @else
                <div class="empty-box">
                    <div style="font-size:44px;color:#c7c7c7;margin-bottom:10px;"><i class="fa-solid fa-box-open"></i></div>
                    <div>Select an order to view details</div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection




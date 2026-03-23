@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('extra-css')
<style>
.dash-grid { display:grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 18px; margin-bottom: 20px; }
.dash-card { background:#fff; border:1px solid #ddd; min-height:150px; padding:24px 28px; }
.dash-card .label { color:#6a6a6a; font-size:15px; margin-bottom:8px; font-weight:500; }
.dash-card .value { font-size:32px; font-weight:700; line-height:1.1; }
.dash-note { margin-top:8px; color:#3a3a3a; font-size:14px; }
.dash-note .ok { color:#17a34a; }
.dash-note .warn { color:#d78709; }
.dash-note .proc { color:#2563eb; }
.recent-box { background:#fff; border:1px solid #ddd; padding:22px 28px; }
.recent-head { display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; }
.recent-head h2 { margin:0; font-family:'Oswald', sans-serif; text-transform:uppercase; font-size:22px; }
.recent-head a { color:#d88411; text-decoration:none; font-size:14px; }
.recent-table { width:100%; border-collapse:collapse; }
.recent-table th, .recent-table td { border-bottom:1px solid #ececec; text-align:left; padding:14px 10px; font-size:14px; }
.recent-table th { color:#646464; font-size:12px; text-transform:uppercase; letter-spacing:.03em; }
.status-pill { display:inline-block; padding:5px 10px; font-size:12px; font-weight:600; }
.status-delivered { background:#dff7e7; color:#187748; }
.status-processing { background:#dce8ff; color:#2456c2; }
.status-pending { background:#fff5da; color:#9a6800; }
.status-shipped { background:#ece4ff; color:#5d32c2; }
.status-cancelled { background:#fee2e2; color:#991b1b; }

@media (max-width: 1240px) {
    .dash-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}

@media (max-width: 720px) {
    .dash-grid { grid-template-columns: 1fr; }
    .dash-card .value { font-size:28px; }
}
</style>
@endsection

@section('content')
<div class="dash-grid">
    <section class="dash-card">
        <div class="label">Total Revenue</div>
        <div class="value">&pound;{{ number_format($totalRevenue, 2) }}</div>
        <div class="dash-note"><span class="ok"><i class="fa-solid fa-arrow-trend-up"></i> From completed orders</span></div>
    </section>

    <section class="dash-card">
        <div class="label">Total Orders</div>
        <div class="value">{{ $totalOrders }}</div>
        <div class="dash-note"><span class="warn">{{ $pendingOrders }} pending</span> <span style="color:#777;">&bull;</span> <span class="proc">{{ $processingOrders }} processing</span></div>
    </section>

    <section class="dash-card">
        <div class="label">Total Products</div>
        <div class="value">{{ $productsCount }}</div>
    </section>

    <section class="dash-card">
        <div class="label">Total Customers</div>
        <div class="value">{{ $customersCount }}</div>
        <div class="dash-note">Registered customers</div>
    </section>
</div>

<div class="recent-box">
    <div class="recent-head">
        <h2>Recent Orders</h2>
        <a href="{{ route('admin.orders') }}">View All</a>
    </div>

    <table class="recent-table">
        <thead><tr><th>Order ID</th><th>Date</th><th>Status</th><th>Total</th></tr></thead>
        <tbody>
            @forelse($recentOrders as $order)
                <tr>
                    <td>#{{ strtoupper(substr(md5((string) $order->id), 0, 8)) }}</td>
                    <td><i class="fa-regular fa-clock" style="color:#7a7a7a;margin-right:6px;"></i> {{ $order->created_at->format('n/j/Y') }}</td>
                    <td>
                        <span class="status-pill status-{{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</span>
                    </td>
                    <td>&pound;{{ number_format((float) $order->price, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="4">No recent orders yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection


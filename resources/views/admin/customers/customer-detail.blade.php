@extends('layouts.admin')

@section('title', 'Customer Details')
@section('page-title', 'Customer Details')

@section('content')
<div style="max-width:1000px;margin:0 auto;padding:28px 16px 50px;">
    <h1 style="margin:0 0 20px;color:#111827;">Customer Details</h1>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:18px;padding:20px;margin-bottom:16px;box-shadow:0 1px 3px rgba(0,0,0,0.05);">
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:16px;">
            <div>
                <div style="font-size:12px;color:#6b7280;font-weight:500;margin-bottom:4px;">First Name</div>
                <div style="font-size:14px;color:#111827;font-weight:500;">{{ $user->first_name }}</div>
            </div>
            <div>
                <div style="font-size:12px;color:#6b7280;font-weight:500;margin-bottom:4px;">Last Name</div>
                <div style="font-size:14px;color:#111827;font-weight:500;">{{ $user->last_name }}</div>
            </div>
            <div>
                <div style="font-size:12px;color:#6b7280;font-weight:500;margin-bottom:4px;">Email</div>
                <div style="font-size:14px;color:#111827;">{{ $user->email }}</div>
            </div>
            <div>
                <div style="font-size:12px;color:#6b7280;font-weight:500;margin-bottom:4px;">Phone</div>
                <div style="font-size:14px;color:#111827;">{{ $user->phone_number ?: '-' }}</div>
            </div>
            <div>
                <div style="font-size:12px;color:#6b7280;font-weight:500;margin-bottom:4px;">Role</div>
                <div style="font-size:14px;color:#111827;"><span style="background:#f3f4f6;padding:3px 8px;border-radius:6px;">{{ ucfirst($user->role) }}</span></div>
            </div>
            <div>
                <div style="font-size:12px;color:#6b7280;font-weight:500;margin-bottom:4px;">Total Orders</div>
                <div style="font-size:14px;color:#111827;font-weight:600;">{{ $user->orders_count }}</div>
            </div>
        </div>
    </div>

    <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:16px;">
        <a class="admin-btn admin-btn-primary" href="{{ route('admin.customers.edit', $user) }}">Edit Customer</a>
        <a class="admin-btn admin-btn-dark" href="{{ route('admin.customers.activity', $user) }}">View Activity</a>
        <a class="admin-btn admin-btn-dark" href="{{ route('admin.customers.orders', $user) }}">Order History</a>
        <form method="POST" action="{{ route('admin.customers.destroy', $user) }}" onsubmit="return confirm('Delete this customer?');" style="display:inline;">
            @csrf @method('DELETE')
            <button class="admin-btn" type="submit" style="background:#b91c1c;color:#fff;border:none;cursor:pointer;">Delete</button>
        </form>
    </div>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:18px;padding:20px;box-shadow:0 1px 3px rgba(0,0,0,0.05);">
        <h3 style="margin:0 0 14px 0;color:#111827;font-weight:600;">Recent Orders</h3>
        @forelse($latestOrders as $order)
            <div style="padding:10px 0;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;font-size:14px;">
                <div><strong>#{{ $order->id }}</strong> - &pound;{{ number_format($order->price,2) }}</div>
                <div><span style="background:#f0f9ff;color:#0369a1;padding:2px 6px;border-radius:4px;font-size:12px;">{{ ucfirst($order->status) }}</span> - {{ $order->created_at->format('d M Y') }}</div>
            </div>
        @empty
            <div style="color:#9ca3af;font-size:14px;">No orders yet.</div>
        @endforelse
    </div>
</div>
@endsection



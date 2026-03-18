@extends('layouts.app')

@section('title', 'Customer Details')

@section('extra-css')
<style>
.admin-wrap{max-width:1000px;margin:0 auto;padding:28px 16px 50px}.card{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:14px;margin-bottom:12px}.btn-admin{background:#111827;color:#fff;text-decoration:none;padding:8px 12px;border-radius:8px;font-size:13px}.btn-admin:hover{background:#d47c17;color:#fff}
</style>
@endsection

@section('content')
<div class="admin-wrap">
    <h1 style="margin:0 0 14px;">Customer Details</h1>
    @include('admin._menu')

    <div class="card">
        <strong>Name:</strong> {{ $user->first_name }} {{ $user->last_name }}<br>
        <strong>Email:</strong> {{ $user->email }}<br>
        <strong>Role:</strong> {{ ucfirst($user->role) }}<br>
        <strong>Phone:</strong> {{ $user->phone_number ?: '-' }}<br>
        <strong>Total Orders:</strong> {{ $user->orders_count }}
    </div>

    <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:14px;">
        <a class="btn-admin" href="{{ route('admin.customers.edit', $user) }}">Edit</a>
        <a class="btn-admin" href="{{ route('admin.customers.activity', $user) }}">Activity</a>
        <a class="btn-admin" href="{{ route('admin.customers.orders', $user) }}">Orders</a>
        <form method="POST" action="{{ route('admin.customers.destroy', $user) }}" onsubmit="return confirm('Delete this user?');">
            @csrf @method('DELETE')
            <button class="btn-admin" type="submit" style="background:#b91c1c;">Delete</button>
        </form>
    </div>

    <div class="card">
        <h3 style="margin-top:0;">Recent Orders</h3>
        @forelse($latestOrders as $order)
            <div>#{{ $order->id }} - £{{ number_format($order->price,2) }} - {{ ucfirst($order->status) }} - {{ $order->created_at->format('d M Y') }}</div>
        @empty
            <div>No orders yet.</div>
        @endforelse
    </div>
</div>
@endsection
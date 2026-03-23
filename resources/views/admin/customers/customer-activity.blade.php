@extends('layouts.admin')

@section('title', 'Customer Activity')
@section('page-title', 'Customer Activity')

@section('content')
<div style="max-width:1000px;margin:0 auto;padding:28px 16px 50px;">
    <h1 style="margin:0 0 14px;">Activity: {{ $user->first_name }} {{ $user->last_name }}</h1>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:18px;padding:16px;margin-bottom:12px;box-shadow:0 1px 3px rgba(0,0,0,0.05);">
        <h3 style="margin:0 0 12px 0;font-weight:600;color:#111827;">Recent Orders</h3>
        @forelse($orders as $order)
            <div style="padding:10px 0;border-bottom:1px solid #f1f5f9;font-size:14px;color:#374151;">#{{ $order->id }} - &pound;{{ number_format($order->price, 2) }} - <span style="background:#f0f9ff;color:#0369a1;padding:2px 6px;border-radius:4px;font-size:12px;">{{ ucfirst($order->status) }}</span> - {{ $order->created_at->format('d M Y H:i') }}</div>
        @empty
            <div style="color:#9ca3af;font-size:14px;">No orders yet.</div>
        @endforelse
    </div>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:18px;padding:16px;box-shadow:0 1px 3px rgba(0,0,0,0.05);">
        <h3 style="margin:0 0 12px 0;font-weight:600;color:#111827;">Recent Contact Requests</h3>
        @forelse($contacts as $contact)
            <div style="padding:10px 0;border-bottom:1px solid #f1f5f9;font-size:14px;color:#374151;">{{ $contact->subject }} - <span style="background:#fef3c7;color:#92400e;padding:2px 6px;border-radius:4px;font-size:12px;">{{ $contact->status }}</span> - {{ $contact->created_at->format('d M Y H:i') }}</div>
        @empty
            <div style="color:#9ca3af;font-size:14px;">No contact requests.</div>
        @endforelse
    </div>
</div>
@endsection



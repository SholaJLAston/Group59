@extends('layouts.app')

@section('title', 'Customer Activity')

@section('content')
<div style="max-width:1000px;margin:0 auto;padding:28px 16px 50px;">
    <h1 style="margin:0 0 14px;">Activity: {{ $user->first_name }} {{ $user->last_name }}</h1>
    @include('admin._menu')

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:14px;margin-bottom:12px;">
        <h3 style="margin-top:0;">Recent Orders</h3>
        @forelse($orders as $order)
            <div>#{{ $order->id }} - £{{ number_format($order->price, 2) }} - {{ ucfirst($order->status) }} - {{ $order->created_at->format('d M Y H:i') }}</div>
        @empty
            <div>No orders yet.</div>
        @endforelse
    </div>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:14px;">
        <h3 style="margin-top:0;">Recent Contact Requests</h3>
        @forelse($contacts as $contact)
            <div>{{ $contact->subject }} - {{ $contact->status }} - {{ $contact->created_at->format('d M Y H:i') }}</div>
        @empty
            <div>No contact requests.</div>
        @endforelse
    </div>
</div>
@endsection
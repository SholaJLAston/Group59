@extends('layouts.app')

@section('title', 'Customer Orders')

@section('content')
<div style="max-width:1100px;margin:0 auto;padding:28px 16px 50px;">
    <h1 style="margin:0 0 14px;">Orders: {{ $user->first_name }} {{ $user->last_name }}</h1>
    @include('admin._menu')

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">
        <table style="width:100%;border-collapse:collapse;">
            <thead><tr><th style="padding:10px;text-align:left;">Order</th><th style="padding:10px;text-align:left;">Status</th><th style="padding:10px;text-align:left;">Total</th><th style="padding:10px;text-align:left;">Date</th></tr></thead>
            <tbody>
            @forelse($orders as $order)
                <tr>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">#{{ $order->id }}</td>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">{{ ucfirst($order->status) }}</td>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">£{{ number_format($order->price,2) }}</td>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">{{ $order->created_at->format('d M Y H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" style="padding:10px;">No orders found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:12px;">{{ $orders->links() }}</div>
</div>
@endsection
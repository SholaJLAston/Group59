@extends('layouts.app')

@section('title', 'Inventory Product')

@section('content')
<div style="max-width:1100px;margin:0 auto;padding:28px 16px 50px;">
    <h1 style="margin:0 0 14px;">Inventory Detail: {{ $product->name }}</h1>
    @include('admin._menu')

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:14px;margin-bottom:12px;">
        <div><strong>Category:</strong> {{ $product->category->name ?? '-' }}</div>
        <div><strong>Current Stock:</strong> {{ $product->stock_quantity }}</div>
        <div><strong>Status:</strong> {{ $product->stock_status }}</div>
        <div><strong>Low Stock Threshold:</strong> {{ $product->low_stock_threshold }}</div>
        <a href="{{ route('admin.products.stock', $product) }}" style="display:inline-block;margin-top:10px;padding:8px 12px;background:#d47c17;color:#fff;text-decoration:none;border-radius:8px;">Manage Stock</a>
    </div>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">
        <table style="width:100%;border-collapse:collapse;">
            <thead><tr><th style="padding:10px;text-align:left;">Date</th><th style="padding:10px;text-align:left;">Type</th><th style="padding:10px;text-align:left;">Qty</th><th style="padding:10px;text-align:left;">Reference</th></tr></thead>
            <tbody>
            @forelse($movements as $move)
                <tr>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">{{ $move->created_at->format('d M Y H:i') }}</td>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">{{ strtoupper($move->type) }}</td>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">{{ $move->quantity }}</td>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">{{ $move->reference }}</td>
                </tr>
            @empty
                <tr><td colspan="4" style="padding:10px;">No movements found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:12px;">{{ $movements->links() }}</div>
</div>
@endsection
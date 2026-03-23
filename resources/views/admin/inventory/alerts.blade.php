@extends('layouts.admin')

@section('title', 'Low Stock Alerts')
@section('page-title', 'Low Stock Alerts')

@section('content')
<div style="max-width:1100px;margin:0 auto;padding:28px 16px 50px;">
    <h1 style="margin:0 0 14px;">Low Stock Alerts</h1>

    @if(session('status'))<div style="margin-bottom:10px;color:#065f46;">{{ session('status') }}</div>@endif

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">
        <table style="width:100%;border-collapse:collapse;">
            <thead><tr><th style="padding:10px;text-align:left;">Product</th><th style="padding:10px;text-align:left;">Category</th><th style="padding:10px;text-align:left;">Stock</th><th style="padding:10px;text-align:left;">Threshold</th><th style="padding:10px;text-align:left;">Update</th></tr></thead>
            <tbody>
            @forelse($lowStockProducts as $product)
                <tr>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">{{ $product->name }}</td>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">{{ $product->category->name ?? '-' }}</td>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">{{ $product->stock_quantity }} ({{ $product->stock_status }})</td>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">{{ $product->low_stock_threshold }}</td>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">
                        <form method="POST" action="{{ route('admin.inventory.threshold.update', $product) }}" style="display:flex;gap:8px;align-items:center;">
                            @csrf @method('PATCH')
                            <input type="number" name="low_stock_threshold" value="{{ $product->low_stock_threshold }}" min="1" style="width:90px;padding:6px;border:1px solid #ddd;border-radius:6px;">
                            <button type="submit" style="border:none;background:#111827;color:#fff;padding:6px 10px;border-radius:6px;">Save</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="padding:10px;">No low stock alerts.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:12px;">{{ $lowStockProducts->links() }}</div>
</div>
@endsection


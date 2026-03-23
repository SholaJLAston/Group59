@extends('layouts.app')

@section('title', 'Stock Movements')

@section('content')
<div style="max-width:1200px;margin:0 auto;padding:28px 16px 50px;">
    <h1 style="margin:0 0 14px;">Stock Movements</h1>
    @include('admin._menu')

    @if(session('status'))<div style="margin-bottom:10px;color:#065f46;">{{ session('status') }}</div>@endif

    <form method="GET" action="{{ route('admin.inventory.movements') }}" style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px;">
        <input name="q" value="{{ request('q') }}" placeholder="Reference or product" style="padding:8px 10px;border:1px solid #ddd;border-radius:8px;">
        <select name="type" style="padding:8px 10px;border:1px solid #ddd;border-radius:8px;">
            <option value="">All</option>
            <option value="in" {{ request('type')==='in' ? 'selected' : '' }}>IN</option>
            <option value="out" {{ request('type')==='out' ? 'selected' : '' }}>OUT</option>
        </select>
        <button type="submit" style="padding:8px 12px;border:none;border-radius:8px;background:#111827;color:#fff;">Filter</button>
    </form>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">
        <table style="width:100%;border-collapse:collapse;">
            <thead><tr><th style="padding:10px;text-align:left;">Date</th><th style="padding:10px;text-align:left;">Product</th><th style="padding:10px;text-align:left;">Type</th><th style="padding:10px;text-align:left;">Qty</th><th style="padding:10px;text-align:left;">Reference</th></tr></thead>
            <tbody>
            @forelse($movements as $move)
                <tr>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">{{ $move->created_at->format('d M Y H:i') }}</td>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">{{ $move->product->name ?? '-' }}</td>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">{{ strtoupper($move->type) }}</td>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">{{ $move->quantity }}</td>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">{{ $move->reference }}</td>
                </tr>
            @empty
                <tr><td colspan="5" style="padding:10px;">No movements found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:12px;">{{ $movements->links() }}</div>
</div>
@endsection
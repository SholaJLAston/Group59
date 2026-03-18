@extends('layouts.admin')

@section('title', 'Stock Movements')
@section('page-title', 'Stock Movements')

@section('content')
<div class="admin-container">

    @if(session('status'))<div style="margin-bottom:10px;color:#065f46;">{{ session('status') }}</div>@endif

    <form method="GET" action="{{ route('admin.inventory.movements') }}" class="admin-form-row" style="margin-bottom:12px;">
        <input class="admin-input" name="q" value="{{ request('q') }}" placeholder="Reference or product">
        <select class="admin-select" name="type">
            <option value="">All</option>
            <option value="in" {{ request('type')==='in' ? 'selected' : '' }}>IN</option>
            <option value="out" {{ request('type')==='out' ? 'selected' : '' }}>OUT</option>
        </select>
        <button type="submit" class="admin-btn admin-btn-dark">Filter</button>
    </form>

    <div class="admin-table-card">
        <table class="admin-table">
            <thead><tr><th>Date</th><th>Product</th><th>Type</th><th>Qty</th><th>Reference</th></tr></thead>
            <tbody>
            @forelse($movements as $move)
                <tr>
                    <td>{{ $move->created_at->format('d M Y H:i') }}</td>
                    <td>{{ $move->product->name ?? '-' }}</td>
                    <td>{{ strtoupper($move->type) }}</td>
                    <td>{{ $move->quantity }}</td>
                    <td>{{ $move->reference }}</td>
                </tr>
            @empty
                <tr><td colspan="5">No movements found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-wrap">{{ $movements->links('pagination::bootstrap-5') }}</div>
</div>
@endsection


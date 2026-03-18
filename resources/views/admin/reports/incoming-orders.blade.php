@extends('layouts.admin')

@section('title', 'Incoming Stock Report')
@section('page-title', 'Incoming Stock Report')

@section('content')
<div style="max-width:1200px;margin:0 auto;padding:28px 16px 50px;">
    <h1 style="margin:0 0 14px;">Incoming Stock Report</h1>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">
        <table style="width:100%;border-collapse:collapse;">
            <thead><tr><th style="padding:10px;text-align:left;">Date</th><th style="padding:10px;text-align:left;">Product</th><th style="padding:10px;text-align:left;">Qty</th><th style="padding:10px;text-align:left;">Reference</th></tr></thead>
            <tbody>
            @forelse($incoming as $entry)
                <tr>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">{{ $entry->created_at->format('d M Y H:i') }}</td>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">{{ $entry->product->name ?? '-' }}</td>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">{{ $entry->quantity }}</td>
                    <td style="padding:10px;border-top:1px solid #f1f5f9;">{{ $entry->reference }}</td>
                </tr>
            @empty
                <tr><td colspan="4" style="padding:10px;">No incoming stock records.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:12px;">{{ $incoming->links() }}</div>
</div>
@endsection


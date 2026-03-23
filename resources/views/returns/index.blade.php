@extends('layouts.app')

@section('title', 'My Returns')

@section('extra-css')
<style>
    .returns-page {
        background: #f4f4f4;
        min-height: calc(100vh - 200px);
        padding: 40px 16px 60px;
    }

    .returns-shell {
        max-width: 860px;
        margin: 0 auto;
    }

    .returns-heading {
        font-size: 24px;
        font-weight: 800;
        color: #111827;
        margin: 0 0 16px;
    }

    .returns-empty {
        background: #fff;
        border: 1px solid #e5e7eb;
        padding: 22px;
        color: #4b5563;
    }

    .return-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        padding: 16px 18px;
        margin-bottom: 12px;
    }

    .return-top {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 8px;
    }

    .return-order {
        font-size: 14px;
        font-weight: 700;
        color: #111827;
    }

    .return-meta {
        font-size: 13px;
        color: #6b7280;
    }

    .return-status {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 3px 10px;
        letter-spacing: 0.3px;
    }

    .return-status.pending { background: #fef3c7; color: #92400e; }
    .return-status.approved { background: #d1fae5; color: #065f46; }
    .return-status.rejected { background: #fee2e2; color: #991b1b; }

    .return-actions {
        margin-top: 10px;
    }

    .return-actions a {
        color: #d47c17;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
    }
</style>
@endsection

@section('content')
<div class="returns-page">
    <div class="returns-shell">
        <h1 class="returns-heading">My Returns</h1>

        @if (session('success'))
            <div style="background:#ecfdf3;border:1px solid #9ae6b4;color:#14532d;padding:10px 12px;margin-bottom:14px;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div style="background:#fff1f2;border:1px solid #fecdd3;color:#9f1239;padding:10px 12px;margin-bottom:14px;">
                {{ session('error') }}
            </div>
        @endif

        @if ($returns->isEmpty())
            <div class="returns-empty">
                You have not submitted any return requests yet.
            </div>
        @else
            @foreach ($returns as $return)
                <div class="return-card">
                    <div class="return-top">
                        <div>
                            <div class="return-order">Order {{ $return->order->order_number ?? ('#' . $return->order_id) }}</div>
                            <div class="return-meta">Requested on {{ $return->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        <span class="return-status {{ strtolower($return->status) }}">{{ ucfirst($return->status) }}</span>
                    </div>

                    <div class="return-meta">
                        Reason: {{ str_replace('_', ' ', ucfirst($return->reason)) }}
                    </div>

                    <div class="return-actions">
                        <a href="{{ route('returns.show', $return) }}">View details</a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection

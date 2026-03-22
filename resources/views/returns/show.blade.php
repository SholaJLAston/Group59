@extends('layouts.app')

@section('title', 'Return Request')

@section('extra-css')
<style>
    .return-detail-page {
        background: #f4f4f4;
        min-height: calc(100vh - 200px);
        padding: 40px 16px 60px;
    }

    .return-detail-shell {
        max-width: 820px;
        margin: 0 auto;
    }

    .return-detail-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #6b7280;
        font-size: 14px;
        text-decoration: none;
        margin-bottom: 16px;
    }

    .return-detail-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .return-detail-title {
        padding: 14px 18px;
        border-bottom: 1px solid #e5e7eb;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        color: #111827;
        background: #f9fafb;
    }

    .return-detail-body {
        padding: 16px 18px;
    }

    .row {
        margin-bottom: 10px;
        color: #374151;
        font-size: 14px;
    }

    .label {
        color: #6b7280;
        font-weight: 600;
        margin-right: 8px;
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
</style>
@endsection

@section('content')
<div class="return-detail-page">
    <div class="return-detail-shell">
        <a href="{{ route('returns.index') }}" class="return-detail-back">
            <i class="fas fa-arrow-left"></i> Back to My Returns
        </a>

        <div class="return-detail-card">
            <div class="return-detail-title">Return Request Details</div>
            <div class="return-detail-body">
                <div class="row">
                    <span class="label">Order:</span>
                    <a href="{{ route('order.show', $return->order) }}">{{ $return->order->order_number ?? ('#' . $return->order_id) }}</a>
                </div>

                <div class="row">
                    <span class="label">Status:</span>
                    <span class="return-status {{ strtolower($return->status) }}">{{ ucfirst($return->status) }}</span>
                </div>

                <div class="row">
                    <span class="label">Reason:</span>
                    {{ str_replace('_', ' ', ucfirst($return->reason)) }}
                </div>

                <div class="row">
                    <span class="label">Comments:</span>
                    {{ $return->comments ?: 'No additional comments provided.' }}
                </div>

                <div class="row" style="margin-bottom:0;">
                    <span class="label">Submitted:</span>
                    {{ $return->created_at->format('d M Y, H:i') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

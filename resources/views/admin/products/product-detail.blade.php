@extends('layouts.admin')

@section('title', $product->name)
@section('page-title', 'Product Detail')

@section('extra-css')
<style>
.detail-wrap{max-width:920px;margin:0 auto}
.detail-card{background:#fff;border:1px solid #e8e8e8;border-radius:22px;padding:22px}
.detail-head{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:16px}
.detail-title{margin:0;font-size:24px;font-weight:800;color:#111827}
.detail-grid{display:grid;grid-template-columns:96px 1fr;gap:16px;margin-bottom:14px}
.detail-image{width:96px;height:96px;border-radius:14px;object-fit:cover;border:1px solid #ececec;background:#f6f6f6}
.meta{display:grid;gap:8px}
.meta-row{font-size:15px;color:#1f2937}
.desc{margin-top:12px;padding-top:12px;border-top:1px solid #efefef;color:#374151;line-height:1.5}
.actions{display:flex;justify-content:flex-end;gap:10px;margin-top:16px}
.btn{padding:11px 16px;border-radius:12px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;border:1px solid transparent}
.btn-back{background:#fff;border-color:#e5e7eb;color:#374151}
.btn-back:hover{background:#f9fafb}
.btn-edit{background:#d88411;color:#fff}
.btn-edit:hover{background:#be730f}
</style>
@endsection

@section('content')
@php
    $detailRawImage = trim((string) $product->image_url);
    $detailImage = $detailRawImage === ''
        ? asset('images/logo.png')
        : (\Illuminate\Support\Str::startsWith($detailRawImage, ['http://', 'https://', '/'])
            ? $detailRawImage
            : asset(ltrim($detailRawImage, '/')));
@endphp
<div class="detail-wrap">
    <div class="detail-card">
        <div class="detail-head">
            <h1 class="detail-title">{{ $product->name }}</h1>
        </div>

        <div class="detail-grid">
            <img class="detail-image" src="{{ $detailImage }}" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='{{ asset('images/logo.png') }}';">
            <div class="meta">
                <div class="meta-row"><strong>Category:</strong> {{ $product->category->name ?? '-' }}</div>
                <div class="meta-row"><strong>Price:</strong> &pound;{{ number_format((float) $product->price, 2) }}</div>
                <div class="meta-row"><strong>Stock:</strong> {{ $product->stock_quantity }} ({{ $product->stock_status }})</div>
                <div class="meta-row"><strong>Low Stock Threshold:</strong> {{ $product->low_stock_threshold ?? 5 }}</div>
            </div>
        </div>

        <div class="desc">
            <strong>Description:</strong><br>{{ $product->description }}
        </div>

        <div class="actions">
            <a href="{{ route('admin.products.index') }}" class="btn btn-back">Back</a>
            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-edit">Edit Product</a>
        </div>
    </div>
</div>
@endsection



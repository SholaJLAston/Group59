@extends('layouts.app')

@section('title', 'Basket')

@section('content')
  <div class="container">
    <h1>Your Basket</h1>

    @if(session('status'))
      <div style="margin: 1rem 0; padding: .75rem 1rem; border-radius: 8px; background: #dcfce7; color: #166534;">
        {{ session('status') }}
      </div>
    @endif

    @if(session('error'))
      <div style="margin: 1rem 0; padding: .75rem 1rem; border-radius: 8px; background: #fee2e2; color: #991b1b;">
        {{ session('error') }}
      </div>
    @endif

    @if($items->isEmpty())
      <p>Your cart is empty for now. Start shopping!</p>
      <p><a href="{{ route('products') }}">Browse products</a></p>
    @else
      <div style="display: grid; gap: 12px; margin-top: 1.25rem;">
        @foreach($items as $item)
          <article style="display:flex; gap:12px; align-items:center; border:1px solid #e5e7eb; border-radius:12px; padding:12px;">
            <img
              src="{{ asset($item->product->image_url ?: 'images/placeholder.png') }}"
              alt="{{ $item->product->name }}"
              style="width:84px; height:84px; object-fit:cover; border-radius:8px;"
            >

            <div style="flex:1;">
              <h3 style="margin:0 0 .25rem 0;">{{ $item->product->name }}</h3>
              <p style="margin:0; color:#4b5563;">£{{ number_format($item->product->price, 2) }} each</p>
              <p style="margin:.25rem 0 0 0; color:#4b5563;">Subtotal: £{{ number_format($item->product->price * $item->quantity, 2) }}</p>
            </div>

            <form method="POST" action="{{ route('basket.update', $item) }}" style="display:flex; gap:8px; align-items:center;">
              @csrf
              @method('PATCH')
              <input
                type="number"
                name="quantity"
                min="1"
                max="99"
                value="{{ $item->quantity }}"
                style="width:72px;"
              >
              <button type="submit">Update</button>
            </form>

            <form method="POST" action="{{ route('basket.remove', $item) }}">
              @csrf
              @method('DELETE')
              <button type="submit">Remove</button>
            </form>
          </article>
        @endforeach
      </div>

      <div style="margin-top: 1.25rem; display:flex; justify-content:space-between; align-items:center; gap: 12px;">
        <strong>Total: £{{ number_format($total, 2) }}</strong>
        <div style="display:flex; gap: 10px;">
          <a href="{{ route('products') }}">Continue Shopping</a>
          <form method="POST" action="{{ route('basket.clear') }}">
            @csrf
            @method('DELETE')
            <button type="submit">Clear Basket</button>
          </form>
        </div>
      </div>
    @endif
  </div>
@endsection
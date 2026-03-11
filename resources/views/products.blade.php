<x-header />

<h1>Products Page</h1>

<form action="{{ route('products.index') }}" method="get">
    <label>Category:</label>
    <select name="cuisine">
        <option value="">All</option>
        <option value="tool">tool</option>
        <option value="electric">electric</option>
    </select>
    <input type="submit" value="apply filters"/>
</form>

@foreach ($products as $product)
    <div>
        <h3>{{ $product->name }}</h3>
        <p>£{{ number_format($product->price, 2) }}</p>

        <form method="POST" action="{{ route('basket.add', $product) }}">
            @csrf
            <button type="submit">Add to Basket</button>
        </form>
    </div>
@endforeach
@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="mb-8">
    <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">← Back to Products</a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div>
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full rounded-lg shadow-lg">
        @else
            <div class="w-full h-96 bg-gray-300 rounded-lg flex items-center justify-center">
                <span class="text-gray-600 text-xl">No Image Available</span>
            </div>
        @endif
    </div>

    <div class="card">
        <h1 class="text-4xl font-bold mb-4">{{ $product->name }}</h1>
        
        <div class="mb-6">
            <p class="text-3xl font-bold text-green-600">${{ number_format($product->price, 2) }}</p>
            @if($product->category)
                <a href="{{ route('categories.show', $product->category) }}" class="text-blue-600 hover:text-blue-800 text-lg">
                    Category: {{ $product->category->name }}
                </a>
            @endif
        </div>

        <div class="mb-6">
            <p class="text-gray-600 text-lg">SKU: <span class="font-semibold">{{ $product->sku }}</span></p>
            <p class="text-gray-600 text-lg">Stock: <span class="font-semibold">{{ $product->stock }} units</span></p>
            @if($product->isInStock())
                <span class="badge badge-success text-lg">In Stock</span>
            @else
                <span class="badge badge-danger text-lg">Out of Stock</span>
            @endif
        </div>

        <div class="mb-6">
            <h3 class="text-2xl font-bold mb-2">Description</h3>
            <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
        </div>

        @if($product->isInStock())
            <form action="{{ route('cart.add', $product) }}" method="POST" class="mb-4">
                @csrf
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" id="quantity" name="quantity" min="1" max="{{ $product->stock }}" value="1" class="form-input">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="btn btn-primary">
                            Add to Cart
                        </button>
                    </div>
                </div>
            </form>
        @endif

        @auth
            @if(Auth::user()->isAdmin())
                <div class="flex gap-2">
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-primary flex-1 text-center">
                        Edit Product
                    </a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-full" onclick="return confirm('Are you sure?')">
                            Delete Product
                        </button>
                    </form>
                </div>
            @endif
        @endauth
    </div>
</div>

@if(!$relatedProducts->isEmpty())
    <div class="mt-16">
        <h2 class="text-3xl font-bold mb-8">Related Products</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $related)
                <div class="product-card bg-white">
                    @if($related->image)
                        <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="product-image">
                    @else
                        <div class="product-image flex items-center justify-center">
                            <span class="text-gray-500">No Image</span>
                        </div>
                    @endif
                    
                    <div class="product-info">
                        <h3 class="product-name">{{ $related->name }}</h3>
                        <p class="product-price">${{ number_format($related->price, 2) }}</p>
                        
                        @if($related->isInStock())
                            <span class="badge badge-success">In Stock</span>
                        @else
                            <span class="badge badge-danger">Out of Stock</span>
                        @endif

                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('products.show', $related) }}" class="btn btn-primary flex-1 text-center">
                                View
                            </a>
                            @if($related->isInStock())
                                <form action="{{ route('cart.add', $related) }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-secondary w-full">
                                        Add
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
@endsection

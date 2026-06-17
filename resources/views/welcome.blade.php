@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg p-12 mb-12">
    <h1 class="text-5xl font-bold mb-4">Welcome to E-Shop</h1>
    <p class="text-xl mb-8">Discover amazing products at unbeatable prices</p>
    <a href="{{ route('products.index') }}" class="btn bg-white text-blue-600 hover:bg-gray-100 inline-block">
        Start Shopping
    </a>
</div>

<!-- Featured Categories -->
<div class="mb-12">
    <h2 class="text-3xl font-bold mb-8">Shop by Category</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
            $categories = \App\Models\Category::limit(3)->get();
        @endphp
        @forelse($categories as $category)
            <a href="{{ route('categories.show', $category) }}" class="card-hover">
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-48 object-cover rounded mb-4">
                @else
                    <div class="w-full h-48 bg-gray-300 rounded mb-4 flex items-center justify-center">
                        <span class="text-gray-600">No Image</span>
                    </div>
                @endif
                <h3 class="text-2xl font-bold">{{ $category->name }}</h3>
                <p class="text-gray-600">{{ $category->description }}</p>
            </a>
        @empty
            <p class="text-gray-600">No categories available</p>
        @endforelse
    </div>
</div>

<!-- Featured Products -->
<div class="mb-12">
    <h2 class="text-3xl font-bold mb-8">Featured Products</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $products = \App\Models\Product::limit(8)->get();
        @endphp
        @forelse($products as $product)
            <div class="product-card bg-white">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                @else
                    <div class="product-image flex items-center justify-center">
                        <span class="text-gray-500">No Image</span>
                    </div>
                @endif
                
                <div class="product-info">
                    <h3 class="product-name">{{ $product->name }}</h3>
                    <p class="product-price">${{ number_format($product->price, 2) }}</p>
                    
                    @if($product->isInStock())
                        <span class="badge badge-success">In Stock</span>
                    @else
                        <span class="badge badge-danger">Out of Stock</span>
                    @endif

                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('products.show', $product) }}" class="btn btn-primary flex-1 text-center">
                            View
                        </a>
                        @if($product->isInStock())
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
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
        @empty
            <p class="text-gray-600 col-span-full">No products available</p>
        @endforelse
    </div>
    <div class="text-center mt-8">
        <a href="{{ route('products.index') }}" class="btn btn-primary inline-block">
            View All Products
        </a>
    </div>
</div>

<!-- Info Section -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
    <div class="card text-center">
        <div class="text-4xl mb-4">🚚</div>
        <h3 class="text-xl font-bold mb-2">Free Shipping</h3>
        <p class="text-gray-600">On orders over $50</p>
    </div>
    <div class="card text-center">
        <div class="text-4xl mb-4">🔒</div>
        <h3 class="text-xl font-bold mb-2">Secure Payment</h3>
        <p class="text-gray-600">Your transactions are safe</p>
    </div>
    <div class="card text-center">
        <div class="text-4xl mb-4">↩️</div>
        <h3 class="text-xl font-bold mb-2">Easy Returns</h3>
        <p class="text-gray-600">30-day return policy</p>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Category')

@section('content')
<div class="mb-8">
    <a href="{{ route('categories.index') }}" class="text-blue-600 hover:text-blue-800">← Back to Categories</a>
</div>

<div class="mb-8">
    <h1 class="text-4xl font-bold mb-4">{{ $category->name }}</h1>
    <p class="text-gray-600 text-lg">{{ $category->description }}</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
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

                <p class="product-description mt-2">{{ Str::limit($product->description, 50) }}</p>
                
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
        <div class="col-span-full text-center py-12">
            <p class="text-gray-600 text-lg">No products in this category</p>
        </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $products->links() }}
</div>
@endsection

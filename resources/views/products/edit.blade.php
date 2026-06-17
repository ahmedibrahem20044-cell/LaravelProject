@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold mb-4">Edit Product</h1>
</div>

<div class="card max-w-2xl">
    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name" class="form-label">Product Name *</label>
            <input type="text" id="name" name="name" class="form-input" required value="{{ old('name', $product->name) }}">
            @error('name')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Description *</label>
            <textarea id="description" name="description" class="form-textarea" rows="5" required>{{ old('description', $product->description) }}</textarea>
            @error('description')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-group">
                <label for="price" class="form-label">Price *</label>
                <input type="number" id="price" name="price" step="0.01" min="0.01" class="form-input" required value="{{ old('price', $product->price) }}">
                @error('price')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="stock" class="form-label">Stock Quantity *</label>
                <input type="number" id="stock" name="stock" min="0" class="form-input" required value="{{ old('stock', $product->stock) }}">
                @error('stock')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-group">
                <label for="sku" class="form-label">SKU (Unique) *</label>
                <input type="text" id="sku" name="sku" class="form-input" required value="{{ old('sku', $product->sku) }}">
                @error('sku')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="category_id" class="form-label">Category *</label>
                <select id="category_id" name="category_id" class="form-input" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="image" class="form-label">Product Image</label>
            @if($product->image)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded">
                </div>
            @endif
            <input type="file" id="image" name="image" accept="image/*" class="form-input">
            @error('image')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
            <p class="text-gray-500 text-sm mt-2">Max size: 2MB (JPEG, PNG, JPG, GIF)</p>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="btn btn-primary flex-1">
                Update Product
            </button>
            <a href="{{ route('products.show', $product) }}" class="btn btn-secondary flex-1 text-center">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection

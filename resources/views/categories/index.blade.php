@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <h1 class="text-4xl font-bold">Categories</h1>
    @auth
        @if(Auth::user()->isAdmin())
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                Add Category
            </a>
        @endif
    @endauth
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($categories as $category)
        <div class="card-hover">
            @if($category->image)
                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-48 object-cover rounded mb-4">
            @else
                <div class="w-full h-48 bg-gray-300 rounded mb-4 flex items-center justify-center">
                    <span class="text-gray-600">No Image</span>
                </div>
            @endif
            
            <h3 class="text-2xl font-bold mb-2">{{ $category->name }}</h3>
            <p class="text-gray-600 mb-4">{{ $category->description }}</p>
            <p class="text-sm text-gray-500 mb-4">Products: {{ $category->products()->count() }}</p>
            
            <div class="flex gap-2">
                <a href="{{ route('categories.show', $category) }}" class="btn btn-primary flex-1 text-center">
                    View Products
                </a>
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-secondary flex-1 text-center">
                            Edit
                        </a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-full" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-600 text-lg">No categories found</p>
        </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $categories->links() }}
</div>
@endsection

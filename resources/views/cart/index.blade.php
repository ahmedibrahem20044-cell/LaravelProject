@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold mb-4">Shopping Cart</h1>
</div>

@if($cartItems->isEmpty())
    <div class="card text-center">
        <p class="text-gray-600 text-lg mb-4">Your cart is empty</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary inline-block">
            Continue Shopping
        </a>
    </div>
@else
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr>
                                <td class="font-semibold">{{ $item->product->name }}</td>
                                <td>${{ number_format($item->product->price, 2) }}</td>
                                <td>
                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="inline-flex">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-input w-20" onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td class="font-semibold">${{ number_format($item->getTotal(), 2) }}</td>
                                <td>
                                    <form action="{{ route('cart.remove', $item) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger text-sm px-2 py-1">
                                            Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <div class="card">
                <h3 class="text-xl font-bold mb-4">Order Summary</h3>
                
                <div class="flex justify-between mb-2">
                    <span>Subtotal:</span>
                    <span class="font-semibold">${{ number_format($total, 2) }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span>Shipping:</span>
                    <span class="font-semibold">$0.00</span>
                </div>
                <div class="flex justify-between mb-4 text-lg border-t pt-4">
                    <span>Total:</span>
                    <span class="font-bold">${{ number_format($total, 2) }}</span>
                </div>

                <a href="{{ route('orders.create') }}" class="btn btn-primary w-full text-center mb-2">
                    Proceed to Checkout
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary w-full text-center mb-2">
                    Continue Shopping
                </a>
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-full" onclick="return confirm('Are you sure?')">
                        Clear Cart
                    </button>
                </form>
            </div>
        </div>
    </div>
@endif
@endsection

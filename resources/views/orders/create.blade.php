@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold mb-4">Checkout</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2">
        <form action="{{ route('orders.store') }}" method="POST" class="card">
            @csrf
            
            <h2 class="text-2xl font-bold mb-6">Shipping Information</h2>
            
            <div class="form-group">
                <label for="shipping_address" class="form-label">Address *</label>
                <input type="text" id="shipping_address" name="shipping_address" class="form-input" required value="{{ old('shipping_address', Auth::user()->address ?? '') }}">
                @error('shipping_address')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                    <label for="city" class="form-label">City *</label>
                    <input type="text" id="city" name="city" class="form-input" required value="{{ old('city') }}">
                    @error('city')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="postal_code" class="form-label">Postal Code *</label>
                    <input type="text" id="postal_code" name="postal_code" class="form-input" required value="{{ old('postal_code') }}">
                    @error('postal_code')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <h2 class="text-2xl font-bold mb-6 mt-8">Payment Method</h2>
            
            <div class="space-y-4 mb-8">
                <div class="flex items-center">
                    <input type="radio" id="credit_card" name="payment_method" value="credit_card" class="mr-3" required checked>
                    <label for="credit_card" class="cursor-pointer">Credit Card</label>
                </div>
                <div class="flex items-center">
                    <input type="radio" id="debit_card" name="payment_method" value="debit_card" class="mr-3" required>
                    <label for="debit_card" class="cursor-pointer">Debit Card</label>
                </div>
                <div class="flex items-center">
                    <input type="radio" id="paypal" name="payment_method" value="paypal" class="mr-3" required>
                    <label for="paypal" class="cursor-pointer">PayPal</label>
                </div>
            </div>

            @error('payment_method')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror

            <button type="submit" class="btn btn-primary w-full">
                Place Order
            </button>
        </form>
    </div>

    <div>
        <div class="card sticky top-24">
            <h3 class="text-xl font-bold mb-6">Order Summary</h3>
            
            <div class="space-y-4 mb-6 max-h-96 overflow-y-auto">
                @foreach($cartItems as $item)
                    <div class="flex justify-between pb-4 border-b">
                        <div>
                            <p class="font-semibold">{{ $item->product->name }}</p>
                            <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
                        </div>
                        <p class="font-semibold">${{ number_format($item->getTotal(), 2) }}</p>
                    </div>
                @endforeach
            </div>

            <div class="border-t pt-4">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Subtotal:</span>
                    <span>${{ number_format($cartItems->sum(fn($item) => $item->getTotal()), 2) }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Shipping:</span>
                    <span>$0.00</span>
                </div>
                <div class="flex justify-between text-lg font-bold border-t pt-4 mt-4">
                    <span>Total:</span>
                    <span class="text-green-600">${{ number_format($cartItems->sum(fn($item) => $item->getTotal()), 2) }}</span>
                </div>
            </div>

            <a href="{{ route('cart.index') }}" class="btn btn-secondary w-full text-center mt-4">
                Back to Cart
            </a>
        </div>
    </div>
</div>
@endsection

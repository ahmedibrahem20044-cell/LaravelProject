@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="mb-8">
    <a href="{{ route('orders.index') }}" class="text-blue-600 hover:text-blue-800">← Back to Orders</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2">
        <div class="card mb-6">
            <h2 class="text-2xl font-bold mb-4">Order #{{ $order->id }}</h2>
            
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-gray-600">Order Date</p>
                    <p class="font-semibold">{{ $order->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Status</p>
                    <p class="font-semibold">
                        @switch($order->status)
                            @case('pending')
                                <span class="badge badge-warning">Pending</span>
                                @break
                            @case('processing')
                                <span class="badge badge-info">Processing</span>
                                @break
                            @case('shipped')
                                <span class="badge badge-info">Shipped</span>
                                @break
                            @case('delivered')
                                <span class="badge badge-success">Delivered</span>
                                @break
                            @case('cancelled')
                                <span class="badge badge-danger">Cancelled</span>
                                @break
                        @endswitch
                    </p>
                </div>
                <div>
                    <p class="text-gray-600">Payment Method</p>
                    <p class="font-semibold">{{ ucfirst($order->payment_method) }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Total Amount</p>
                    <p class="font-semibold text-xl text-green-600">${{ number_format($order->total_amount, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="card mb-6">
            <h3 class="text-xl font-bold mb-4">Shipping Address</h3>
            @php
                $address = json_decode($order->shipping_address);
            @endphp
            <p class="text-gray-700">{{ $address->address }}</p>
            <p class="text-gray-700">{{ $address->city }}, {{ $address->postal_code }}</p>
        </div>

        <div class="card">
            <h3 class="text-xl font-bold mb-4">Order Items</h3>
            <div class="overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <a href="{{ route('products.show', $item->product) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                        {{ $item->product->name }}
                                    </a>
                                </td>
                                <td>${{ number_format($item->unit_price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="font-semibold">${{ number_format($item->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div>
        <div class="card">
            <h3 class="text-xl font-bold mb-4">Order Summary</h3>
            
            <div class="space-y-2 mb-4">
                @foreach($order->items as $item)
                    <div class="flex justify-between text-sm">
                        <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                        <span>${{ number_format($item->total, 2) }}</span>
                    </div>
                @endforeach
            </div>
            
            <div class="border-t pt-4">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Subtotal:</span>
                    <span>${{ number_format($order->total_amount, 2) }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Shipping:</span>
                    <span>$0.00</span>
                </div>
                <div class="flex justify-between text-lg font-bold border-t pt-2">
                    <span>Total:</span>
                    <span class="text-green-600">${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <a href="{{ route('products.index') }}" class="btn btn-primary w-full text-center mt-4">
                Continue Shopping
            </a>
        </div>
    </div>
</div>
@endsection

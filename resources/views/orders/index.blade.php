@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold mb-4">My Orders</h1>
</div>

@if($orders->isEmpty())
    <div class="card text-center">
        <p class="text-gray-600 text-lg mb-4">You haven't placed any orders yet</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary inline-block">
            Start Shopping
        </a>
    </div>
@else
    <div class="card overflow-x-auto">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td class="font-semibold">#{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="font-semibold">${{ number_format($order->total_amount, 2) }}</td>
                        <td>
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
                        </td>
                        <td>
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-primary text-sm">
                                View Details
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $orders->links() }}
    </div>
@endif
@endsection

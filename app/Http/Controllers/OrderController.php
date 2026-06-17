<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $this->authorize('view', $order);
        return view('orders.show', compact('order'));
    }

    public function create(): View
    {
        $cartItems = Auth::user()->cart()->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty');
        }

        return view('orders.create', compact('cartItems'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'payment_method' => 'required|in:credit_card,debit_card,paypal',
        ]);

        return DB::transaction(function () use ($validated) {
            $user = Auth::user();
            $cartItems = $user->cart()->with('product')->get();

            if ($cartItems->isEmpty()) {
                throw new \Exception('Cart is empty');
            }

            $totalAmount = $cartItems->sum(fn($item) => $item->getTotal());

            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'pending',
                'total_amount' => $totalAmount,
                'shipping_address' => json_encode([
                    'address' => $validated['shipping_address'],
                    'city' => $validated['city'],
                    'postal_code' => $validated['postal_code'],
                ]),
                'payment_method' => $validated['payment_method'],
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product->price,
                    'total' => $item->getTotal(),
                ]);

                // Decrease stock
                $item->product->decrement('stock', $item->quantity);
            }

            $user->cart()->delete();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Order placed successfully');
        });
    }
}

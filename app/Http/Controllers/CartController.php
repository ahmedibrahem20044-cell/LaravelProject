<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $cartItems = Auth::user()->cart()->with('product')->get();
        $total = $cartItems->sum(fn($item) => $item->getTotal());
        
        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Product $product, Request $request): RedirectResponse
    {
        $quantity = $request->input('quantity', 1);

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->update(['quantity' => $cartItem->quantity + $quantity]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        return back()->with('success', 'Product added to cart');
    }

    public function update(Cart $cartItem, Request $request): RedirectResponse
    {
        $this->authorize('update', $cartItem);
        
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->update($validated);

        return back()->with('success', 'Cart updated');
    }

    public function remove(Cart $cartItem): RedirectResponse
    {
        $this->authorize('delete', $cartItem);
        $cartItem->delete();

        return back()->with('success', 'Item removed from cart');
    }

    public function clear(): RedirectResponse
    {
        Auth::user()->cart()->delete();
        return redirect()->route('cart.index')->with('success', 'Cart cleared');
    }
}

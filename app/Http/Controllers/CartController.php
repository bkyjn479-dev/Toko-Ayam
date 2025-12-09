<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        if (auth()->user() && method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Akun admin tidak memiliki akses ke keranjang.');
        }

        $cartItems = auth()->user()->cartItems()->with('product')->get();
        $total = $cartItems->sum(fn($item) => $item->quantity * $item->price);
        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        if (auth()->user() && method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin()) {
            return back()->with('error', 'Akun admin tidak diperbolehkan menambahkan produk ke keranjang.');
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($product->stock < $validated['quantity']) {
            return back()->with('error', 'Stok tidak cukup!');
        }

        $cartItem = auth()->user()->cartItems()
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $validated['quantity'],
            ]);
        } else {
            auth()->user()->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
                'price' => $product->price,
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        if (auth()->user() && method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin()) {
            return back()->with('error', 'Akun admin tidak memiliki akses ke keranjang.');
        }

        if ($cartItem->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($cartItem->product->stock < $validated['quantity']) {
            return back()->with('error', 'Stok tidak cukup!');
        }

        $cartItem->update($validated);

        return back()->with('success', 'Cart updated!');
    }

    public function remove(CartItem $cartItem)
    {
        if (auth()->user() && method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin()) {
            return back()->with('error', 'Akun admin tidak memiliki akses ke keranjang.');
        }

        if ($cartItem->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->delete();

        return back()->with('success', 'Item removed from cart!');
    }

    public function clear()
    {
        if (auth()->user() && method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin()) {
            return back()->with('error', 'Akun admin tidak memiliki akses ke keranjang.');
        }

        auth()->user()->cartItems()->delete();
        return back()->with('success', 'Cart cleared!');
    }
}

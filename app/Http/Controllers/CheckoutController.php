<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        if (auth()->user() && method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Akun admin tidak diperbolehkan melakukan checkout.');
        }

        $cartItems = auth()->user()->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->price);

        return view('checkout.index', compact('cartItems', 'subtotal'));
    }

    public function store(Request $request)
    {
        if (auth()->user() && method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin()) {
            return back()->with('error', 'Akun admin tidak diperbolehkan melakukan checkout.');
        }

        $validated = $request->validate([
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'shipping_method' => 'required|in:pickup,courier,delivery',
            'payment_method' => 'required|in:transfer,qris',
        ]);

        $cartItems = auth()->user()->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang kosong!');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->price);
        
        // Hitung biaya pengiriman
        $shippingCost = match($validated['shipping_method']) {
            'pickup' => 0,
            'courier' => 50000,
            'delivery' => 75000,
            default => 0
        };

        $total = $subtotal + $shippingCost;

        try {
            DB::beginTransaction();

            // Buat order
            $orderNumber = 'ORD-' . date('YmdHis') . '-' . auth()->id();
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => $orderNumber,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
            ]);

            // Buat order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);

                // Update stok product
                $item->product->decrement('stock', $item->quantity);
            }

            // Buat shipment
            Shipment::create([
                'order_id' => $order->id,
                'recipient_name' => auth()->user()->name,
                'recipient_phone' => $validated['phone'],
                'recipient_address' => $validated['address'],
                'recipient_city' => $validated['city'],
                'shipping_method' => $validated['shipping_method'],
            ]);

            // Buat payment record
            $payment = Payment::create([
                'order_id' => $order->id,
                'method' => $validated['payment_method'],
                'status' => 'pending',
                'amount' => $total,
            ]);

            // Hapus cart items
            auth()->user()->cartItems()->delete();

            DB::commit();

            return redirect()->route('checkout.payment', $order->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function payment(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('payment');

        if ($order->payment_method === 'transfer') {
            // Set bank account details (bisa dari config atau database)
            $order->payment->bank_account = json_encode([
                'bank' => 'BCA',
                'account_number' => '1234567890',
                'account_name' => 'Stock Wings',
            ]);
            $order->payment->save();
        } else {
            // Generate QRIS (dalam praktik, gunakan library QRIS yang sebenarnya)
            $order->payment->qris_code = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=QRIS' . $order->order_number;
            $order->payment->save();
        }

        return view('checkout.payment', compact('order'));
    }

    public function uploadProof(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->payment_method !== 'transfer') {
            return back()->with('error', 'Hanya untuk metode transfer!');
        }

        $validated = $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('proof_image')) {
            $path = $request->file('proof_image')->store('proofs', 'public');
            $order->payment->update([
                'proof_image' => $path,
                'status' => 'pending', // Admin akan verifikasi
            ]);
        }

        return back()->with('success', 'Bukti transfer berhasil diupload. Menunggu verifikasi admin.');
    }

    public function orders()
    {
        $orders = auth()->user()->orders()->with('items', 'payment')->latest()->paginate(10);
        return view('checkout.orders', compact('orders'));
    }

    public function orderDetail(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items', 'shipment', 'payment');
        $shipment = $order->shipment;
        $payment = $order->payment;
        return view('checkout.order-detail', compact('order', 'shipment', 'payment'));
    }
}

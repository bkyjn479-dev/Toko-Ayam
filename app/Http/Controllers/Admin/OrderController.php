<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'items')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'items', 'shipment', 'payment');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
        ]);

        $order->update($validated);

        return back()->with('success', 'Order status updated successfully!');
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        $order->update($validated);
        
        if ($order->payment) {
            $order->payment->update(['status' => $validated['payment_status']]);
        }

        return back()->with('success', 'Payment status updated successfully!');
    }

    public function updateShipment(Request $request, Order $order)
    {
        $validated = $request->validate([
            'tracking_number' => 'nullable|string',
            'shipped_at' => 'nullable|date',
        ]);

        $shipment = $order->shipment ?? $order->shipment()->create([
            'recipient_name' => $order->user->name,
            'recipient_phone' => $order->user->phone,
            'recipient_address' => $order->user->address,
            'recipient_city' => $order->user->city,
            'shipping_method' => 'courier',
        ]);

        $shipment->update($validated);

        return back()->with('success', 'Shipment updated successfully!');
    }
}

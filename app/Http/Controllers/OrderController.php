<?php
// app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders for admin.
     */
    public function index()
    {
        // Проверка прав администратора
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Доступ запрещен');
        }

        $orders = Order::latest()->get();
        
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Update the order status.
     */
    public function updateStatus(Request $request, $orderId)
    {
        // Проверка прав администратора
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Доступ запрещен');
        }

        $order = Order::findOrFail($orderId);
        
        $request->validate([
            'status' => 'required|in:new,in_progress,completed,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Статус заказа обновлен');
    }

    /**
     * Show the form for creating a new order.
     */
    public function checkout()
    {
        return view('orders.checkout');
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        // Логика создания заказа
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string',
            'payment_method' => 'required|string',
            'delivery_method' => 'required|string',
            'total_amount' => 'required|numeric',
        ]);

        $order = Order::create([
            'order_number' => 'ORD-' . time(),
            'user_id' => auth()->id(),
            ...$validated,
            'status' => 'new'
        ]);

        return redirect()->route('order.success', $order->id);
    }

    /**
     * Display order success page.
     */
    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('orders.success', compact('order'));
    }
}
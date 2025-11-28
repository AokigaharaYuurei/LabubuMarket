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
    // app/Http/Controllers/OrderController.php

public function checkout()
{
    // Получим корзину и посчитаем общую сумму
    $cart = session()->get('cart', []);
    $total = 0;
    
    foreach ($cart as $productId => $quantity) {
        $product = \App\Models\Product::find($productId);
        if ($product) {
            $total += $product->price * $quantity;
        }
    }
    
    return view('orders.checkout', compact('total'));
}

    /**
     * Store a newly created order.
     */
     public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string',
            'payment_method' => 'required|string|in:card,cash,online',
            'delivery_method' => 'required|string|in:delivery,pickup',
            'total_amount' => 'required|numeric|min:0',
        ]);

        // Создаем заказ
        $order = Order::create([
            'order_number' => 'ORD-' . time() . rand(100, 999),
            'user_id' => auth()->id(),
            'customer_name' => $validated['customer_name'],
            'address' => $validated['address'],
            'payment_method' => $validated['payment_method'],
            'delivery_method' => $validated['delivery_method'],
            'total_amount' => $validated['total_amount'],
            'status' => 'new',
        ]);

        // Очищаем корзину после оформления заказа
        session()->forget('cart');

        return redirect()->route('order.success', $order->id);
    }

    /**
     * Display order success page
     */
    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('orders.success', compact('order'));
    }
    /**
     * Display order success page.
     */

}
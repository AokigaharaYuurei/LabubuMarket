<?php
// app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display checkout form
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);
        $productsTotal = 0;
        
        foreach ($cart as $productId => $quantity) {
            $product = \App\Models\Product::find($productId);
            if ($product) {
                $productsTotal += $product->price * $quantity;
            }
        }

        // Стоимость доставки
        $deliveryCost = 300; // Базовая стоимость доставки
        $total = $productsTotal + $deliveryCost;
        
        return view('orders.checkout', compact('productsTotal', 'deliveryCost', 'total'));
    }

    /**
     * Store a new order
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string',
            'payment_method' => 'required|string|in:card,cash,online',
            'delivery_method' => 'required|string|in:delivery,pickup',
        ]);

        // Рассчитываем итоговую сумму
        $cart = session()->get('cart', []);
        $productsTotal = 0;
        
        foreach ($cart as $productId => $quantity) {
            $product = \App\Models\Product::find($productId);
            if ($product) {
                $productsTotal += $product->price * $quantity;
            }
        }

        // Стоимость доставки (бесплатно для самовывоза)
        $deliveryCost = ($request->delivery_method == 'delivery') ? 300 : 0;
        $totalAmount = $productsTotal + $deliveryCost;

        // Создаем заказ
        $order = Order::create([
            'order_number' => 'ORD-' . time() . rand(100, 999),
            'user_id' => auth()->id(),
            'customer_name' => $validated['customer_name'],
            'address' => $validated['address'],
            'payment_method' => $validated['payment_method'],
            'delivery_method' => $validated['delivery_method'],
            'total_amount' => $totalAmount,
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
     * Display orders for admin/seller
     */
    public function index()
    {
        // Проверка прав администратора или продавца
        if (!auth()->user()->isAdminOrSeller()) {
            abort(403, 'Доступ запрещен');
        }

        $orders = Order::latest()->get();
        $userRole = auth()->user()->role;
        
        return view('admin.orders.index', compact('orders', 'userRole'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, $orderId)
    {
        // Проверка прав администратора или продавца
        if (!auth()->user()->isAdminOrSeller()) {
            abort(403, 'Доступ запрещен');
        }

        $order = Order::findOrFail($orderId);
        $userRole = auth()->user()->role;
        
        // Разные правила валидации для админа и продавца
        if ($userRole === 'admin') {
            $request->validate([
                'status' => 'required|in:new,in_progress,completed,cancelled'
            ]);
        } elseif ($userRole === 'seller') {
            $request->validate([
                'status' => 'required|in:in_progress,cancelled'
            ]);
            
            // Продавец не может менять статус "new" на "completed"
            if ($request->status === 'completed') {
                return redirect()->back()->with('error', 'Продавец не может завершать заказы');
            }
        }

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Статус заказа обновлен');
    }
}
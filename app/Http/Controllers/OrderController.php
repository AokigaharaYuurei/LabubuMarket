<?php
// app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('basket.index')->with('error', 'Корзина пуста');
        }

        $products = [];
        $productsTotal = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $product->quantity = $quantity;
                $products[] = $product;
                $productsTotal += $product->price * $quantity;
            }
        }

        return view('checkout', compact('products', 'productsTotal'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('basket.index')->with('error', 'Корзина пуста');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'payment_method' => 'required|in:МИР,VISA,MASTERCARD',
            'delivery_method' => 'required|in:courier,pickup,post'
        ]);

        // Рассчитываем стоимость доставки
        $deliveryCost = $this->calculateDeliveryCost($validated['delivery_method']);
        
        // Собираем информацию о товарах
        $products = [];
        $productsTotal = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $products[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity
                ];
                $productsTotal += $product->price * $quantity;
            }
        }

        $totalAmount = $productsTotal + $deliveryCost;

        try {
            DB::beginTransaction();

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'customer_name' => $validated['customer_name'],
                'address' => $validated['address'],
                'payment_method' => $validated['payment_method'],
                'delivery_method' => $validated['delivery_method'],
                'products_total' => $productsTotal,
                'delivery_cost' => $deliveryCost,
                'total_amount' => $totalAmount,
                'order_items' => $products,
                'status' => 'new'
            ]);

            DB::commit();

            // Очищаем корзину после создания заказа
            session()->forget('cart');

            return redirect()->route('order.success', $order->id)
                ->with('success', 'Заказ успешно оформлен!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ошибка при оформлении заказа: ' . $e->getMessage());
        }
    }

    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('order-success', compact('order'));
    }

    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        
        $request->validate([
            'status' => 'required|in:new,in_progress,completed,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Статус заказа обновлен');
    }

    private function calculateDeliveryCost($deliveryMethod)
    {
        return match($deliveryMethod) {
            'courier' => 300.00,
            'post' => 200.00,
            'pickup' => 0.00,
            default => 0.00
        };
    }
}
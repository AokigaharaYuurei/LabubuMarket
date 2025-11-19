<!DOCTYPE html>
<!-- resources/views/admin/orders/index.blade.php -->
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление заказами - ЛАБУБУ.МАРКЕТ</title>
    <style>
        .container { max-width: 1200px; margin: 0 auto; padding: 2rem; }
        .order-card { background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; margin-bottom: 1rem; }
        .status-new { background: #dbeafe; color: #1e40af; }
        .status-in_progress { background: #fef3c7; color: #92400e; }
        .status-completed { background: #d1fae5; color: #065f46; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Управление заказами</h1>
        
        @foreach($orders as $order)
            <div class="order-card">
                <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 1rem;">
                    <h3>Заказ #{{ $order->order_number }}</h3>
                    <span class="status-{{ $order->status }}" style="padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.875rem;">
                        {{ $order->status_label }}
                    </span>
                </div>
                
                <p><strong>Клиент:</strong> {{ $order->customer_name }}</p>
                <p><strong>Адрес:</strong> {{ $order->address }}</p>
                <p><strong>Оплата:</strong> {{ $order->payment_method }}</p>
                <p><strong>Доставка:</strong> {{ $order->delivery_method_label }}</p>
                <p><strong>Сумма:</strong> {{ number_format($order->total_amount, 0, ',', ' ') }} ₽</p>
                
                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" style="margin-top: 1rem;">
                    @csrf
                    @method('PATCH')
                    <select name="status">
                        <option value="new" {{ $order->status == 'new' ? 'selected' : '' }}>Новая</option>
                        <option value="in_progress" {{ $order->status == 'in_progress' ? 'selected' : '' }}>В работе</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Завершена</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Отменена</option>
                    </select>
                    <button type="submit">Обновить статус</button>
                </form>
            </div>
        @endforeach
    </div>
</body>
</html>
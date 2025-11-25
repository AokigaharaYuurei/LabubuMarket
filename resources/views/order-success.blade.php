<!DOCTYPE html>
<!-- resources/views/order-success.blade.php -->
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ оформлен - ЛАБУБУ.МАРКЕТ</title>
    <style>
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .order-details {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
            background: #f9fafb;
            border-radius: 8px;
        }
        .order-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }
        .total {
            font-size: 1.25rem;
            font-weight: bold;
            color: #059669;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px solid #e5e7eb;
        }
        .button {
            display: inline-block;
            padding: 1rem 2rem;
            background: #3b82f6;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="{{ route('products.index') }}">
            <h1>ЛАБУБУ.МАРКЕТ</h1>
        </a>
    </header>

    <main style="max-width: 800px; margin: 2rem auto; padding: 0 2rem;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <h2 style="color: #059669;">Заказ успешно оформлен!</h2>
            <p>Спасибо за ваш заказ! Мы свяжемся с вами в ближайшее время.</p>
        </div>

        <div class="order-details">
            <h3>Информация о заказе</h3>
            <p><strong>Номер заказа:</strong> {{ $order->order_number }}</p>
            <p><strong>Статус:</strong> {{ $order->status_label }}</p>
            <p><strong>Имя клиента:</strong> {{ $order->customer_name }}</p>
            <p><strong>Адрес доставки:</strong> {{ $order->address }}</p>
            <p><strong>Способ оплаты:</strong> {{ $order->payment_method }}</p>
            <p><strong>Способ доставки:</strong> {{ $order->delivery_method_label }}</p>

            <h4 style="margin-top: 2rem;">Состав заказа:</h4>
            @foreach($order->order_items as $item)
                <div class="order-item">
                    <span>{{ $item['name'] }} × {{ $item['quantity'] }}</span>
                    <span>{{ number_format($item['subtotal'], 0, ',', ' ') }} ₽</span>
                </div>
            @endforeach

            <div class="order-item">
                <span>Стоимость товаров:</span>
                <span>{{ number_format($order->products_total, 0, ',', ' ') }} ₽</span>
            </div>

            <div class="order-item">
                <span>Доставка:</span>
                <span>{{ number_format($order->delivery_cost, 0, ',', ' ') }} ₽</span>
            </div>

            <div class="total">
                <span>Итого:</span>
                <span>{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</span>
            </div>
        </div>

        <div style="text-align: center; margin-top: 2rem;">
            <a href="{{ route('products.index') }}" class="button">
                Вернуться к покупкам
            </a>
        </div>
    </main>
</body>
</html>
<!DOCTYPE html>
<!-- resources/views/order-success.blade.php -->
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ оформлен - ЛАБУБУ.МАРКЕТ</title>
</head>
<body>
    <header class="header">
        <a href="{{ route('products.index') }}">
            <h1>ЛАБУБУ.МАРКЕТ</h1>
        </a>
    </header>

    <main style="max-width: 600px; margin: 2rem auto; padding: 0 2rem; text-align: center;">
        <h2>Заказ успешно оформлен!</h2>
        <p>Номер вашего заказа: <strong>{{ $order->order_number }}</strong></p>
        <p>Статус: <strong>{{ $order->status_label }}</strong></p>
        <p>Общая сумма: <strong>{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</strong></p>
        
        <div style="margin: 2rem 0;">
            <a href="{{ route('products.index') }}" style="display: inline-block; padding: 1rem 2rem; background: #3b82f6; color: white; text-decoration: none; border-radius: 8px;">
                Вернуться к покупкам
            </a>
        </div>
    </main>
</body>
</html>
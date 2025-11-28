<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ оформлен - ЛАБУБУ.МАРКЕТ</title>
    <style>
        .container { max-width: 600px; margin: 0 auto; padding: 2rem; text-align: center; }
        .success-icon { color: #10b981; font-size: 4rem; margin-bottom: 1rem; }
        .btn { display: inline-block; background: #4f46e5; color: white; padding: 0.75rem 1.5rem; border-radius: 4px; text-decoration: none; margin: 0.5rem; }
        .order-details { background: #f9fafb; padding: 1.5rem; border-radius: 8px; margin: 2rem 0; text-align: left; }
        .status-new { color: #1e40af; }
        .status-in_progress { color: #92400e; }
        .status-completed { color: #065f46; }
        .status-cancelled { color: #991b1b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon">✓</div>
        <h1>Заказ успешно оформлен!</h1>
        <p>Спасибо за ваш заказ. Мы свяжемся с вами в ближайшее время.</p>

        @if(isset($order))
        <div class="order-details">
            <h3>Детали заказа:</h3>
            <p><strong>Номер заказа:</strong> #{{ $order->order_number }}</p>
            <p><strong>Имя:</strong> {{ $order->customer_name }}</p>
            <p><strong>Адрес:</strong> {{ $order->address }}</p>
            <p><strong>Способ оплаты:</strong> 
                @if($order->payment_method == 'card')
                    Банковская карта
                @elseif($order->payment_method == 'cash')
                    Наличные при получении
                @elseif($order->payment_method == 'online')
                    Онлайн-оплата
                @else
                    {{ $order->payment_method }}
                @endif
            </p>
            <p><strong>Способ получения:</strong> 
                @if($order->delivery_method == 'delivery')
                    Доставка
                @else
                    Самовывоз
                @endif
            </p>
            <p><strong>Сумма:</strong> {{ number_format($order->total_amount, 0, ',', ' ') }} ₽</p>
            <p><strong>Статус:</strong> 
                <span class="status-{{ $order->status }}">
                    @if($order->status == 'new')
                        Новая
                    @elseif($order->status == 'in_progress')
                        В работе
                    @elseif($order->status == 'completed')
                        Завершена
                    @elseif($order->status == 'cancelled')
                        Отменена
                    @else
                        {{ $order->status }}
                    @endif
                </span>
            </p>
        </div>
        @endif

        <div>
            <a href="{{ url('/') }}" class="btn">Вернуться на главную</a>
            <a href="{{ route('products.index') }}" class="btn" style="background: #6b7280;">Продолжить покупки</a>
            
            {{-- Безопасная проверка роли --}}
            @auth
                @php
                    $user = auth()->user();
                    $isAdminOrSeller = ($user->role === 'admin' || $user->role === 'seller');
                @endphp
                
                @if($isAdminOrSeller)
                    <a href="{{ route('admin.orders.index') }}" class="btn" style="background: #059669;">Панель управления</a>
                @endif
            @endauth
        </div>
    </div>
</body>
</html>
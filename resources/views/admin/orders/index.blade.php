<!DOCTYPE html>
<!-- resources/views/admin/orders/index.blade.php -->
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if(auth()->user()->isAdmin())
            Управление заказами - ЛАБУБУ.МАРКЕТ
        @else
            Мои заказы - ЛАБУБУ.МАРКЕТ
        @endif
    </title>
    <style>
        .container { max-width: 1200px; margin: 0 auto; padding: 2rem; }
        .order-card { background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; margin-bottom: 1rem; }
        .status-new { background: #dbeafe; color: #1e40af; }
        .status-in_progress { background: #fef3c7; color: #92400e; }
        .status-completed { background: #d1fae5; color: #065f46; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
        .alert { padding: 1rem; margin-bottom: 1rem; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .nav { display: flex; gap: 1rem; margin-bottom: 2rem; }
        .nav a { padding: 0.5rem 1rem; background: #f3f4f6; border-radius: 4px; text-decoration: none; color: #374151; }
        .nav a.active { background: #4f46e5; color: white; }
        .role-badge { 
            display: inline-block; 
            padding: 0.25rem 0.75rem; 
            border-radius: 20px; 
            font-size: 0.875rem; 
            margin-left: 1rem;
        }
        .role-admin { background: #4f46e5; color: white; }
        .role-seller { background: #059669; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1>
                @if(auth()->user()->isAdmin())
                    Управление заказами
                @else
                    Мои заказы
                @endif
            </h1>
            <span class="role-badge role-{{ auth()->user()->role }}">
                {{ auth()->user()->isAdmin() ? 'Администратор' : 'Продавец' }}
            </span>
        </div>

        @if(auth()->user()->isAdmin())
        <div class="nav">
            <a href="{{ route('admin.orders.index') }}" class="active">Заказы</a>
            <a href="{{ route('admin.users.index') }}">Пользователи</a>
        </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif
        
        @foreach($orders as $order)
            <div class="order-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
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
                <p><strong>Дата создания:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
                
                @if(auth()->user()->isAdminOrSeller())
                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" style="margin-top: 1rem;">
                        @csrf
                        @method('PATCH')
                        <select name="status">
                            @if(auth()->user()->isAdmin())
                                <!-- Администратор видит все статусы -->
                                <option value="new" {{ $order->status == 'new' ? 'selected' : '' }}>Новая</option>
                                <option value="in_progress" {{ $order->status == 'in_progress' ? 'selected' : '' }}>В работе</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Завершена</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Отменена</option>
                            @elseif(auth()->user()->isSeller())
                                <!-- Продавец видит только "В работе" и "Отменена" -->
                                <option value="in_progress" {{ $order->status == 'in_progress' ? 'selected' : '' }}>В работе</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Отменена</option>
                            @endif
                        </select>
                        <button type="submit">Обновить статус</button>
                    </form>
                @endif
            </div>
        @endforeach

        @if($orders->isEmpty())
            <p>Заказов пока нет.</p>
        @endif
    </div>
</body>
</html>
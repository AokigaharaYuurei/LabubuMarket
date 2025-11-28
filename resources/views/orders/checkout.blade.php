<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформление заказа - ЛАБУБУ.МАРКЕТ</title>
    <style>
        .container { max-width: 600px; margin: 0 auto; padding: 2rem; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; }
        .btn { background: #4f46e5; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #4338ca; }
        .alert { padding: 1rem; margin-bottom: 1rem; border-radius: 4px; }
        .alert-error { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Оформление заказа</h1>

        @if($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('order.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="customer_name">Имя и фамилия *</label>
                <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name', auth()->user()->name ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="address">Адрес доставки *</label>
                <textarea id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
            </div>

            <div class="form-group">
                <label for="payment_method">Способ оплаты *</label>
                <select id="payment_method" name="payment_method" required>
                    <option value="">Выберите способ оплаты</option>
                    <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Банковская карта</option>
                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Наличные при получении</option>
                    <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>Онлайн-оплата</option>
                </select>
            </div>

            <div class="form-group">
                <label for="delivery_method">Способ получения *</label>
                <select id="delivery_method" name="delivery_method" required>
                    <option value="">Выберите способ получения</option>
                    <option value="delivery" {{ old('delivery_method') == 'delivery' ? 'selected' : '' }}>Доставка</option>
                    <option value="pickup" {{ old('delivery_method') == 'pickup' ? 'selected' : '' }}>Самовывоз</option>
                </select>
            </div>

            <div class="form-group">
                <label for="total_amount">Сумма заказа *</label>
                <input type="number" id="total_amount" name="total_amount" value="{{ old('total_amount', $total ?? 1000) }}" step="0.01" required>
            </div>

            <button type="submit" class="btn">Оформить заказ</button>
        </form>
    </div>
</body>
</html>
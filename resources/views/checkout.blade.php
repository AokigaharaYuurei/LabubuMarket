<!DOCTYPE html>
<!-- resources/views/checkout.blade.php -->
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформление заказа - ЛАБУБУ.МАРКЕТ</title>
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
        .checkout-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #374151;
        }
        input, select, textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 1rem;
        }
        .order-summary {
            background: #f9fafb;
            padding: 2rem;
            border-radius: 8px;
            height: fit-content;
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
            width: 100%;
            padding: 1rem;
            background: #10b981;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            cursor: pointer;
            margin-top: 1rem;
        }
        .button:hover {
            background: #059669;
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="{{ route('products.index') }}">
            <h1>ЛАБУБУ.МАРКЕТ</h1>
        </a>
        <a href="{{ route('basket.index') }}">
            Корзина
        </a>
    </header>

    <main>
        <div class="checkout-container">
            <div class="checkout-form">
                <h2>Оформление заказа</h2>
                
                <form action="{{ route('order.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label for="customer_name">Ваше имя *</label>
                        <input type="text" id="customer_name" name="customer_name" required value="{{ old('customer_name') }}">
                    </div>

                    <div class="form-group">
                        <label for="address">Адрес доставки *</label>
                        <textarea id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="payment_method">Способ оплаты *</label>
                        <select id="payment_method" name="payment_method" required>
                            <option value="">Выберите способ оплаты</option>
                            <option value="МИР" {{ old('payment_method') == 'МИР' ? 'selected' : '' }}>МИР</option>
                            <option value="VISA" {{ old('payment_method') == 'VISA' ? 'selected' : '' }}>VISA</option>
                            <option value="MASTERCARD" {{ old('payment_method') == 'MASTERCARD' ? 'selected' : '' }}>MASTERCARD</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="delivery_method">Способ доставки *</label>
                        <select id="delivery_method" name="delivery_method" required onchange="updateDeliveryCost()">
                            <option value="">Выберите способ доставки</option>
                            <option value="courier" {{ old('delivery_method') == 'courier' ? 'selected' : '' }} data-cost="300">Курьерская доставка (300 ₽)</option>
                            <option value="post" {{ old('delivery_method') == 'post' ? 'selected' : '' }} data-cost="200">Почтовая доставка (200 ₽)</option>
                            <option value="pickup" {{ old('delivery_method') == 'pickup' ? 'selected' : '' }} data-cost="0">Самовывоз (бесплатно)</option>
                        </select>
                    </div>

                    <button type="submit" class="button">Оформить заказ</button>
                </form>
            </div>

            <div class="order-summary">
                <h3>Ваш заказ</h3>
                
                @foreach($products as $product)
                    <div class="order-item">
                        <span>{{ $product->name }} × {{ $product->quantity }}</span>
                        <span>{{ number_format($product->price * $product->quantity, 0, ',', ' ') }} ₽</span>
                    </div>
                @endforeach

                <div class="order-item">
                    <span>Стоимость товаров:</span>
                    <span id="products-total">{{ number_format($productsTotal, 0, ',', ' ') }} ₽</span>
                </div>

                <div class="order-item">
                    <span>Доставка:</span>
                    <span id="delivery-cost">0 ₽</span>
                </div>

                <div class="total">
                    <span>Итого:</span>
                    <span id="total-amount">{{ number_format($productsTotal, 0, ',', ' ') }} ₽</span>
                </div>
            </div>
        </div>
    </main>

    <script>
        function updateDeliveryCost() {
            const deliverySelect = document.getElementById('delivery_method');
            const selectedOption = deliverySelect.options[deliverySelect.selectedIndex];
            const deliveryCost = selectedOption ? parseInt(selectedOption.getAttribute('data-cost')) : 0;
            const productsTotal = {{ $productsTotal }};
            
            document.getElementById('delivery-cost').textContent = deliveryCost.toLocaleString('ru-RU') + ' ₽';
            document.getElementById('total-amount').textContent = (productsTotal + deliveryCost).toLocaleString('ru-RU') + ' ₽';
        }

        // Инициализация при загрузке
        document.addEventListener('DOMContentLoaded', function() {
            updateDeliveryCost();
        });
    </script>
</body>
</html>
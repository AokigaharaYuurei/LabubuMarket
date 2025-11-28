<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина - ЛАБУБУ.МАРКЕТ</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="header">
        <a href="{{ route('products.index') }}">
            <h1 class="name">ЛАБУБУ.МАРКЕТ</h1>
        </a>
        <a href="{{ route('basket.index') }}" class="basket-link">
            <img src="/img/basket.png" alt="Корзина" width="32" height="32">
            @php
                $cartCount = array_sum(session('cart', []));
            @endphp
            @if($cartCount > 0)
                <span class="basket-count">{{ $cartCount }}</span>
            @endif
        </a>
    </header>

    <main style="max-width: 1200px; margin: 0 auto; padding: 2rem;">
        <h2>Корзина покупок</h2>

        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                {{ session('error') }}
            </div>
        @endif

        @if(isset($products) && count($products) > 0)
            <div class="cart-items">
                @foreach($products as $product)
                    @if($product && $product->id) <!-- Добавляем проверку -->
                    <div class="cart-item">
                        
                        <div class="item-details" style="flex-grow: 1;">
                            <h3 style="margin: 0 0 0.5rem 0;">{{ $product->name ?? 'Неизвестный товар' }}</h3>
                            <p style="margin: 0; color: #6b7280;">
                                @if($product->description)
                                    {{ Str::limit($product->description, 100) }}
                                @else
                                    Описание отсутствует
                                @endif
                            </p>
                        </div>
                        
                        <div class="item-price" style="margin-right: 2rem;">
                            <strong>{{ number_format($product->price ?? 0, 0, ',', ' ') }} ₽</strong>
                        </div>
                        
                        <div class="item-quantity" style="margin-right: 2rem;">
                            <form action="{{ route('cart.update', $product->id) }}" method="POST" style="display: flex; align-items: center;">
                                @csrf
                                <button type="button" onclick="updateQuantity({{ $product->id }}, -1)" class="button">-</button>
                                <input type="number" id="quantity-{{ $product->id }}" value="{{ $product->quantity ?? 1 }}" min="1" style="width: 60px; text-align: center; margin: 0 0.5rem; padding: 0.5rem; border: 1px solid #d1d5db;">
                                <button type="button" onclick="updateQuantity({{ $product->id }}, 1)" class="button">+</button>
                            </form>
                        </div>
                        
                        <form action="{{ route('cart.remove', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="button button-danger">Удалить</button>
                        </form>
                    </div>
                    @endif
                @endforeach
            </div>
            
            <div class="cart-total" style="margin-top: 2rem; text-align: right;">
                <h3>Итого: {{ number_format($total, 0, ',', ' ') }} ₽</h3>
                <form action="{{ route('cart.clear') }}" method="POST" style="display: inline-block; margin-right: 1rem;">
                    @csrf
                    <button type="submit" class="button">Очистить корзину</button>
                </form>
                <a href="{{ route('checkout') }}" class="button button-success" style="padding: 0.75rem 2rem; font-size: 1.1rem; text-decoration: none;">
                    Оформить заказ
                </a>
            </div>
        @else
            <div class="empty-cart">
                <h3>Корзина пуста</h3>
                <p>Добавьте товары из каталога</p>
                <a href="{{ route('products.index') }}" class="button button-primary" style="text-decoration: none;">
                    Перейти к покупкам
                </a>
            </div>
        @endif
    </main>

    <script>
        function updateQuantity(productId, change) {
            const input = document.getElementById('quantity-' + productId);
            let newQuantity = parseInt(input.value) + change;
            
            if (newQuantity < 1) newQuantity = 1;
            
            input.value = newQuantity;
            
            // Автоматическое обновление при изменении количества
            fetch('{{ url("/cart/update") }}/' + productId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    quantity: newQuantity
                })
            }).then(response => {
                if (response.ok) {
                    location.reload();
                }
            });
        }
    </script>
</body>
</html>
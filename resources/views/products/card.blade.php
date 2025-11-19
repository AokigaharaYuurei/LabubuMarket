<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="header">
            <a href="{{ route('products.index') }}">
                <h1 class="name">ЛАБУБУ.МАРКЕТ</h1>
            </a>
            <a href="{{ route('basket.index') }}"><img src="/img/basket.png" alt="">
        @if($cartCount ?? 0 > 0)
            <span class="basket-count">{{ $cartCount }}</span>
        @endif</a>
        </header>
    <x-app-layout>
        <main>
            @isset($product) {{-- Проверяем, существует ли переменная $product --}}
              <div class="card_2">
                <p>{{ $product->name }}</p>
                <p>{{ $product->category_id }}</p>
                <p>{{ $product->description }}</p>
                <p>Цена: {{ $product->price }}</p>
                <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display: inline;">
                @csrf
                <button class="button_add_in_buscket" type="submit">Добавить в корзину</button>
                </form>
                </div>
            @else
                <p>Продукт не найден</p>
            @endisset
        </main>
        <footer></footer>
    </x-app-layout>
</body>
</html>
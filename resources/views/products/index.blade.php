<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header>
            <a href="{{ route('products.index') }}"><h1 class="name">ЛАБУБУ.МАРКЕТ</h1></a>
    </header>

  <x-app-layout>
        <main>
            <div class="all_elements">
                <div class="search">
                    <!-- <img src="/images/search.svg" alt="search"> сделать фотку лупы-->
                    <input type="text" placeholder="Поиск" class="search_input">
                </div>
            <div class="container">
                @foreach ($products as $product)
                    {{-- Передаем ID продукта в маршрут --}}
                    <a href="{{ route('products.card', ['id' => $product->id]) }}">
                        <div class="card">
                            <p>{{ $product->img }}</p>
                            <p>{{ $product->name }}</p>
                            <p>{{ $product->category_id }}</p>
                            <p>{{ $product->description }}</p>
                            <p>{{ $product->price }}</p>
                            <!-- <button class="button_add_in_buscket">Добавить в корзину</button> добавить кнопку для корзиныы -->
                        </div>
                    </a>
                @endforeach
            </div>
            </div>
        </main>
        <footer></footer>
    </x-app-layout>
</body>
</html> 
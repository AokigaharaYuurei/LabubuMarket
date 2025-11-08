<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <x-app-layout>
        <header>
            <a href="{{ route('products.index') }}"><h1>ЛАБУБУ.МАРКЕТ</h1></a>
        </header>
        <main>
            <div class="container">
                @foreach ($products as $product)
                    {{-- Передаем ID продукта в маршрут --}}
                    <a href="{{ route('products.card', ['id' => $product->id]) }}">
                        <div class="cards">
                            <p>{{ $product->name }}</p>
                            <p>{{ $product->description }}</p>
                            <p>{{ $product->price }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </main>
        <footer></footer>
    </x-app-layout>
</body>
</html>
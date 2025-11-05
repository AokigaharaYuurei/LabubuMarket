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
            <a href="{{ route('products.index') }}">
                <h1>ЛАБУБУ.МАРКЕТ</h1>
            </a>
        </header>
        <main>
            <p>{{ $product->name }}</p>
            <p>{{ $product->description }}</p>
            <p>Цена: {{ $product->price }}</p>
        </main>
        <footer></footer>
    </x-app-layout>
    </blade>
</body>

</html>
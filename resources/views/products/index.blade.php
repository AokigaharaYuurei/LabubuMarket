<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <a href=""><h1>ЛАБУБУ.МАРКЕТ</h1></a>
    </header>
    <main>
        <div class="container">
        @foreach ($products as $product)
            <form method="POST" action="">
                <div class="cards">
                    <p>{{ $product->name }}</p>
                    <p>{{ $product->description }}</p>
                    <p>{{ $product->price }}</p>
                </div>
        </form>
        @endforeach
        </div>

    </main>
    <footer>

    </footer>
</body>
</html>
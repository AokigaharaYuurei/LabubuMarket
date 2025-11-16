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
        <a href="{{ route('products.index') }}">
            <h1 class="name">ЛАБУБУ.МАРКЕТ</h1>
        </a>
    </header>

    <x-app-layout>
        <main>
            <div class="all_elements">
                <!-- Форма поиска -->
                <div class="search-section">
                    <form action="{{ route('products.search') }}" method="GET" class="search-form" style="width: 100%; display: flex; justify-content: center;">
                        <div class="search_input">
                            <!-- SVG иконка лупы -->
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 21L16.514 16.506L21 21ZM19 10.5C19 15.194 15.194 19 10.5 19C5.806 19 2 15.194 2 10.5C2 5.806 5.806 2 10.5 2C15.194 2 19 5.806 19 10.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <input 
                                type="text" 
                                name="search" 
                                placeholder="Поиск по названию, описанию или цене..." 
                                value="{{ $search ?? '' }}"
                                class="search-input"
                            >
                        </div>
                    </form>
                </div>

                <!-- Информация о результатах поиска -->
                @if(isset($search) && $search)
                    <div class="search-results-info">
                        <h2>Результаты поиска для "{{ $search }}"</h2>
                        <p>Найдено товаров: {{ $products->count() }}</p>
                    </div>
                @endif

                <div class="container">
                    @if($products->count() > 0)
                        @foreach ($products as $product)
                            <a href="{{ route('products.card', ['id' => $product->id]) }}" style="text-decoration: none;">
                                <div class="card">
                                    <div class="card-image">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                        @elseif($product->img)
                                            <img src="{{ $product->img }}" alt="{{ $product->name }}">
                                        @else
                                            <span style="color: #9ca3af;">Нет изображения</span>
                                        @endif
                                    </div>
                                    
                                    @if($product->category_id)
                                        <div class="card-category">Категория: {{ $product->category_id }}</div>
                                    @endif
                                    
                                    <h3 class="card-title">{{ $product->name }}</h3>
                                    <p class="card-description">
                                        {{ $product->description ? Str::limit($product->description, 120) : 'Описание отсутствует' }}
                                    </p>
                                    <div class="card-price">{{ number_format($product->price, 0, ',', ' ') }} ₽</div>
                                    <button class="button_add_in_buscket" type="button">Добавить в корзину</button>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="no-results">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h3>Товары не найдены</h3>
                            <p>Попробуйте изменить поисковый запрос или проверьте правильность написания</p>
                            @if(isset($search) && $search)
                                <a href="{{ route('products.index') }}" class="back-to-all">
                                    Показать все товары
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </main>
        <footer style="text-align: center; padding: 30px; color: #6b7280; margin-top: 50px;">
            <p>ЛАБУБУ.МАРКЕТ &copy; {{ date('Y') }}</p>
        </footer>
    </x-app-layout>

    <script>
        // Автопоиск при вводе текста
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[name="search"]');
            const searchForm = document.querySelector('.search-form');
            
            if (searchInput && searchForm) {
                let searchTimeout;
                
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        searchForm.submit();
                    }, 800); // Задержка 800ms
                });
                
                // Также можно искать по нажатию Enter
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        searchForm.submit();
                    }
                });
            }
            
            // Предотвращаем отправку формы при нажатии кнопки "Добавить в корзину"
            document.querySelectorAll('.button_add_in_buscket').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    alert('Товар добавлен в корзину!');
                    // Здесь будет логика добавления в корзину
                });
            });
        });
    </script>
</body>
</html> 
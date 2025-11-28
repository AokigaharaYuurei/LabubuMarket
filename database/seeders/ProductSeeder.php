<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Labubu дизайнерская игрушка',
                'description' => 'Коллекционная фигурка Labubu от известного дизайнера. Высокое качество материалов, детальная проработка.',
                'price' => 2999.00,
                'image' => 'https://images-na.ssl-images-amazon.com/images/I/51045Q30cRL._AC_UL600_SR600,400_.jpg',
                'category_id' => 1
            ],
            [
                'name' => 'Labubu лесной дух',
                'description' => 'Очаровательная фигурка лесного духа Labubu. Идеально подходит для коллекционеров и поклонников бренда.',
                'price' => 3499.00,
                'image' => 'https://ir-3.ozone.ru/s3/multimedia-1-y/w1200/7558188586.jpg',
                'category_id' => 1
            ],
            [
                'name' => 'Labubu космическая серия',
                'description' => 'Эксклюзивная фигурка из космической серии. Ограниченный тираж, высокая детализация.',
                'price' => 4199.00,
                'image' => 'https://avatars.mds.yandex.net/get-mpic/12263081/2a0000019471a7508e0ce58edb443a26f624/orig',
                'category_id' => 2
            ],
            [
                'name' => 'Labubu зимняя коллекция',
                'description' => 'Сезонная фигурка из зимней коллекции. Теплый и уютный дизайн, идеально подходит для подарка.',
                'price' => 3799.00,
                'image' => 'https://avatars.mds.yandex.net/get-mpic/15250760/2a000001970680e6795a2322cc6d331f569e/orig',
                'category_id' => 2
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
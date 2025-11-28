<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description', 
        'price',
        'image', // исправлено с 'img' на 'image'
        'category_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Метод для получения URL изображения
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return $this->image;
        }
        return '/img/no-image.jpg'; // изображение-заглушка
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Указываем имя таблицы (если отличается от стандартного)
    protected $table = 'products';

    // Разрешаем массовое присвоение для этих полей
    protected $fillable = [
        'name',
        'description', 
        'price',
        'image',
        'category_id'
    ];

    // Если хотите преобразовать типы данных
    protected $casts = [
        'price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'address',
        'payment_method',
        'delivery_method',
        'products_total',
        'delivery_cost',
        'total_amount',
        'status',
        'order_items'
    ];

    protected $casts = [
        'order_items' => 'array',
        'products_total' => 'decimal:2',
        'delivery_cost' => 'decimal:2',
        'total_amount' => 'decimal:2'
    ];

    public static function generateOrderNumber()
    {
        return 'ORD-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    }

    public function getStatusLabelAttribute()
    {
        return [
            'new' => 'Новая',
            'in_progress' => 'В работе',
            'completed' => 'Завершена',
            'cancelled' => 'Отменена'
        ][$this->status] ?? $this->status;
    }

    public function getDeliveryMethodLabelAttribute()
    {
        return [
            'courier' => 'Курьерская доставка',
            'pickup' => 'Самовывоз',
            'post' => 'Почтовая доставка'
        ][$this->delivery_method] ?? $this->delivery_method;
    }
}
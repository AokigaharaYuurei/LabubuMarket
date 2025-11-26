<?php
// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name', 
        'address',
        'payment_method',
        'delivery_method',
        'status',
        'total_amount'
    ];

    /**
     * Get the status label attribute.
     */
    public function getStatusLabelAttribute()
    {
        return [
            'new' => 'Новая',
            'in_progress' => 'В работе', 
            'completed' => 'Завершена',
            'cancelled' => 'Отменена'
        ][$this->status] ?? $this->status;
    }

    /**
     * Get the delivery method label attribute.
     */
    public function getDeliveryMethodLabelAttribute()
    {
        return [
            'pickup' => 'Самовывоз',
            'delivery' => 'Доставка'
        ][$this->delivery_method] ?? $this->delivery_method;
    }

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
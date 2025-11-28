<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Проверяет, является ли пользователь администратором
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Проверяет, является ли пользователь продавцом
     */
    public function isSeller(): bool
    {
        return $this->role === 'seller';
    }

    /**
     * Проверяет, является ли пользователь администратором или продавцом
     */
    public function isAdminOrSeller(): bool
    {
        return $this->isAdmin() || $this->isSeller();
    }

    /**
     * Получить отображаемое имя роли
     */
    public function getRoleLabelAttribute(): string
    {
        return [
            'admin' => 'Администратор',
            'seller' => 'Продавец', 
            'user' => 'Пользователь'
        ][$this->role] ?? $this->role;
    }
}
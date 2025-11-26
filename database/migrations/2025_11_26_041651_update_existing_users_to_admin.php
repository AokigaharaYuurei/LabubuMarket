<?php
// database/migrations/2024_01_01_000001_update_existing_users_to_admin.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Обновляем всех существующих пользователей до роли admin
        User::whereNull('role')->orWhere('role', '')->update(['role' => 'admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Откат - устанавливаем роль обратно в user
        User::where('role', 'admin')->update(['role' => 'user']);
    }
};
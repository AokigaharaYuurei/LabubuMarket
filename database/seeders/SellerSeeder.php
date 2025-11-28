<?php
// database/seeders/SellerSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SellerSeeder extends Seeder
{
    public function run(): void
    {
        // Создаем продавца
        User::create([
            'name' => 'Иван Продавец',
            'email' => 'seller@labubu.market',
            'password' => Hash::make('seller123'),
            'role' => 'seller',
        ]);

        $this->command->info('Продавец создан!');
        $this->command->info('Email: seller@labubu.market');
        $this->command->info('Password: seller123');
    }
}
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'bagas@example.com'],
            [
                'name' => 'Bagas',
                'password' => Hash::make('password123'),
            ]
        );
    }
}
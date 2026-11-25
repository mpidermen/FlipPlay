<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Bagas',
                'email' => 'bagas@gmail.com',
            ],
            [
                'name' => 'Dila',
                'email' => 'dila@gmail.com',
            ],
            [
                'name' => 'Rendi',
                'email' => 'rendi@gmail.com',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make('password123'),
                ]
            );
        }
    }
}
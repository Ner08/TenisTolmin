<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'robic.nejc1122@gmail.com',
            'password' => bcrypt('tktolmin2024'),
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Marko Novak',
            'email' => 'marko.novak@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Ana Kovač',
            'email' => 'ana.kovac@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);
    }
}

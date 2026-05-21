<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('gallery')->insert([
            [
                'g_title' => 'Klubski turnir 2023 – finale',
                'g_image' => 'gallery/placeholder1.jpg',
                'home_page' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'g_title' => 'Poletna liga 2023',
                'g_image' => 'gallery/placeholder2.jpg',
                'home_page' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'g_title' => 'Otroški teniški dan 2023',
                'g_image' => 'gallery/placeholder3.jpg',
                'home_page' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'g_title' => 'Zaključni piknik 2023',
                'g_image' => 'gallery/placeholder4.jpg',
                'home_page' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

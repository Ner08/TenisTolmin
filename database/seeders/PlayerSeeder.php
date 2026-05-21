<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PlayerSeeder extends Seeder
{
    public function run(): void
    {
        // id=1 must always be the fake/bye player — other seeders depend on this
        DB::table('players')->insert([
            'id' => 1,
            'p_name' => 'Nedoločen igralec / ekipa',
            'points' => 0,
            'is_fake' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

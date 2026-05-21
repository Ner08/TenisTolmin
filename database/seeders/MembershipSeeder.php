<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class MembershipSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('memberships')->insert([
            [
                'year' => 2024,
                'price_adults' => '100',
                'price_seniors' => '80',
                'price_students' => '65',
                'price_kids' => '35',
                'price_family' => '220',
                'trr' => 'SI56 0475 3000 0388 292',
                'sklic' => 'SI00 2024',
                'namen' => 'Članarina 2024',
                'prejemnik' => 'TENIŠKI KLUB TOLMIN, Dijaška ulica 12 c, 5220 Tolmin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'year' => 2025,
                'price_adults' => '110',
                'price_seniors' => '85',
                'price_students' => '70',
                'price_kids' => '40',
                'price_family' => '240',
                'trr' => 'SI56 0475 3000 0388 292',
                'sklic' => 'SI00 2025',
                'namen' => 'Članarina 2025',
                'prejemnik' => 'TENIŠKI KLUB TOLMIN, Dijaška ulica 12 c, 5220 Tolmin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

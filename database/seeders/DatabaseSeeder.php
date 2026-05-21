<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PlayerSeeder::class,
            UserSeeder::class,
            MembershipSeeder::class,
            NewsSeeder::class,
            EventSeeder::class,
            GallerySeeder::class,
            LeagueSeeder::class,
        ]);
    }
}

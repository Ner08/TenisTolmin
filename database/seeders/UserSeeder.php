<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ─────────────────────────────────────────────────────────
        User::create([
            'name'                => 'admin',
            'email'               => 'robic.nejc1122@gmail.com',
            'password'            => bcrypt('tktolmin2024'),
            'is_admin'            => true,
            'is_super_admin'      => true,
            'registration_status' => 'approved',
        ]);

        // ── Nejc — player account (linked to a player record) ─────────────
        $nejcPlayerId = DB::table('players')->insertGetId([
            'p_name'     => 'Nejc Robič',
            'points'     => 95,
            'is_fake'    => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name'                => 'Nejc Robič',
            'email'               => 'robic.nejc12@gmail.com',
            'password'            => bcrypt('tktolmin2024'),
            'is_admin'            => false,
            'is_super_admin'      => false,
            'player_id'           => $nejcPlayerId,
            'registration_status' => 'approved',
        ]);

        // ── Opponent — test account for confirming/disputing results ───────
        $opponentPlayerId = DB::table('players')->insertGetId([
            'p_name'     => 'Test Nasprotnik',
            'points'     => 60,
            'is_fake'    => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name'                => 'Test Nasprotnik',
            'email'               => 'opponent@test.com',
            'password'            => bcrypt('password'),
            'is_admin'            => false,
            'is_super_admin'      => false,
            'player_id'           => $opponentPlayerId,
            'registration_status' => 'approved',
        ]);

        // ── Extra approved user (no player link) ──────────────────────────
        User::create([
            'name'                => 'Ana Kovač',
            'email'               => 'ana.kovac@example.com',
            'password'            => bcrypt('password'),
            'is_admin'            => false,
            'registration_status' => 'approved',
        ]);

        // ── Pending registration (to test admin approval flow) ────────────
        User::create([
            'name'                => 'Čakam Odobritev',
            'email'               => 'pending@test.com',
            'password'            => bcrypt('password'),
            'is_admin'            => false,
            'registration_status' => 'pending',
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class LeagueSeeder extends Seeder
{
    public function run(): void
    {
        // ── Resolve test accounts created by UserSeeder ──────────────────
        $nejcPlayerId     = DB::table('players')->where('p_name', 'Nejc Robič')->value('id');
        $opponentPlayerId = DB::table('players')->where('p_name', 'Test Nasprotnik')->value('id');
        $nejcUserId       = DB::table('users')->where('email', 'robic.nejc12@gmail.com')->value('id');
        $opponentUserId   = DB::table('users')->where('email', 'opponent@test.com')->value('id');

        // ── Background players (regular leaderboard players) ─────────────
        $players = [
            ['p_name' => 'Luka Peršič',     'points' => 220],
            ['p_name' => 'Gregor Mežnar',   'points' => 185],
            ['p_name' => 'Matej Božič',     'points' => 160],
            ['p_name' => 'Nina Zorman',     'points' => 130],
            ['p_name' => 'Simon Klinc',     'points' => 110],
            ['p_name' => 'Tomaž Šuštar',    'points' =>  90],
            ['p_name' => 'Rok Urankar',     'points' =>  75],
            ['p_name' => 'Maja Fortuna',    'points' =>  60],
            ['p_name' => 'Andrej Kos',      'points' =>  45],
            ['p_name' => 'Petra Leban',     'points' =>  35],
            ['p_name' => 'Jure Batagelj',   'points' =>  22],
            ['p_name' => 'Sara Markič',     'points' =>  14],
            ['p_name' => 'Bojan Vidmar',    'points' =>  50],
            ['p_name' => 'Katja Novak',     'points' =>  42],
            ['p_name' => 'Miha Bertoncelj', 'points' =>  30],
            ['p_name' => 'Tina Kravanja',   'points' =>  18],
        ];

        $playerIds = [];
        foreach ($players as $p) {
            $playerIds[] = DB::table('players')->insertGetId([
                'p_name'     => $p['p_name'],
                'points'     => $p['points'],
                'is_fake'    => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        [
            $luka, $gregor, $matej, $nina, $simon, $tomaz,
            $rok, $maja, $andrej, $petra, $jure, $sara,
            $bojan, $katja, $miha, $tina
        ] = $playerIds;
        $bye = 1;

        // ─────────────────────────────────────────────────────────────────
        // LEAGUE 1 – Poletna liga 2024  (group stage only, 2 groups)
        // ─────────────────────────────────────────────────────────────────
        $league1 = DB::table('leagues')->insertGetId([
            'name'        => 'Poletna liga 2024',
            'description' => 'Klubska poletna liga za sezono 2024. Tekmovanje v skupinskem sistemu.',
            'start_date'  => '2024-06-01',
            'end_date'    => '2024-08-31',
            'l_home_page' => true,
            'created_at'  => now(), 'updated_at' => now(),
        ]);

        $b1a = $this->bracket($league1, 'Skupina A', 'A', true,
            'Zmaga: 3 točke • Poraz 1:2: 1 točka • Poraz 0:2: 0 točk');
        [$t1a1, $t1a2, $t1a3, $t1a4] = $this->makeTeams($b1a, [$luka, $simon, $petra, $jure]);
        $this->m($b1a, $t1a1, $t1a2, 6,3, 6,4, null,null, 1);
        $this->m($b1a, $t1a3, $t1a4, 6,4, 3,6, 6,3,   1);
        $this->m($b1a, $t1a1, $t1a3, 6,2, 6,4, null,null, 2);
        $this->m($b1a, $t1a2, $t1a4, 6,3, 4,6, 6,4,   2);
        $this->m($b1a, $t1a1, $t1a4, 6,4, 7,5, null,null, 3);
        $this->m($b1a, $t1a2, $t1a3, 5,7, 6,4, 6,3,   3);

        $b1b = $this->bracket($league1, 'Skupina B', 'B', true,
            'Zmaga: 3 točke • Poraz 1:2: 1 točka • Poraz 0:2: 0 točk');
        [$t1b1, $t1b2, $t1b3, $t1b4] = $this->makeTeams($b1b, [$rok, $maja, $andrej, $sara]);
        $this->m($b1b, $t1b1, $t1b2, 6,3, 6,4, null,null, 1);
        $this->m($b1b, $t1b3, $t1b4, 7,5, 4,6, 6,4,   1);
        $this->m($b1b, $t1b1, $t1b3, 6,4, 3,6, 7,5,   2);
        $this->m($b1b, $t1b2, $t1b4, 6,2, 6,3, null,null, 2);
        $this->m($b1b, $t1b1, $t1b4, null,null, null,null, null,null, 3);
        $this->m($b1b, $t1b2, $t1b3, null,null, null,null, null,null, 3);

        // ─────────────────────────────────────────────────────────────────
        // LEAGUE 2 – Zimska liga 2024  (knockout only, with places)
        // ─────────────────────────────────────────────────────────────────
        $league2 = DB::table('leagues')->insertGetId([
            'name'        => 'Zimska liga 2024',
            'description' => 'Zimska notranja liga za člane kluba. Tekme v dvorani.',
            'start_date'  => '2024-10-15',
            'end_date'    => '2025-02-28',
            'l_home_page' => false,
            'created_at'  => now(), 'updated_at' => now(),
        ]);

        $b2ko = $this->bracket($league2, 'Izločitveni del', null, false, null, 1, 4);
        [$t2k1, $t2k2, $t2k3, $t2k4] = $this->makeTeams($b2ko, [$matej, $nina, $tomaz, $andrej]);
        $this->m($b2ko, $t2k1, $t2k4, 6,3, 6,4, null,null, 1, null, 'A1', 'B2');
        $this->m($b2ko, $t2k3, $t2k2, 4,6, 7,5, 6,4,   1, null, 'B1', 'A2');
        $ff1 = $this->faketeam($b2ko, $bye);
        $ff2 = $this->faketeam($b2ko, $bye);
        $this->m($b2ko, $ff1, $ff2, null,null, null,null, null,null, 2, null, 'Zm. SF1', 'Zm. SF2');

        // ─────────────────────────────────────────────────────────────────
        // LEAGUE 3 – Letna liga Tolmin 2025  (3 groups + knockout)
        // ─────────────────────────────────────────────────────────────────
        $league3 = DB::table('leagues')->insertGetId([
            'name'        => 'Letna liga Tolmin 2025',
            'description' => 'Glavna sezonska liga za leto 2025. Skupinski del in izločitveni turnir.',
            'start_date'  => '2025-03-01',
            'end_date'    => '2025-06-30',
            'l_home_page' => true,
            'created_at'  => now(), 'updated_at' => now(),
        ]);

        $b3a = $this->bracket($league3, 'Skupina A', 'A', true,
            'Zmaga: 3 točke • Poraz 1:2: 1 točka • Poraz 0:2: 0 točk');
        [$tA1, $tA2, $tA3, $tA4] = $this->makeTeams($b3a, [$luka, $matej, $rok, $simon]);
        $this->m($b3a, $tA1, $tA2, 6,3, 6,4, null,null, 1);
        $this->m($b3a, $tA3, $tA4, 3,6, 4,6, null,null, 1);
        $this->m($b3a, $tA1, $tA3, 6,2, 6,3, null,null, 2);
        $this->m($b3a, $tA2, $tA4, 7,5, 4,6, 6,3,   2);
        $this->m($b3a, $tA1, $tA4, 6,4, 7,5, null,null, 3);
        $this->m($b3a, $tA2, $tA3, 6,4, 6,1, null,null, 3);

        $b3b = $this->bracket($league3, 'Skupina B', 'B', true,
            'Zmaga: 3 točke • Poraz 1:2: 1 točka • Poraz 0:2: 0 točk');
        [$tB1, $tB2, $tB3, $tB4] = $this->makeTeams($b3b, [$gregor, $tomaz, $nina, $maja]);
        $this->m($b3b, $tB1, $tB2, 6,4, 7,5, null,null, 1);
        $this->m($b3b, $tB3, $tB4, 6,4, 3,6, 6,3,   1);
        $this->m($b3b, $tB1, $tB3, 6,2, 6,4, null,null, 2);
        $this->m($b3b, $tB2, $tB4, 6,3, 6,2, null,null, 2);
        $this->m($b3b, $tB1, $tB4, null,null, null,null, null,null, 3);
        $this->m($b3b, $tB2, $tB3, null,null, null,null, null,null, 3);

        $b3c = $this->bracket($league3, 'Skupina C', 'C', true,
            'Zmaga: 3 točke • Poraz 1:2: 1 točka • Poraz 0:2: 0 točk');
        [$tC1, $tC2, $tC3, $tC4] = $this->makeTeams($b3c, [$andrej, $petra, $jure, $sara]);
        $this->m($b3c, $tC1, $tC2, 7,5, 6,4, null,null, 1);
        $this->m($b3c, $tC3, $tC4, 6,3, 3,6, 7,5,   1);
        $this->m($b3c, $tC1, $tC3, 6,4, 4,6, 6,4,   2);
        $this->m($b3c, $tC2, $tC4, 6,1, 6,2, null,null, 2);
        $this->m($b3c, $tC1, $tC4, null,null, null,null, null,null, 3);
        $this->m($b3c, $tC2, $tC3, null,null, null,null, null,null, 3);

        $b3ko = $this->bracket($league3, 'Izločitveni del', null, false,
            'Top 2 iz vsake skupine napreduje v izločitveni del.', 1, 6);
        [$tkLuka, $tkMatej, $tkGregor, $tkTomaz, $tkAndrej, $tkPetra] =
            $this->makeTeams($b3ko, [$luka, $matej, $gregor, $tomaz, $andrej, $petra]);
        $this->m($b3ko, $tkLuka,   $tkPetra,  6,2, 6,1, null,null, 1);
        $this->m($b3ko, $tkGregor, $tkMatej,  7,5, 3,6, 6,4,   1);
        $this->m($b3ko, $tkAndrej, $tkTomaz,  4,6, 6,4, 6,4,   1);
        $this->m($b3ko, $tkLuka,   $tkAndrej, 6,3, 7,5, null,null, 2);
        $fSemi = $this->faketeam($b3ko, $bye);
        $this->m($b3ko, $tkGregor, $fSemi,    null,null, null,null, null,null, 2, null, null, 'Zm. SF2');
        $fFin1 = $this->faketeam($b3ko, $bye);
        $fFin2 = $this->faketeam($b3ko, $bye);
        $this->m($b3ko, $fFin1, $fFin2, null,null, null,null, null,null, 3, null, 'Zm. SF1', 'Zm. SF2');

        // ─────────────────────────────────────────────────────────────────
        // LEAGUE 4 – Pokalno tekmovanje 2025  (4 groups + 8-player knockout)
        // ─────────────────────────────────────────────────────────────────
        $league4 = DB::table('leagues')->insertGetId([
            'name'        => 'Pokalno tekmovanje 2025',
            'description' => 'Klubski pokal 2025. Štiri skupine in izločitveni del z osmino finala.',
            'start_date'  => '2025-04-01',
            'end_date'    => '2025-09-30',
            'l_home_page' => true,
            'created_at'  => now(), 'updated_at' => now(),
        ]);

        $pts = 'Zmaga: 3 točke • Poraz 1:2: 1 točka • Poraz 0:2: 0 točk';

        $g4a = $this->bracket($league4, 'Skupina A', 'A', true, $pts);
        [$g4a1, $g4a2, $g4a3, $g4a4] = $this->makeTeams($g4a, [$luka, $bojan, $nina, $miha]);
        $this->m($g4a, $g4a1, $g4a2, 6,1, 6,2, null,null, 1);
        $this->m($g4a, $g4a3, $g4a4, 7,5, 6,4, null,null, 1);
        $this->m($g4a, $g4a1, $g4a3, 6,3, 7,5, null,null, 2);
        $this->m($g4a, $g4a2, $g4a4, 4,6, 6,3, 7,5,   2);
        $this->m($g4a, $g4a1, $g4a4, null,null, null,null, null,null, 3);
        $this->m($g4a, $g4a2, $g4a3, null,null, null,null, null,null, 3);

        $g4b = $this->bracket($league4, 'Skupina B', 'B', true, $pts);
        [$g4b1, $g4b2, $g4b3, $g4b4] = $this->makeTeams($g4b, [$gregor, $katja, $simon, $tina]);
        $this->m($g4b, $g4b1, $g4b2, 6,4, 6,3, null,null, 1);
        $this->m($g4b, $g4b3, $g4b4, 6,2, 6,1, null,null, 1);
        $this->m($g4b, $g4b1, $g4b3, 3,6, 7,5, 6,4,   2);
        $this->m($g4b, $g4b2, $g4b4, 6,3, 6,4, null,null, 2);
        $this->m($g4b, $g4b1, $g4b4, null,null, null,null, null,null, 3);
        $this->m($g4b, $g4b2, $g4b3, null,null, null,null, null,null, 3);

        $g4c = $this->bracket($league4, 'Skupina C', 'C', true, $pts);
        [$g4c1, $g4c2, $g4c3, $g4c4] = $this->makeTeams($g4c, [$matej, $rok, $andrej, $jure]);
        $this->m($g4c, $g4c1, $g4c2, 6,2, 7,5, null,null, 1);
        $this->m($g4c, $g4c3, $g4c4, 6,4, 6,3, null,null, 1);
        $this->m($g4c, $g4c1, $g4c3, 7,5, 6,4, null,null, 2);
        $this->m($g4c, $g4c2, $g4c4, 3,6, 6,4, 6,3,   2);
        $this->m($g4c, $g4c1, $g4c4, null,null, null,null, null,null, 3);
        $this->m($g4c, $g4c2, $g4c3, null,null, null,null, null,null, 3);

        $g4d = $this->bracket($league4, 'Skupina D', 'D', true, $pts);
        [$g4d1, $g4d2, $g4d3, $g4d4] = $this->makeTeams($g4d, [$tomaz, $maja, $petra, $sara]);
        $this->m($g4d, $g4d1, $g4d2, 6,3, 6,2, null,null, 1);
        $this->m($g4d, $g4d3, $g4d4, 6,4, 7,5, null,null, 1);
        $this->m($g4d, $g4d1, $g4d3, 4,6, 5,7, null,null, 2);
        $this->m($g4d, $g4d2, $g4d4, 6,1, 6,3, null,null, 2);
        $this->m($g4d, $g4d1, $g4d4, null,null, null,null, null,null, 3);
        $this->m($g4d, $g4d2, $g4d3, null,null, null,null, null,null, 3);

        $g4ko = $this->bracket($league4, 'Izločitveni del', null, false,
            'Najboljša 2 iz vsake skupine se uvrstita v izločitveni del.', 1, 8);
        [
            $k4a1, $k4a2, $k4b1, $k4b2,
            $k4c1, $k4c2, $k4d1, $k4d2,
        ] = $this->makeTeams($g4ko, [$luka, $bojan, $gregor, $simon, $matej, $rok, $petra, $maja]);
        $this->m($g4ko, $k4a1, $k4d2, 6,3, 6,4, null,null, 1, null, 'A1', 'D2');
        $this->m($g4ko, $k4b1, $k4c2, 6,2, 7,5, null,null, 1, null, 'B1', 'C2');
        $this->m($g4ko, $k4c1, $k4b2, 4,6, 6,3, 7,5,   1, null, 'C1', 'B2');
        $this->m($g4ko, $k4d1, $k4a2, null,null, null,null, null,null, 1, null, 'D1', 'A2');
        $sf1 = $this->faketeam($g4ko, $bye);
        $sf2 = $this->faketeam($g4ko, $bye);
        $sf3 = $this->faketeam($g4ko, $bye);
        $sf4 = $this->faketeam($g4ko, $bye);
        $this->m($g4ko, $sf1, $sf2, null,null, null,null, null,null, 2, null, 'Zm. ČF1', 'Zm. ČF2');
        $this->m($g4ko, $sf3, $sf4, null,null, null,null, null,null, 2, null, 'Zm. ČF3', 'Zm. ČF4');
        $fin1 = $this->faketeam($g4ko, $bye);
        $fin2 = $this->faketeam($g4ko, $bye);
        $this->m($g4ko, $fin1, $fin2, null,null, null,null, null,null, 3, null, 'Zm. SF1', 'Zm. SF2');

        // ─────────────────────────────────────────────────────────────────
        // LEAGUE 5 – Velika skupina 2025  (1 group, 8 players, 28 matches)
        // ─────────────────────────────────────────────────────────────────
        $league5 = DB::table('leagues')->insertGetId([
            'name'        => 'Velika skupina 2025',
            'description' => 'Testna liga z eno veliko skupino — 8 igralcev, 7 krogov, 28 tekem.',
            'start_date'  => '2025-05-01',
            'end_date'    => '2025-10-31',
            'l_home_page' => false,
            'created_at'  => now(), 'updated_at' => now(),
        ]);

        $big = $this->bracket($league5, 'Velika skupina', 'V', true,
            'Zmaga: 3 točke • Poraz 1:2: 1 točka • Poraz 0:2: 0 točk');
        [$v1,$v2,$v3,$v4,$v5,$v6,$v7,$v8] = $this->makeTeams($big,
            [$luka, $gregor, $matej, $nina, $simon, $tomaz, $rok, $maja]);
        $this->m($big,$v1,$v8, 6,3, 6,4, null,null, 1);
        $this->m($big,$v2,$v7, 7,5, 4,6, 6,3,   1);
        $this->m($big,$v3,$v6, 6,2, 6,4, null,null, 1);
        $this->m($big,$v4,$v5, 3,6, 6,3, 6,4,   1);
        $this->m($big,$v2,$v8, 6,4, 6,2, null,null, 2);
        $this->m($big,$v3,$v1, 4,6, 3,6, null,null, 2);
        $this->m($big,$v4,$v7, 6,3, 6,4, null,null, 2);
        $this->m($big,$v5,$v6, 7,5, 5,7, 7,5,   2);
        $this->m($big,$v3,$v8, 6,1, 6,3, null,null, 3);
        $this->m($big,$v4,$v2, 6,4, 4,6, 7,5,   3);
        $this->m($big,$v5,$v1, 3,6, 6,4, 3,6,   3);
        $this->m($big,$v6,$v7, 6,3, 3,6, 6,4,   3);
        $this->m($big,$v4,$v8, 6,2, 6,3, null,null, 4);
        $this->m($big,$v5,$v3, 6,4, 7,5, null,null, 4);
        $this->m($big,$v6,$v2, 4,6, 6,3, 6,4,   4);
        $this->m($big,$v7,$v1, 6,4, 3,6, 7,5,   4);
        $this->m($big,$v5,$v8, 6,3, 6,4, null,null, 5);
        $this->m($big,$v6,$v4, null,null, null,null, null,null, 5);
        $this->m($big,$v7,$v3, null,null, null,null, null,null, 5);
        $this->m($big,$v1,$v2, null,null, null,null, null,null, 5);
        $this->m($big,$v6,$v8, null,null, null,null, null,null, 6);
        $this->m($big,$v7,$v5, null,null, null,null, null,null, 6);
        $this->m($big,$v1,$v4, null,null, null,null, null,null, 6);
        $this->m($big,$v2,$v3, null,null, null,null, null,null, 6);
        $this->m($big,$v7,$v8, null,null, null,null, null,null, 7);
        $this->m($big,$v1,$v6, null,null, null,null, null,null, 7);
        $this->m($big,$v2,$v5, null,null, null,null, null,null, 7);
        $this->m($big,$v3,$v4, null,null, null,null, null,null, 7);

        // ─────────────────────────────────────────────────────────────────
        // LEAGUE 6 – Aktivna testna liga 2026 (Nejc + Opponent + others)
        // Tests: result entry, pending confirmation, disputed, confirmed
        // ─────────────────────────────────────────────────────────────────
        $league6 = DB::table('leagues')->insertGetId([
            'name'        => 'Aktivna testna liga 2026',
            'description' => 'Liga za testiranje vnosa rezultatov, potrditev in sporov.',
            'start_date'  => '2026-01-01',
            'end_date'    => '2026-12-31',
            'l_home_page' => true,
            'created_at'  => now(), 'updated_at' => now(),
        ]);

        // ── Group A: Nejc, Opponent, Luka, Gregor ──────────────────────
        $gA = $this->bracket($league6, 'Skupina A', 'A', true,
            'Zmaga: 3 točke • Poraz 1:2: 1 točka • Poraz 0:2: 0 točk');
        [$tNejc, $tOpp, $tLukaA, $tGregorA] = $this->makeTeams($gA,
            [$nejcPlayerId, $opponentPlayerId, $luka, $gregor]);

        // Match 1 – Nejc vs Opponent  → UNPLAYED (Nejc can enter result here)
        $this->m($gA, $tNejc, $tOpp, null,null, null,null, null,null, 1);

        // Match 2 – Luka vs Gregor → confirmed by admin
        $this->m($gA, $tLukaA, $tGregorA, 6,3, 6,4, null,null, 1, null, null, null,
            'confirmed', null);

        // Match 3 – Nejc vs Luka → PENDING (Nejc submitted, Luka must confirm)
        $this->m($gA, $tNejc, $tLukaA, 6,4, 3,6, 7,5, 2, null, null, null,
            'pending', $nejcUserId);

        // Match 4 – Opponent vs Gregor → DISPUTED
        $this->m($gA, $tOpp, $tGregorA, 7,5, 6,3, null,null, 2, null, null, null,
            'disputed', $opponentUserId);

        // Match 5 – Nejc vs Gregor → unplayed (round 3)
        $this->m($gA, $tNejc, $tGregorA, null,null, null,null, null,null, 3);

        // Match 6 – Opponent vs Luka → unplayed (round 3)
        $this->m($gA, $tOpp, $tLukaA, null,null, null,null, null,null, 3);

        // ── Elimination bracket: Nejc, Opponent, Matej, Nina (places 1-4) ─
        $gKO = $this->bracket($league6, 'Izločitveni del', null, false,
            'Najboljši iz skupin.', 1, 4);
        [$tkNejc, $tkOpp, $tkMatej, $tkNina] = $this->makeTeams($gKO,
            [$nejcPlayerId, $opponentPlayerId, $matej, $nina]);

        // SF1: Nejc vs Nina → Nejc wins (confirmed)
        $this->m($gKO, $tkNejc, $tkNina, 6,3, 6,4, null,null, 1, null, 'A1', 'B2',
            'confirmed', null);

        // SF2: Opponent vs Matej → UNPLAYED (enter result)
        $this->m($gKO, $tkOpp, $tkMatej, null,null, null,null, null,null, 1, null, 'B1', 'A2');

        // Final: placeholder
        $fkFin1 = $this->faketeam($gKO, $bye);
        $fkFin2 = $this->faketeam($gKO, $bye);
        $this->m($gKO, $fkFin1, $fkFin2, null,null, null,null, null,null, 2, null, 'Zm. SF1', 'Zm. SF2');
    }

    // ── Helpers ───────────────────────────────────────────────────────────

    private function bracket(
        int $leagueId,
        string $name,
        ?string $tag,
        bool $isGroup,
        ?string $pointsDesc = null,
        ?int $placesFrom = null,
        ?int $placesTo = null
    ): int {
        return DB::table('brackets')->insertGetId([
            'league_id'          => $leagueId,
            'name'               => $name,
            'tag'                => $tag,
            'b_description'      => null,
            'points_description' => $pointsDesc,
            'is_group_stage'     => $isGroup,
            'places_from'        => $placesFrom,
            'places_to'          => $placesTo,
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);
    }

    private function makeTeams(int $bracketId, array $p1Ids): array
    {
        $ids = [];
        foreach ($p1Ids as $p1Id) {
            $ids[] = DB::table('teams')->insertGetId([
                'bracket_id' => $bracketId,
                'p1_id'      => $p1Id,
                'p2_id'      => null,
                'name'       => null,
                'is_fake'    => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        return $ids;
    }

    private function faketeam(int $bracketId, int $fakePlayerId): int
    {
        return DB::table('teams')->insertGetId([
            'bracket_id' => $bracketId,
            'p1_id'      => $fakePlayerId,
            'p2_id'      => null,
            'name'       => null,
            'is_fake'    => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function m(
        int $bracketId, int $team1Id, int $team2Id,
        $t1s1, $t2s1, $t1s2, $t2s2, $t1s3, $t2s3,
        int $round,
        ?string $exception = null,
        ?string $t1Tag = null,
        ?string $t2Tag = null,
        string $resultStatus = 'none',
        ?int $submittedByUserId = null
    ): int {
        return DB::table('custom_match_ups')->insertGetId([
            'bracket_id'          => $bracketId,
            'team1_id'            => $team1Id,
            'team2_id'            => $team2Id,
            't1_first_set'        => $t1s1,
            't2_first_set'        => $t2s1,
            't1_second_set'       => $t1s2,
            't2_second_set'       => $t2s2,
            't1_third_set'        => $t1s3,
            't2_third_set'        => $t2s3,
            't1_tag'              => $t1Tag,
            't2_tag'              => $t2Tag,
            'round'               => $round,
            'exception'           => $exception,
            'result_status'       => $resultStatus,
            'submitted_by_user_id'=> $submittedByUserId,
            'result_submitted_at' => $submittedByUserId ? now() : null,
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);
    }
}

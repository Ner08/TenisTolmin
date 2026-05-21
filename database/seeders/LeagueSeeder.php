<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class LeagueSeeder extends Seeder
{
    public function run(): void
    {
        // Players — id=1 is the fake/bye player (already created in PlayerSeeder)
        $players = [
            ['p_name' => 'Luka Peršič',   'points' => 220],
            ['p_name' => 'Gregor Mežnar', 'points' => 185],
            ['p_name' => 'Matej Božič',   'points' => 160],
            ['p_name' => 'Nina Zorman',   'points' => 130],
            ['p_name' => 'Simon Klinc',   'points' => 110],
            ['p_name' => 'Tomaž Šuštar',  'points' =>  90],
            ['p_name' => 'Rok Urankar',   'points' =>  75],
            ['p_name' => 'Maja Fortuna',  'points' =>  60],
            ['p_name' => 'Andrej Kos',    'points' =>  45],
            ['p_name' => 'Petra Leban',   'points' =>  35],
            ['p_name' => 'Jure Batagelj', 'points' =>  22],
            ['p_name' => 'Sara Markič',   'points' =>  14],
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

        // Aliases for readability
        [$luka, $gregor, $matej, $nina, $simon, $tomaz, $rok, $maja, $andrej, $petra, $jure, $sara] = $playerIds;
        $byePlayer = 1; // fake/bye player

        // ─────────────────────────────────────────────────────────
        // LEAGUE 1 – Poletna liga 2024  (group stage only)
        // ─────────────────────────────────────────────────────────
        $league1 = DB::table('leagues')->insertGetId([
            'name'                 => 'Poletna liga 2024',
            'description'         => 'Klubska poletna liga za sezono 2024. Tekmovanje v skupinskem sistemu.',
            'start_date'          => '2024-06-01',
            'end_date'            => '2024-08-31',
            'l_home_page'         => true,
            'bg_color'            => '#ecfdf5',
            'main_text_color'     => '#065f46',
            'secondary_text_color'=> '#047857',
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);

        $b1a = DB::table('brackets')->insertGetId([
            'league_id'        => $league1,
            'name'             => 'Skupina A',
            'tag'              => 'A',
            'b_description'    => 'Prva skupina poletne lige 2024.',
            'points_description'=> 'Zmaga: 3 točke • Poraz 1:2: 1 točka • Poraz 0:2: 0 točk',
            'is_group_stage'   => true,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        [$t1a1, $t1a2, $t1a3, $t1a4] = $this->makeTeams($b1a, [$luka, $simon, $petra, $jure]);

        // Round 1
        $this->insertMatch($b1a, $t1a1, $t1a2, 6,3, 6,4, null,null, 1);   // Luka beats Simon 2:0
        $this->insertMatch($b1a, $t1a3, $t1a4, 6,4, 3,6, 6,3,   1);        // Petra beats Jure 2:1
        // Round 2
        $this->insertMatch($b1a, $t1a1, $t1a3, 6,2, 6,4, null,null, 2);   // Luka beats Petra 2:0
        $this->insertMatch($b1a, $t1a2, $t1a4, 6,3, 4,6, 6,4,   2);        // Simon beats Jure 2:1
        // Round 3
        $this->insertMatch($b1a, $t1a1, $t1a4, 6,4, 7,5, null,null, 3);   // Luka beats Jure 2:0
        $this->insertMatch($b1a, $t1a2, $t1a3, 5,7, 6,4, 6,3,   3);        // Simon beats Petra 2:1

        $b1b = DB::table('brackets')->insertGetId([
            'league_id'        => $league1,
            'name'             => 'Skupina B',
            'tag'              => 'B',
            'b_description'    => 'Druga skupina poletne lige 2024.',
            'points_description'=> 'Zmaga: 3 točke • Poraz 1:2: 1 točka • Poraz 0:2: 0 točk',
            'is_group_stage'   => true,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        [$t1b1, $t1b2, $t1b3, $t1b4] = $this->makeTeams($b1b, [$rok, $maja, $andrej, $sara]);

        // Round 1
        $this->insertMatch($b1b, $t1b1, $t1b2, 6,3, 6,4, null,null, 1);   // Rok beats Maja 2:0
        $this->insertMatch($b1b, $t1b3, $t1b4, 7,5, 4,6, 6,4,   1);        // Andrej beats Sara 2:1
        // Round 2
        $this->insertMatch($b1b, $t1b1, $t1b3, 6,4, 3,6, 7,5,   2);        // Rok beats Andrej 2:1
        $this->insertMatch($b1b, $t1b2, $t1b4, 6,2, 6,3, null,null, 2);   // Maja beats Sara 2:0
        // Round 3 — not yet played
        $this->insertMatch($b1b, $t1b1, $t1b4, null,null, null,null, null,null, 3);
        $this->insertMatch($b1b, $t1b2, $t1b3, null,null, null,null, null,null, 3);

        // ─────────────────────────────────────────────────────────
        // LEAGUE 2 – Zimska liga 2024  (small knockout only)
        // ─────────────────────────────────────────────────────────
        $league2 = DB::table('leagues')->insertGetId([
            'name'                 => 'Zimska liga 2024',
            'description'         => 'Zimska notranja liga za člane kluba. Tekme v dvorani.',
            'start_date'          => '2024-10-15',
            'end_date'            => '2025-02-28',
            'l_home_page'         => false,
            'bg_color'            => '#eff6ff',
            'main_text_color'     => '#1e40af',
            'secondary_text_color'=> '#2563eb',
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);

        $b2ko = DB::table('brackets')->insertGetId([
            'league_id'        => $league2,
            'name'             => 'Izločitveni del',
            'tag'              => null,
            'b_description'    => null,
            'points_description'=> null,
            'is_group_stage'   => false,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        [$t2k1, $t2k2, $t2k3, $t2k4] = $this->makeTeams($b2ko, [$matej, $nina, $tomaz, $andrej]);

        // Round 1 – Semi-finals
        $this->insertMatch($b2ko, $t2k1, $t2k4, 6,3, 6,4, null,null, 1, null, 'A1', 'B2'); // Matej vs Andrej (shown as A1 vs B2)
        $this->insertMatch($b2ko, $t2k3, $t2k2, 4,6, 7,5, 6,4,   1, null, 'B1', 'A2');     // Tomaž vs Nina
        // Round 2 – Final (not yet played, show as placeholders)
        $fakeFinal1 = $this->makeFakeTeam($b2ko, $byePlayer);
        $fakeFinal2 = $this->makeFakeTeam($b2ko, $byePlayer);
        $this->insertMatch($b2ko, $fakeFinal1, $fakeFinal2, null,null, null,null, null,null, 2, null, 'Zm. SF1', 'Zm. SF2');

        // ─────────────────────────────────────────────────────────
        // LEAGUE 3 – Letna liga Tolmin 2025  (GROUP + KNOCKOUT)
        // ─────────────────────────────────────────────────────────
        $league3 = DB::table('leagues')->insertGetId([
            'name'                 => 'Letna liga Tolmin 2025',
            'description'         => 'Glavna sezonska liga za leto 2025. Skupinski del in izločitveni turnir.',
            'start_date'          => '2025-03-01',
            'end_date'            => '2025-06-30',
            'l_home_page'         => true,
            'bg_color'            => '#fef9ec',
            'main_text_color'     => '#92400e',
            'secondary_text_color'=> '#b45309',
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);

        // ── Group A ──────────────────────────────────────────────
        $b3a = DB::table('brackets')->insertGetId([
            'league_id'         => $league3,
            'name'              => 'Skupina A',
            'tag'               => 'A',
            'b_description'     => 'Prva skupina letne lige 2025.',
            'points_description'=> 'Zmaga: 3 točke • Poraz 1:2: 1 točka • Poraz 0:2: 0 točk',
            'is_group_stage'    => true,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        [$tA1, $tA2, $tA3, $tA4] = $this->makeTeams($b3a, [$luka, $matej, $rok, $simon]);

        // Round 1
        $this->insertMatch($b3a, $tA1, $tA2, 6,3, 6,4, null,null, 1); // Luka beats Matej 2:0
        $this->insertMatch($b3a, $tA3, $tA4, 3,6, 4,6, null,null, 1); // Simon beats Rok 2:0
        // Round 2
        $this->insertMatch($b3a, $tA1, $tA3, 6,2, 6,3, null,null, 2); // Luka beats Rok 2:0
        $this->insertMatch($b3a, $tA2, $tA4, 7,5, 4,6, 6,3,   2);      // Matej beats Simon 2:1
        // Round 3
        $this->insertMatch($b3a, $tA1, $tA4, 6,4, 7,5, null,null, 3); // Luka beats Simon 2:0
        $this->insertMatch($b3a, $tA2, $tA3, 6,4, 6,1, null,null, 3); // Matej beats Rok 2:0

        // ── Group B ──────────────────────────────────────────────
        $b3b = DB::table('brackets')->insertGetId([
            'league_id'         => $league3,
            'name'              => 'Skupina B',
            'tag'               => 'B',
            'b_description'     => 'Druga skupina letne lige 2025.',
            'points_description'=> 'Zmaga: 3 točke • Poraz 1:2: 1 točka • Poraz 0:2: 0 točk',
            'is_group_stage'    => true,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        [$tB1, $tB2, $tB3, $tB4] = $this->makeTeams($b3b, [$gregor, $tomaz, $nina, $maja]);

        // Round 1
        $this->insertMatch($b3b, $tB1, $tB2, 6,4, 7,5, null,null, 1); // Gregor beats Tomaž 2:0
        $this->insertMatch($b3b, $tB3, $tB4, 6,4, 3,6, 6,3,   1);      // Nina beats Maja 2:1
        // Round 2
        $this->insertMatch($b3b, $tB1, $tB3, 6,2, 6,4, null,null, 2); // Gregor beats Nina 2:0
        $this->insertMatch($b3b, $tB2, $tB4, 6,3, 6,2, null,null, 2); // Tomaž beats Maja 2:0
        // Round 3 — pending
        $this->insertMatch($b3b, $tB1, $tB4, null,null, null,null, null,null, 3); // Gregor vs Maja
        $this->insertMatch($b3b, $tB2, $tB3, null,null, null,null, null,null, 3); // Tomaž vs Nina

        // ── Group C ──────────────────────────────────────────────
        $b3c = DB::table('brackets')->insertGetId([
            'league_id'         => $league3,
            'name'              => 'Skupina C',
            'tag'               => 'C',
            'b_description'     => 'Tretja skupina letne lige 2025.',
            'points_description'=> 'Zmaga: 3 točke • Poraz 1:2: 1 točka • Poraz 0:2: 0 točk',
            'is_group_stage'    => true,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        [$tC1, $tC2, $tC3, $tC4] = $this->makeTeams($b3c, [$andrej, $petra, $jure, $sara]);

        // Round 1
        $this->insertMatch($b3c, $tC1, $tC2, 7,5, 6,4, null,null, 1); // Andrej beats Petra 2:0
        $this->insertMatch($b3c, $tC3, $tC4, 6,3, 3,6, 7,5,   1);      // Jure beats Sara 2:1
        // Round 2
        $this->insertMatch($b3c, $tC1, $tC3, 6,4, 4,6, 6,4,   2);      // Andrej beats Jure 2:1
        $this->insertMatch($b3c, $tC2, $tC4, 6,1, 6,2, null,null, 2); // Petra beats Sara 2:0
        // Round 3 — pending
        $this->insertMatch($b3c, $tC1, $tC4, null,null, null,null, null,null, 3); // Andrej vs Sara
        $this->insertMatch($b3c, $tC2, $tC3, null,null, null,null, null,null, 3); // Petra vs Jure

        // ── Knockout bracket ─────────────────────────────────────
        // A1=Luka, A2=Matej | B1=Gregor, B2=Tomaž | C1=Andrej, C2=Petra
        // Format: A1 vs B2, B1 vs C2, C1 vs A2  (3 semi-finals → 2 semi-finals + 1 final)
        // Let's do 4-team SF: A1 vs C1, B1 vs A2, then final
        $b3ko = DB::table('brackets')->insertGetId([
            'league_id'         => $league3,
            'name'              => 'Izločitveni del',
            'tag'               => null,
            'b_description'     => 'Top 2 iz vsake skupine napreduje v izločitveni del.',
            'points_description'=> null,
            'is_group_stage'    => false,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        // 6 teams in knockout (top 2 from each group)
        [$tkLuka, $tkMatej, $tkGregor, $tkTomaz, $tkAndrej, $tkPetra] = $this->makeTeams(
            $b3ko, [$luka, $matej, $gregor, $tomaz, $andrej, $petra]
        );

        // Round 1 – Quarter-finals (6 players → 3 winners → but 6 is odd; use 4 QFs with 2 byes, or 3 first-round matches)
        // Let's do 3 round-1 matches (A1 vs C2, B1 vs A2, C1 vs B2) → 3 winners to semis
        // Round 1
        $this->insertMatch($b3ko, $tkLuka,   $tkPetra,  6,2, 6,1, null,null, 1); // Luka beats Petra 2:0
        $this->insertMatch($b3ko, $tkGregor, $tkMatej,  7,5, 3,6, 6,4,   1);     // Gregor beats Matej 2:1
        $this->insertMatch($b3ko, $tkAndrej, $tkTomaz,  4,6, 6,4, 6,4,   1);     // Andrej beats Tomaž 2:1

        // Round 2 – Semi-finals (Luka vs Andrej + 1 bye or Gregor goes straight to final)
        // Easier: just have 2 semis — Luka vs Andrej, Gregor vs TBD
        $fakeSemi = $this->makeFakeTeam($b3ko, $byePlayer);
        $this->insertMatch($b3ko, $tkLuka,   $tkAndrej,  6,3, 7,5, null,null, 2); // Luka beats Andrej 2:0
        $this->insertMatch($b3ko, $tkGregor, $fakeSemi,   null,null, null,null, null,null, 2, null, null, 'Zm. SF2');

        // Round 3 – Final (pending)
        $fakeFin1 = $this->makeFakeTeam($b3ko, $byePlayer);
        $fakeFin2 = $this->makeFakeTeam($b3ko, $byePlayer);
        $this->insertMatch($b3ko, $fakeFin1, $fakeFin2, null,null, null,null, null,null, 3, null, 'Zm. SF1', 'Zm. SF2');
    }

    // ── Helpers ───────────────────────────────────────────────────

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

    private function makeFakeTeam(int $bracketId, int $fakePlayerId): int
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

    private function insertMatch(
        int $bracketId,
        int $team1Id,
        int $team2Id,
        $t1s1, $t2s1,
        $t1s2, $t2s2,
        $t1s3, $t2s3,
        int $round,
        ?string $exception = null,
        ?string $t1Tag = null,
        ?string $t2Tag = null
    ): void {
        DB::table('custom_match_ups')->insert([
            'bracket_id'    => $bracketId,
            'team1_id'      => $team1Id,
            'team2_id'      => $team2Id,
            't1_first_set'  => $t1s1,
            't2_first_set'  => $t2s1,
            't1_second_set' => $t1s2,
            't2_second_set' => $t2s2,
            't1_third_set'  => $t1s3,
            't2_third_set'  => $t2s3,
            't1_tag'        => $t1Tag,
            't2_tag'        => $t2Tag,
            'round'         => $round,
            'exception'     => $exception,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    }
}

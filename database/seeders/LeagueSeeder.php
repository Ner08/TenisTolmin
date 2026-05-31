<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class LeagueSeeder extends Seeder
{
    public function run(): void
    {
        $nejcId = DB::table('players')->where('p_name', 'Nejc RobiÄ')->value('id');
        $oppId  = DB::table('players')->where('p_name', 'Test Nasprotnik')->value('id');

        // 14 named players
        $defs = [
            ['Luka PerÅ¡iÄ',     220], ['Gregor MeÅ¾nar',   185], ['Matej BoÅ¾iÄ',     160],
            ['Nina Zorman',     130], ['Simon Klinc',     110], ['Rok Urankar',      90],
            ['Maja Fortuna',     75], ['TomaÅ¾ Å uÅ¡tar',    70], ['Andrej Kos',       65],
            ['Petra Leban',      55], ['Jure Batagelj',   45], ['Sara MarkiÄ',      35],
            ['Bojan Vidmar',     30], ['Katja Novak',      25],
        ];
        $pids = [];
        foreach ($defs as [$name, $pts]) {
            $pids[] = DB::table('players')->insertGetId([
                'p_name' => $name, 'points' => $pts,
                'is_fake' => false, 'created_at' => now(), 'updated_at' => now(),
            ]);
        }
        [$luka,$gregor,$matej,$nina,$simon,$rok,$maja,$tomaz,$andrej,$petra,$jure,$sara,$bojan,$katja] = $pids;

        $bye = DB::table('players')->insertGetId([
            'p_name' => 'NedoloÄen', 'points' => 0,
            'is_fake' => true, 'created_at' => now(), 'updated_at' => now(),
        ]);

        // â”€â”€ LIGA TOLMIN 2026 â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $league = DB::table('leagues')->insertGetId([
            'name'        => 'Liga Tolmin 2026',
            'description' => 'Glavna liga za sezono 2026. Skupinski del z dvema skupinama in izloÄitveni del.',
            'start_date'  => '2026-01-15',
            'end_date'    => '2026-11-30',
            'l_home_page' => true,
            'created_at'  => now(), 'updated_at' => now(),
        ]);

        $pts = 'Zmaga: 3 toÄke Â· Poraz 1:2: 1 toÄka Â· Poraz 0:2: 0 toÄk';

        // â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
        // SKUPINA A â€” 8 players, full round-robin, 28 matches (rounds 1-7)
        // Players: Nejc(1) Luka(2) Gregor(3) Matej(4) Nina(5) Simon(6) Rok(7) Maja(8)
        // Circle-method schedule: fix p8, rotate others
        // â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
        $gA = $this->bracket($league, 'Skupina A', 'A', true, $pts);
        [$a1,$a2,$a3,$a4,$a5,$a6,$a7,$a8] = $this->makeTeams(
            $gA, [$nejcId,$luka,$gregor,$matej,$nina,$simon,$rok,$maja]
        );

        // Round 1: (1,8)(2,7)(3,6)(4,5) â€” all played
        $this->m($gA,$a1,$a8, 6,3, 6,2, null,null,        1); // Nejc def. Maja 2:0
        $this->m($gA,$a2,$a7, 6,4, 4,6, 7,5,        1); // Luka def. Rok 2:1
        $this->m($gA,$a3,$a6, 6,2, 6,3, null,null,        1); // Gregor def. Simon 2:0
        $this->m($gA,$a4,$a5, 7,5, 4,6, 6,4,        1); // Matej def. Nina 2:1

        // Round 2: (2,8)(3,1)(4,7)(5,6) â€” all played
        $this->m($gA,$a2,$a8, 6,1, 6,3, null,null,        2); // Luka def. Maja 2:0
        $this->m($gA,$a3,$a1, 4,6, 6,4, 6,4,        2); // Gregor def. Nejc 2:1
        $this->m($gA,$a4,$a7, 6,3, 6,4, null,null,        2); // Matej def. Rok 2:0 (sets reversed)
        $this->m($gA,$a5,$a6, 6,4, 3,6, 7,5,        2); // Nina def. Simon 2:1

        // Round 3: (3,8)(4,2)(5,1)(6,7) â€” all played
        $this->m($gA,$a3,$a8, 6,2, 6,1, null,null,        3); // Gregor def. Maja 2:0
        $this->m($gA,$a4,$a2, 3,6, 7,5, 6,4,        3); // Matej def. Luka 2:1
        $this->m($gA,$a5,$a1, 4,6, 3,6, null,null,        3); // Nejc def. Nina 2:0
        $this->m($gA,$a6,$a7, 6,4, 6,3, null,null,        3); // Simon def. Rok 2:0

        // Round 4: (4,8)(5,3)(6,2)(7,1) â€” all played
        $this->m($gA,$a4,$a8, 6,0, 6,2, null,null,        4); // Matej def. Maja 2:0
        $this->m($gA,$a5,$a3, 6,4, 2,6, 6,4,        4); // Nina def. Gregor 2:1
        $this->m($gA,$a6,$a2, 4,6, 6,3, 3,6,        4); // Luka def. Simon 2:1
        $this->m($gA,$a7,$a1, 3,6, 4,6, null,null,        4); // Nejc def. Rok 2:0

        // Round 5: (5,8)(6,4)(7,3)(1,2) â€” all played
        $this->m($gA,$a5,$a8, 6,1, 6,3, null,null,        5); // Nina def. Maja 2:0
        $this->m($gA,$a6,$a4, 6,4, 3,6, 6,4,        5); // Simon def. Matej 2:1
        $this->m($gA,$a7,$a3, 6,4, 6,3, null,null,        5); // Rok def. Gregor 2:0
        $this->m($gA,$a1,$a2, 6,4, 7,5, null,null,        5); // Nejc def. Luka 2:0

        // Round 6: (6,8)(7,5)(1,4)(2,3) â€” unplayed
        $this->m($gA,$a6,$a8, null,null, null,null, null,null,        6);
        $this->m($gA,$a7,$a5, null,null, null,null, null,null,        6);
        $this->m($gA,$a1,$a4, null,null, null,null, null,null,        6);
        $this->m($gA,$a2,$a3, null,null, null,null, null,null,        6);

        // Round 7: (7,8)(1,6)(2,5)(3,4) â€” unplayed
        $this->m($gA,$a7,$a8, null,null, null,null, null,null,        7);
        $this->m($gA,$a1,$a6, null,null, null,null, null,null,        7);
        $this->m($gA,$a2,$a5, null,null, null,null, null,null,        7);
        $this->m($gA,$a3,$a4, null,null, null,null, null,null,        7);

        // â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
        // SKUPINA B â€” 8 players, full round-robin, 28 matches (rounds 1-7)
        // Players: Opp(1) TomaÅ¾(2) Andrej(3) Petra(4) Jure(5) Sara(6) Bojan(7) Katja(8)
        // â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
        $gB = $this->bracket($league, 'Skupina B', 'B', true, $pts);
        [$b1,$b2,$b3,$b4,$b5,$b6,$b7,$b8] = $this->makeTeams(
            $gB, [$oppId,$tomaz,$andrej,$petra,$jure,$sara,$bojan,$katja]
        );

        // Round 1 â€” all played
        $this->m($gB,$b1,$b8, 6,4, 6,3, null,null,        1); // Opp def. Katja 2:0
        $this->m($gB,$b2,$b7, 7,5, 6,4, null,null,        1); // TomaÅ¾ def. Bojan 2:0
        $this->m($gB,$b3,$b6, 6,3, 4,6, 6,4,        1); // Andrej def. Sara 2:1
        $this->m($gB,$b4,$b5, 6,2, 6,4, null,null,        1); // Petra def. Jure 2:0

        // Round 2 â€” all played
        $this->m($gB,$b2,$b8, 6,2, 6,1, null,null,        2); // TomaÅ¾ def. Katja 2:0
        $this->m($gB,$b3,$b1, 4,6, 6,3, 6,4,        2); // Andrej def. Opp 2:1
        $this->m($gB,$b4,$b7, 6,4, 6,2, null,null,        2); // Petra def. Bojan 2:0
        $this->m($gB,$b5,$b6, 3,6, 6,4, 6,3,        2); // Jure def. Sara 2:1

        // Round 3 â€” all played
        $this->m($gB,$b3,$b8, 6,3, 6,4, null,null,        3); // Andrej def. Katja 2:0
        $this->m($gB,$b4,$b2, 6,4, 7,5, null,null,        3); // Petra def. TomaÅ¾ 2:0
        $this->m($gB,$b5,$b1, 4,6, 3,6, null,null,        3); // Opp def. Jure 2:0
        $this->m($gB,$b6,$b7, 6,3, 6,4, null,null,        3); // Sara def. Bojan 2:0

        // Round 4 â€” all played
        $this->m($gB,$b4,$b8, 6,1, 6,0, null,null,        4); // Petra def. Katja 2:0
        $this->m($gB,$b5,$b3, 6,4, 3,6, 7,5,        4); // Jure def. Andrej 2:1
        $this->m($gB,$b6,$b2, 6,3, 4,6, 7,5,        4); // Sara def. TomaÅ¾ 2:1
        $this->m($gB,$b7,$b1, 6,4, 7,5, null,null,        4); // Bojan def. Opp 2:0

        // Round 5 â€” all played
        $this->m($gB,$b5,$b8, 6,2, 6,3, null,null,        5); // Jure def. Katja 2:0
        $this->m($gB,$b6,$b4, 4,6, 7,5, 6,4,        5); // Sara def. Petra 2:1
        $this->m($gB,$b7,$b3, 6,3, 6,4, null,null,        5); // Bojan def. Andrej 2:0
        $this->m($gB,$b1,$b2, 6,4, 3,6, 7,5,        5); // Opp def. TomaÅ¾ 2:1

        // Round 6 â€” unplayed
        $this->m($gB,$b6,$b8, null,null, null,null, null,null,        6);
        $this->m($gB,$b7,$b5, null,null, null,null, null,null,        6);
        $this->m($gB,$b1,$b4, null,null, null,null, null,null,        6);
        $this->m($gB,$b2,$b3, null,null, null,null, null,null,        6);

        // Round 7 â€” unplayed
        $this->m($gB,$b7,$b8, null,null, null,null, null,null,        7);
        $this->m($gB,$b1,$b6, null,null, null,null, null,null,        7);
        $this->m($gB,$b2,$b5, null,null, null,null, null,null,        7);
        $this->m($gB,$b3,$b4, null,null, null,null, null,null,        7);

        // â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
        // IZLOÄŒITVENI DEL A â€” 16 teams, 8 rounds, places 1-16
        // Rounds 1-4 empty (byes already happened). Real play from round 5.
        // â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
        $brA = $this->bracket($league, 'IzloÄitveni del A', null, false,
            'Top 8 iz vsake skupine se uvrsti v izloÄitveni del.', 1, 16);

        [$ka1,$ka2,$ka3,$ka4,$ka5,$ka6,$ka7,$ka8,
         $ka9,$ka10,$ka11,$ka12,$ka13,$ka14,$ka15,$ka16] = $this->makeTeams($brA, [
            $nejcId,$luka,$gregor,$matej,$nina,$simon,$rok,$maja,
            $oppId,$tomaz,$andrej,$petra,$jure,$sara,$bojan,$katja,
        ]);

        // Round 5 (Osminafinala): first 4 played, last 4 unplayed
        $this->m($brA,$ka1,$ka16,  6,3, 6,4, null,null,   5, null,'A1','B8');  // Nejc wins
        $this->m($brA,$ka2,$ka15,  7,5, 6,3, null,null,   5, null,'A2','B7');  // Luka wins
        $this->m($brA,$ka3,$ka14,  6,4, 4,6, 7,5,   5, null,'A3','B6');  // Gregor wins
        $this->m($brA,$ka4,$ka13,  6,2, 6,3, null,null,   5, null,'A4','B5');  // Matej wins
        $this->m($brA,$ka5,$ka12,  null,null, null,null, null,null,   5, null,'A5','B4');
        $this->m($brA,$ka6,$ka11,  null,null, null,null, null,null,   5, null,'A6','B3');
        $this->m($brA,$ka7,$ka10,  null,null, null,null, null,null,   5, null,'A7','B2');
        $this->m($brA,$ka8,$ka9,   null,null, null,null, null,null,   5, null,'A8','B1');

        // Round 6 (ÄŒetrtfinale): fake placeholders
        [$f6a1,$f6a2,$f6a3,$f6a4,$f6a5,$f6a6,$f6a7,$f6a8] = array_map(fn() => $this->ft($brA,$bye), range(1,8));
        $this->m($brA,$f6a1,$f6a2, null,null, null,null, null,null,  6, null,'Zm. OF1','Zm. OF8');
        $this->m($brA,$f6a3,$f6a4, null,null, null,null, null,null,  6, null,'Zm. OF2','Zm. OF7');
        $this->m($brA,$f6a5,$f6a6, null,null, null,null, null,null,  6, null,'Zm. OF3','Zm. OF6');
        $this->m($brA,$f6a7,$f6a8, null,null, null,null, null,null,  6, null,'Zm. OF4','Zm. OF5');

        // Round 7 (Polfinale)
        [$f7a1,$f7a2,$f7a3,$f7a4] = array_map(fn() => $this->ft($brA,$bye), range(1,4));
        $this->m($brA,$f7a1,$f7a2, null,null, null,null, null,null,  7, null,'Zm. ÄŒF1','Zm. ÄŒF2');
        $this->m($brA,$f7a3,$f7a4, null,null, null,null, null,null,  7, null,'Zm. ÄŒF3','Zm. ÄŒF4');

        // Round 8 (Finale)
        [$f8a1,$f8a2] = array_map(fn() => $this->ft($brA,$bye), range(1,2));
        $this->m($brA,$f8a1,$f8a2, null,null, null,null, null,null,  8, null,'Zm. PF1','Zm. PF2');

        // â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
        // IZLOÄŒITVENI DEL B â€” 16 teams, 8 rounds, places 1-16
        // All matches unplayed (upcoming bracket)
        // â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
        $brB = $this->bracket($league, 'IzloÄitveni del B', null, false,
            'UteÅ¡eni del izloÄitvenega turnirja.', 1, 16);

        [$kb1,$kb2,$kb3,$kb4,$kb5,$kb6,$kb7,$kb8,
         $kb9,$kb10,$kb11,$kb12,$kb13,$kb14,$kb15,$kb16] = $this->makeTeams($brB, [
            $matej,$nina,$simon,$rok,$maja,$tomaz,$andrej,$petra,
            $jure,$sara,$bojan,$katja,$luka,$gregor,$nejcId,$oppId,
        ]);

        // Round 5 (Osminafinala): all unplayed
        $this->m($brB,$kb1,$kb16,  null,null, null,null, null,null,  5, null,'M1','M16');
        $this->m($brB,$kb2,$kb15,  null,null, null,null, null,null,  5, null,'M2','M15');
        $this->m($brB,$kb3,$kb14,  null,null, null,null, null,null,  5, null,'M3','M14');
        $this->m($brB,$kb4,$kb13,  null,null, null,null, null,null,  5, null,'M4','M13');
        $this->m($brB,$kb5,$kb12,  null,null, null,null, null,null,  5, null,'M5','M12');
        $this->m($brB,$kb6,$kb11,  null,null, null,null, null,null,  5, null,'M6','M11');
        $this->m($brB,$kb7,$kb10,  null,null, null,null, null,null,  5, null,'M7','M10');
        $this->m($brB,$kb8,$kb9,   null,null, null,null, null,null,  5, null,'M8','M9');

        // Round 6
        [$f6b1,$f6b2,$f6b3,$f6b4,$f6b5,$f6b6,$f6b7,$f6b8] = array_map(fn() => $this->ft($brB,$bye), range(1,8));
        $this->m($brB,$f6b1,$f6b2, null,null, null,null, null,null,  6, null,'Zm. OF1','Zm. OF8');
        $this->m($brB,$f6b3,$f6b4, null,null, null,null, null,null,  6, null,'Zm. OF2','Zm. OF7');
        $this->m($brB,$f6b5,$f6b6, null,null, null,null, null,null,  6, null,'Zm. OF3','Zm. OF6');
        $this->m($brB,$f6b7,$f6b8, null,null, null,null, null,null,  6, null,'Zm. OF4','Zm. OF5');

        // Round 7
        [$f7b1,$f7b2,$f7b3,$f7b4] = array_map(fn() => $this->ft($brB,$bye), range(1,4));
        $this->m($brB,$f7b1,$f7b2, null,null, null,null, null,null,  7, null,'Zm. ÄŒF1','Zm. ÄŒF2');
        $this->m($brB,$f7b3,$f7b4, null,null, null,null, null,null,  7, null,'Zm. ÄŒF3','Zm. ÄŒF4');

        // Round 8
        [$f8b1,$f8b2] = array_map(fn() => $this->ft($brB,$bye), range(1,2));
        $this->m($brB,$f8b1,$f8b2, null,null, null,null, null,null,  8, null,'Zm. PF1','Zm. PF2');
    }

    // â”€â”€ Helpers â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€

    private function bracket(int $lid, string $name, ?string $tag, bool $isGroup,
        ?string $ptDesc = null, ?int $from = null, ?int $to = null): int
    {
        return DB::table('brackets')->insertGetId([
            'league_id' => $lid, 'name' => $name, 'tag' => $tag,
            'b_description' => null, 'points_description' => $ptDesc,
            'is_group_stage' => $isGroup, 'places_from' => $from, 'places_to' => $to,
            'created_at' => now(), 'updated_at' => now(),
        ]);
    }

    private function makeTeams(int $bracketId, array $p1Ids): array
    {
        return array_map(fn($pid) => DB::table('teams')->insertGetId([
            'bracket_id' => $bracketId, 'p1_id' => $pid, 'p2_id' => null,
            'name' => null, 'is_fake' => false,
            'created_at' => now(), 'updated_at' => now(),
        ]), $p1Ids);
    }

    private function ft(int $bracketId, int $fakePid): int
    {
        return DB::table('teams')->insertGetId([
            'bracket_id' => $bracketId, 'p1_id' => $fakePid, 'p2_id' => null,
            'name' => null, 'is_fake' => true,
            'created_at' => now(), 'updated_at' => now(),
        ]);
    }

    private function m(int $bid, int $t1, int $t2,
        $t1s1, $t2s1, $t1s2, $t2s2, $t1s3, $t2s3,
        int $round, ?string $exc = null, ?string $t1tag = null, ?string $t2tag = null,
        string $status = 'none', ?int $submitter = null): int
    {
        return DB::table('custom_match_ups')->insertGetId([
            'bracket_id'           => $bid,
            'team1_id'             => $t1,
            'team2_id'             => $t2,
            't1_first_set'         => $t1s1,
            't2_first_set'         => $t2s1,
            't1_second_set'        => $t1s2,
            't2_second_set'        => $t2s2,
            't1_third_set'         => $t1s3,
            't2_third_set'         => $t2s3,
            't1_tag'               => $t1tag,
            't2_tag'               => $t2tag,
            'round'                => $round,
            'exception'            => $exc,
            'result_status'        => $status,
            'submitted_by_user_id' => $submitter,
            'result_submitted_at'  => $submitter ? now() : null,
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);
    }
}


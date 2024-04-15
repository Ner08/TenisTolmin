<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Team;
use App\Models\User;
use App\Models\Event;
use App\Models\League;
use App\Models\Player;
use App\Models\Bracket;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ScoreBoard;
use App\Models\NewsComment;
use App\Models\CustomMatchUp;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $players = [
            ['p_name' => 'Zlatoper Zorko', 'points' => 60],
            ['p_name' => 'Rutar David', 'points' => 45],
            ['p_name' => 'Hvala Aleš', 'points' => 42],
            ['p_name' => 'Kavčič Matej', 'points' => 42],
            ['p_name' => 'Vrčon Erik', 'points' => 42],
            ['p_name' => 'Klanjšček Milan', 'points' => 36],
            ['p_name' => 'Zarli Damijan', 'points' => 34],
            ['p_name' => 'Rutar Tadej', 'points' => 33],
            ['p_name' => 'Maksić Dragan', 'points' => 32],
            ['p_name' => 'Robič Nejc', 'points' => 25],
            ['p_name' => 'Zabelaj Fitim', 'points' => 24],
            ['p_name' => 'Kragelj Rudi ', 'points' => 21],
            ['p_name' => 'Božič Peter', 'points' => 20],
            ['p_name' => 'Žabar Dragan', 'points' => 16],
            ['p_name' => 'Kaltnekar Zorko', 'points' => 15],
            ['p_name' => 'Čujec Patrik', 'points' => 14],
            ['p_name' => 'Pisk Aleš', 'points' => 14],
            ['p_name' => 'Trost Vlado', 'points' => 14],
            ['p_name' => 'Perendija Zala', 'points' => 11],
            ['p_name' => 'Sokanović Dalibor ', 'points' => 10],
            ['p_name' => 'Zlatoper Bor', 'points' => 10],
            ['p_name' => 'Jan Peter', 'points' => 6],
            ['p_name' => 'Pavletič Žiga', 'points' => 6],
            ['p_name' => 'Kragelj Nejc', 'points' => 5],
            ['p_name' => 'Krajnik Erik ', 'points' => 5],
            ['p_name' => 'Munih Staš', 'points' => 5],
            ['p_name' => 'Ozebek Taras', 'points' => 4],
            ['p_name' => 'Šorli Janez', 'points' => 4],
            ['p_name' => 'Perendija Dragan', 'points' => 1],
        ];

        foreach ($players as $playerData) {
            Player::create($playerData);
        }

        User::factory()->create();
        News::factory(20)->create();
        NewsComment::factory(1)->create([
            'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam eos rem culpa architecto nostrum harum dicta ipsa numquam blanditiis. Dolorem est odit dolores quos nesciunt laboriosam. Et eos vero animi.',
            'user_id' => 1,
            'news_id' => 1
        ]);
        Event::factory(15)->create();
        ScoreBoard::factory(30)->create();
        League::factory(3)->create();
        Bracket::factory(9)->create();
        Team::factory(90)->create();
        CustomMatchUp::factory(50)->create();


    }
}

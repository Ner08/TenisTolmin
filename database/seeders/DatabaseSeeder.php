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
use App\Models\Membership;
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
        Player::create([
            'id' => 1,
            'p_name' => 'Nedoločen igralec / ekipa',
            'points' => 0,
            'is_fake' => true
        ]);

        /* User::factory()->create(); */
        /* News::factory(20)->create(); */
        /*  NewsComment::factory(1)->create([
             'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam eos rem culpa architecto nostrum harum dicta ipsa numquam blanditiis. Dolorem est odit dolores quos nesciunt laboriosam. Et eos vero animi.',
             'user_id' => 1,
             'news_id' => 1
         ]); */
        /* Event::factory(15)->create(); */
        /*  League::factory(3)->create(); */
        /*  Bracket::factory(9)->create(); */
        /*  Team::factory(90)->create(); */
        /*  CustomMatchUp::factory(50)->create(); */

        Membership::create([
            'year' => 2024,
            'price_adults' => 100,
            'price_seniors' => 80,
            'price_students' => 65,
            'price_kids' => 35,
            'price_family' => 220,
            'trr' => 'SI56 0475 3000 0388 292',
            'sklic' => 'SI00 2024',
            'namen' => 'Članarina 2024',
            'prejemnik' => 'TENIŠKI KLUB TOLMIN, Dijaška ulica 12 c, 5220 Tolmin'
        ]);

        User::create([
            'name' => 'admin',
            'email' => 'robic.nejc1122@gmail.com',
            'password' => bcrypt('tktolmin2024'),
            'is_admin' => true
        ]);
    }
}

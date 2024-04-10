<?php

namespace Database\Seeders;

use App\Models\Bracket;
use App\Models\CustomMatchUp;
use App\Models\Event;
use App\Models\League;
use App\Models\News;
use App\Models\NewsComment;
use App\Models\ScoreBoard;
use App\Models\Team;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

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

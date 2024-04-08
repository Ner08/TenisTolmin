<?php

namespace App\Http\Controllers;

use App\Models\Bracket;
use App\Models\League;
use Illuminate\Support\Facades\DB;

class LeaguesController extends Controller
{
    public function index()
    {
        // Get the leagues with their brackets and teams
        $leagues = League::with(['brackets.teams'])->get();

        // Calculate the total number of players for each league
        $leagues->each(function ($league) {
            $league->totalPlayers = $league->brackets->sum(function ($bracket) {
                return $bracket->teams->count();
            });
        });

        return view('leagues.index', [
            'leagues' => $leagues,
            'login' => false
        ]);
    }
    public function show(League $league)
    {

        $brackets = Bracket::where('league_id', $league->id)->get();

        return view('leagues.show', [
            'league' => $league,
            'brackets' => $brackets,
            'login' => false
            ]);
    }
    public function showScoreboard()
    {
        $players = [
            ['name' => 'Zlatoper Zorko', 'points' => 60],
            ['name' => 'Rutar David', 'points' => 45],
            ['name' => 'Hvala Aleš', 'points' => 42],
            ['name' => 'Kavčič Matej', 'points' => 42],
            ['name' => 'Vrčon Erik', 'points' => 42],
            ['name' => 'Klanjšček Milan', 'points' => 36],
            ['name' => 'Zarli Damijan', 'points' => 34],
            ['name' => 'Rutar Tadej', 'points' => 33],
            ['name' => 'Maksić Dragan', 'points' => 32],
            ['name' => 'Robič Nejc', 'points' => 25],
            ['name' => 'Zabelaj Fitim', 'points' => 24],
            ['name' => 'Kragelj Rudi ', 'points' => 21],
            ['name' => 'Božič Peter', 'points' => 20],
            ['name' => 'Žabar Dragan', 'points' => 16],
            ['name' => 'Kaltnekar Zorko', 'points' => 15],
            ['name' => 'Čujec Patrik', 'points' => 14],
            ['name' => 'Pisk Aleš', 'points' => 14],
            ['name' => 'Trost Vlado', 'points' => 14],
            ['name' => 'Perendija Zala', 'points' => 11],
            ['name' => 'Sokanović Dalibor ', 'points' => 10],
            ['name' => 'Zlatoper Bor', 'points' => 10],
            ['name' => 'Jan Peter', 'points' => 6],
            ['name' => 'Pavletič Žiga', 'points' => 6],
            ['name' => 'Kragelj Nejc', 'points' => 5],
            ['name' => 'Krajnik Erik ', 'points' => 5],
            ['name' => 'Munih Staš', 'points' => 5],
            ['name' => 'Ozebek Taras', 'points' => 4],
            ['name' => 'Šorli Janez', 'points' => 4],
            ['name' => 'Perendija Dragan', 'points' => 1],
            // Add more players as needed
        ];

        return view('leagues.scoreboard', [
            'players' => $players,
            'login' => false
        ]);
    }
}

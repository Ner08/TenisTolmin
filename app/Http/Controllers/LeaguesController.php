<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\League;
use App\Models\Bracket;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'login' => false,
            'admin' => true
        ]);
    }
    public function show(League $league)
    {

        $brackets = Bracket::where('league_id', $league->id)->where('is_group_stage', false)->get();
        $brackets_groupstage = Bracket::where('league_id', $league->id)->where('is_group_stage', true)->get();

        // Check if the user is on a mobile device
        $isMobile = $this->isMobileDevice();

        return view('leagues.show', [
            'league' => $league,
            'brackets' => $brackets,
            'brackets_group' => $brackets_groupstage,
            'login' => false,
            'isMobile' => $isMobile,
            'admin' => true
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
            'login' => false,
            'admin' => true
        ]);
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'name' => ['required', 'unique:leagues', 'max:40'],
            'description' => ['required', 'max:500'],
            'short_description' => 'max:200',
            'start_date' => ['required']
        ]);
        $league = League::create($validated_data);

        return back()->with(['flash' => $league->id, 'message' => 'Liga ali turnir uspešno ustvarjen(a). Želite ustvariti skupine v ligi ali turnirju?', 'route' => 'bracket_setup', 'model' => 'league']);
    }

    public function bracket_store(Request $request)
    {
        $validated_data_bracket = $request->validate([
            'name' => [
                'required',
                Rule::unique('brackets')->where(function ($query) use ($request) {
                    return $query->where('league_id', $request->league_id);
                }),
                'max:40'
            ],
            'description' => ['required', 'max:500'],
            'is_group_stage' => ['boolean'],
            'league_id' => ['required', 'integer'],
        ]);

        $validated_data_teams = $request->validate([
            'teams' => ['required', 'array'],
            'teams.*.name' => ['required', 'string', 'max:255'],
            'teams.*.player_ids' => ['required', 'array'],
            'teams.*.player_ids.0' => ['required', 'integer'],
            'teams.*.player_ids.1' => ['sometimes'],
        ]);

        $validated_data_teams_compressed = $validated_data_teams['teams'];

        $bracket = Bracket::create($validated_data_bracket);

        foreach ($validated_data_teams_compressed as &$team) {
            $player1_id = $team['player_ids'][0];
            $player2_id = $team['player_ids'][1] ?? null;
            $data = [
                'name' => $team['name'],
                'bracket_id' => $bracket->id,
                'p1_id' => $player1_id,
                'p2_id' => $player2_id,
            ];
            Team::create($data);
        }

        // Set flash message and redirect
        return back()->with([
            'flash' => $bracket->id,
            'message' => 'Skupina uspešno ustvarjen(a). Želite ustvariti tekme v skupini?',
            'route' => 'matchup_setup',
            'model' => 'bracket'
        ]);
    }


    // Function to check if the user is on a mobile device
    private function isMobileDevice()
    {
        return preg_match('/(android|iphone|ipad|ipod)/i', request()->header('User-Agent'));
    }
}

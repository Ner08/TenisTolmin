<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\League;
use App\Models\Player;
use App\Models\Bracket;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\StoreLeagueRequest;
use App\Models\CustomMatchUp;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Route;

class LeaguesController extends Controller
{
    public function index()
    {
        // Get the leagues with their brackets (without teams)
        $leagues = League::with('brackets')->get();

        // Paginate the leagues
        $currentPage = request()->get('page') ?: 1;
        $perPage = 9; // Adjust as needed
        $path = Route::currentRouteName(); // Get the current route name
        $paginatedLeagues = new LengthAwarePaginator(
            $leagues->forPage($currentPage, $perPage),
            $leagues->count(),
            $perPage,
            $currentPage,
            ['path' => $path] // Specify the route
        );

        // Eager load teams for the paginated brackets
        foreach ($paginatedLeagues as $league) {
            $league->brackets->load('teams');
        }

        // Calculate the total number of players for each league
        $paginatedLeagues->each(function ($league) {
            $league->totalPlayers = $league->brackets->sum(function ($bracket) {
                return $bracket->teams->count();
            });
        });

        return view('leagues.index', [
            'leagues' => $paginatedLeagues,
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

    public function destroy(League $league)
    {
        $league->delete();

        return back()->with(['message' => 'Liga ali turnir zbrisan(a)']);
    }

    public function showScoreboard()
    {
        return view('leagues.scoreboard', [
            'players' => Player::where('is_fake', false)->orderByDesc('points')->get(),
            'login' => false,
            'admin' => true,
            'maxPoints' => Player::where('is_fake', false)->max('points')
        ]);
    }

    public function store(StoreLeagueRequest $request)
    {
        /* $league =  */
        League::create($request->validated());

        return back()->with(['message' => 'Liga ali turnir uspešno ustvarjen(a)']);
    }

    public function bracket_store(Request $request)
    {
        $validated_data_bracket = $request->validate([
            'name' => [
                'required',
                'max:40'
            ],
            'b_description' => 'max:500',
            'tag' => 'max:5',
            'is_group_stage' => ['boolean'],
            'league_id' => ['required', 'integer'],
        ]);

        // If 'is_group_stage' is true, make 'tag' required
        if ($request->input('is_group_stage')) {
            $validated_data_bracket = $request->validate([
                'tag' => ['required', 'max:5'],
            ]);
        }

        $validated_data_teams = $request->validate([
            'teams' => ['required', 'array'],
            'teams.*.name' => ['max:50'],
            'teams.*.player_ids' => ['required', 'array'],
            'teams.*.player_ids.0' => ['required', 'integer'],
            'teams.*.player_ids.1' => ['sometimes'],
        ]);

        $validated_data_teams_compressed = $validated_data_teams['teams'];

        $bracket = Bracket::create($validated_data_bracket);

        Team::create([
            'name' => 'Nedoločen igralec / ekipa',
            'p1_id' => 1,
            'bracket_id' => $bracket->id,
            'is_fake' => true
        ]);

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
        return back()->with(['message' => 'Skupina uspešno ustvarjena']);
    }
    public function matchup_store(Request $request)
    {
        /* dd($request); */
        $validated_data = $request->validate([
            'team1_id' => 'integer|required_without:t1_tag',
            't1_tag' => 'nullable|required_without:team1_id',
            'team2_id' => 'integer|required_without:t2_tag',
            't2_tag' => 'nullable|required_without:team2_id',
            't1_first_set' => 'nullable|integer',
            't2_first_set' => 'nullable|integer',
            't1_second_set' => 'nullable|integer',
            't2_second_set' => 'nullable|integer',
            't1_third_set' => 'nullable|integer',
            't2_third_set' => 'nullable|integer',
            'round' => 'required|integer',
            'exception' => 'string|max:30',
            'bracket_id' => ['required', 'integer']
        ]);

        CustomMatchUp::create($validated_data);

        // Set flash message and redirect
        return back()->with(['message' => 'Igra uspešno ustvarjena']);
    }

    public function bracket_destroy(Bracket $bracket)
    {
        $bracket->delete();
        return back()->with(['message' => 'Skupina zbrisana.']);
    }

    public function matchup_destroy(CustomMatchUp $matchup)
    {
        $matchup->delete();
        return back()->with(['message' => 'Igra zbrisana.']);
    }

    // Function to check if the user is on a mobile device
    private function isMobileDevice()
    {
        return preg_match('/(android|iphone|ipad|ipod)/i', request()->header('User-Agent'));
    }
}

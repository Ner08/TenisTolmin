<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\League;
use App\Models\Player;
use App\Models\Bracket;
use Illuminate\Http\Request;
use App\Models\CustomMatchUp;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\EditLeagueRequest;
use App\Http\Requests\StoreLeagueRequest;
use App\Http\Requests\StoreMatchupRequest;
use Illuminate\Pagination\LengthAwarePaginator;

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
            'isMobile' => $isMobile,
        ]);
    }

    public function store(StoreLeagueRequest $request)
    {
        /* $league =  */
        League::create($request->validated());

        return back()->with(['message' => 'Liga ali turnir uspešno ustvarjen(a)']);
    }

    public function edit(League $league, EditLeagueRequest $request)
    {
        // Validate the request data
        $validatedData = $request->validated();

        // Update the league with the validated data
        $league->update($validatedData);

        // Redirect back with a success message
        return back()->with(['message' => 'Liga uspešno posodobljena']);
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
            'maxPoints' => Player::where('is_fake', false)->max('points')
        ]);
    }

    public function bracket_store(Request $request)
    {

        if ($request->input('is_group_stage') !== NULL && $request->input('is_group_stage')) {
            $validated_data_bracket = $request->validate([
                'name' => [
                    'required',
                    'max:40'
                ],
                'tag' => ['required', 'max:5'],
                'b_description' => 'max:500',
                'is_group_stage' => ['boolean'],
                'league_id' => ['required', 'integer'],
            ]);
        } else {
            $validated_data_bracket = $request->validate([
                'name' => [
                    'required',
                    'max:40'
                ],
                'points_description' => ['required', 'string'],
                'b_description' => 'max:500',
                'is_group_stage' => ['boolean'],
                'league_id' => ['required', 'integer'],
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
    public function bracket_edit(Request $request, Bracket $bracket)
    {
        if ($request->input('is_group_stage')) {
            $validated_data_bracket = $request->validate([
                'name' => [
                    'required',
                    'max:40'
                ],
                'tag' => ['required', 'max:5'],
                'b_description' => 'max:500',
                'is_group_stage' => ['boolean'],
                'league_id' => ['required', 'integer'],
            ]);
        } else {
            $validated_data_bracket = $request->validate([
                'name' => [
                    'required',
                    'max:40'
                ],
                'points_description' => ['required', 'string'],
                'b_description' => 'max:500',
                'is_group_stage' => ['boolean'],
                'league_id' => ['required', 'integer'],
            ]);
        }

        $bracket->update($validated_data_bracket);

        // Check if teams array exists in the request
        if ($request->has('teams')) {
            // Validate the request data for teams
            $validated_data_teams = $request->validate([
                'teams' => ['array'],
                'teams.*.id' => ['sometimes', 'integer'],
                'teams.*.name' => ['nullable', 'max:50'], // Allow null values for name field
                'teams.*.player_ids' => ['required', 'array'],
                'teams.*.player_ids.0' => ['required', 'integer'],
                'teams.*.player_ids.1' => ['sometimes'],
            ]);

            // Retrieve the teams data from the request
            $teamsData = $validated_data_teams['teams'];

            // Remove existing matchups involving deleted teams
            $deletedTeamIds = collect($bracket->teams()->pluck('id'))->diff(collect($teamsData)->pluck('id'))->toArray();
            // Find the ID of the "Nedoločen igralec / ekipa" team associated with the same bracket
            $placeholderTeamId = Team::where('name', 'Nedoločen igralec / ekipa')
                ->where('bracket_id', $bracket->id)
                ->value('id');

            // Update custom matchups with team1_id or team2_id in $deletedTeamIds
            CustomMatchUp::whereIn('team1_id', $deletedTeamIds)->orWhereIn('team2_id', $deletedTeamIds)
                ->each(function ($matchUp) use ($deletedTeamIds, $placeholderTeamId) {
                    if (in_array($matchUp->team1_id, $deletedTeamIds) && $placeholderTeamId) {
                        $matchUp->team1_id = $placeholderTeamId;
                    }
                    if (in_array($matchUp->team2_id, $deletedTeamIds) && $placeholderTeamId) {
                        $matchUp->team2_id = $placeholderTeamId;
                    }
                    $matchUp->save();
                });

            // Delete the custom matchups where both team1_id and team2_id are null (no placeholder team found)
            CustomMatchUp::whereNull('team1_id')->whereNull('team2_id')->delete();
            // Delete the teams
            Team::where('is_fake', false)->whereIn('id', $deletedTeamIds)->delete();

            // Loop through the teams data
            foreach ($teamsData as $teamData) {
                // Check if the team has an 'id', indicating it existed before
                if (isset($teamData['id'])) {
                    // Update the existing team
                    $team = Team::find($teamData['id']);
                    $team->update([
                        'name' => $teamData['name'],
                        'p1_id' => $teamData['player_ids'][0],
                        'p2_id' => $teamData['player_ids'][1] ?? null,
                    ]);
                } else {
                    // Create a new team
                    Team::create([
                        'name' => $teamData['name'],
                        'bracket_id' => $bracket->id,
                        'p1_id' => $teamData['player_ids'][0],
                        'p2_id' => $teamData['player_ids'][1] ?? null,
                    ]);
                }
            }
        } else {
            // If teams array doesn't exist, delete all teams associated with the bracket
            $bracket->teams()->where('is_fake', false)->delete();
        }

        // Set flash message and redirect
        return back()->with(['message' => 'Skupina uspešno posodobljena']);
    }


    public function matchup_store(StoreMatchupRequest $request)
    {
        $validated_data = $request->validated();

        CustomMatchUp::create($validated_data);

        // Set flash message and redirect
        return back()->with(['message' => 'Igra uspešno ustvarjena']);
    }
    public function matchup_edit(CustomMatchUp $customMatchup, StoreMatchupRequest $request)
    {
        $validated_data = $request->validated();
        $customMatchup->update($validated_data);

        $bracket_id = $request->input('bracket_id');
        $bracket = Bracket::findOrFail($bracket_id);

        // Set flash message and redirect
        return redirect()->route('matchup_setup', ['bracket' => $bracket])->with(['message' => 'Igra uspešno posodobljena']);
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

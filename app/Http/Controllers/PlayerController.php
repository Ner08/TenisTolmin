<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use App\Models\CustomMatchUp;
use Illuminate\Http\Request;
use App\Http\Requests\PlayerRequest;

class PlayerController extends Controller
{
    public function show(Player $player)
    {
        if ($player->is_fake) {
            abort(404);
        }

        $teamIds = Team::where('p1_id', $player->id)
            ->orWhere('p2_id', $player->id)
            ->pluck('id');

        $teams = Team::whereIn('id', $teamIds)
            ->with(['bracket.league', 'player1', 'player2'])
            ->get()
            ->keyBy('id');

        $matchups = CustomMatchUp::whereIn('team1_id', $teamIds)
            ->orWhereIn('team2_id', $teamIds)
            ->get();

        $opponentIds = $matchups->flatMap(fn($m) => [$m->team1_id, $m->team2_id])
            ->unique()
            ->diff($teamIds);

        $opponents = Team::whereIn('id', $opponentIds)
            ->with(['player1', 'player2'])
            ->get()
            ->keyBy('id');

        $matchHistory = [];
        $wins = 0;
        $losses = 0;

        foreach ($matchups as $matchup) {
            if (!$matchup->game_played()) continue;

            $isTeam1 = $teamIds->contains($matchup->team1_id);
            $myTeam  = $isTeam1 ? $teams->get($matchup->team1_id) : $teams->get($matchup->team2_id);
            $opponent = $isTeam1 ? $opponents->get($matchup->team2_id) : $opponents->get($matchup->team1_id);

            if (!$myTeam || !$opponent) continue;

            $won = $isTeam1 ? $matchup->winner() : !$matchup->winner();

            if ($won) $wins++;
            else $losses++;

            $matchHistory[] = [
                'matchup'  => $matchup,
                'opponent' => $opponent,
                'won'      => $won,
                'is_team1' => $isTeam1,
                'bracket'  => $myTeam->bracket,
                'league'   => $myTeam->bracket?->league,
            ];
        }

        $played = $wins + $losses;
        $winRate = $played > 0 ? round(($wins / $played) * 100) : 0;

        return view('players.show', compact('player', 'matchHistory', 'wins', 'losses', 'played', 'winRate'));
    }

    public function store(PlayerRequest $request)
    {
        // Create player
        Player::create($request->validated());

        return back()->with(['message' => 'Igralec uspešno ustvarjen']);
    }

    public function add_points(Request $request, $player_id)
    {
        $request->validate([
            'points' => ['required', 'integer', 'min:-10000', 'max:10000'],
        ]);

        $player = Player::findOrFail($player_id);
        $player->points += $request->integer('points');
        $player->save();

        return back()->with(['message' => 'Točke uspešno dodane.'], 200);
    }

    public function edit(Player $player, PlayerRequest $request)
    {
        $player->update($request->validated());

        return redirect()->route('admin')->with(['message' => 'Igralec uspešno posodobljen.'], 200);
    }

    public function destroy(Player $player)
    {
        // Delete player
        $player->delete();

        return back()->with(['message' => 'Igralec uspešno izbrisan.']);
    }
}

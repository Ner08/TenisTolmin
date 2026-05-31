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

        // Set and game stats
        $setsWon = 0; $setsLost = 0; $gamesWon = 0; $gamesLost = 0;
        foreach ($matchHistory as $entry) {
            $m = $entry['matchup'];
            $isT1 = $entry['is_team1'];
            $setsWon   += $isT1 ? $m->t1SetsWon()  : $m->t2SetsWon();
            $setsLost  += $isT1 ? $m->t2SetsWon()  : $m->t1SetsWon();
            foreach ([[$m->t1_first_set,$m->t2_first_set],[$m->t1_second_set,$m->t2_second_set],[$m->t1_third_set,$m->t2_third_set]] as [$g1,$g2]) {
                if ($g1 === null) continue;
                $gamesWon  += $isT1 ? $g1 : $g2;
                $gamesLost += $isT1 ? $g2 : $g1;
            }
        }

        // Head-to-head per opponent player
        $h2h = [];
        foreach ($matchHistory as $entry) {
            $opp = $entry['opponent'];
            $oppPlayer = $opp->player1 ?? null;
            if (!$oppPlayer || $oppPlayer->is_fake) continue;
            $key = $oppPlayer->id;
            if (!isset($h2h[$key])) {
                $h2h[$key] = ['player' => $oppPlayer, 'wins' => 0, 'losses' => 0];
            }
            $entry['won'] ? $h2h[$key]['wins']++ : $h2h[$key]['losses']++;
        }
        usort($h2h, fn($a, $b) => ($b['wins'] + $b['losses']) - ($a['wins'] + $a['losses']));

        // Form guide — last 10 matches chronologically
        $formGuide = array_slice(array_reverse($matchHistory), 0, 10);

        // Per-league chart data
        $leagueStats = [];
        foreach ($matchHistory as $entry) {
            $leagueName = $entry['league']?->name ?? 'Ostalo';
            if (!isset($leagueStats[$leagueName])) {
                $leagueStats[$leagueName] = ['wins' => 0, 'losses' => 0];
            }
            $entry['won'] ? $leagueStats[$leagueName]['wins']++ : $leagueStats[$leagueName]['losses']++;
        }

        // Rolling win rate (cumulative) for line chart
        $rollingForm = [];
        $cumWins = 0;
        foreach (array_reverse($matchHistory) as $i => $entry) {
            $cumWins += $entry['won'] ? 1 : 0;
            $rollingForm[] = round(($cumWins / ($i + 1)) * 100);
        }

        return view('players.show', compact(
            'player', 'matchHistory', 'wins', 'losses', 'played', 'winRate',
            'setsWon', 'setsLost', 'gamesWon', 'gamesLost', 'h2h', 'formGuide',
            'leagueStats', 'rollingForm'
        ));
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

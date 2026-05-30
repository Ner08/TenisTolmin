<?php

namespace App\Http\Controllers;

use App\Mail\MatchResultSubmittedMail;
use App\Models\AppNotification;
use App\Models\CustomMatchUp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MatchResultController extends Controller
{
    public function store(Request $request, CustomMatchUp $matchup)
    {
        $request->validate([
            't1_first_set'  => ['required', 'integer', 'min:0', 'max:99'],
            't2_first_set'  => ['required', 'integer', 'min:0', 'max:99'],
            't1_second_set' => ['required', 'integer', 'min:0', 'max:99'],
            't2_second_set' => ['required', 'integer', 'min:0', 'max:99'],
            't1_third_set'  => ['nullable', 'integer', 'min:0', 'max:99'],
            't2_third_set'  => ['nullable', 'integer', 'min:0', 'max:99'],
        ]);

        $authPlayerId = auth()->user()->player_id;
        abort_unless($authPlayerId, 403, 'Vaš račun ni povezan z igralskim profilom.');
        abort_unless(
            in_array($matchup->result_status, ['none']) && !$matchup->game_played()
                || ($matchup->result_status === 'pending' && auth()->id() === $matchup->submitted_by_user_id),
            403,
            'Tega rezultata ne morete oddati.'
        );

        $team1 = $matchup->team1_id ? \App\Models\Team::find($matchup->team1_id) : null;
        $team2 = $matchup->team2_id ? \App\Models\Team::find($matchup->team2_id) : null;

        $userInTeam1 = $team1 && in_array($authPlayerId, array_filter([$team1->p1_id, $team1->p2_id]));
        $userInTeam2 = $team2 && in_array($authPlayerId, array_filter([$team2->p1_id, $team2->p2_id]));
        abort_unless($userInTeam1 || $userInTeam2, 403, 'Niste v tej tekmi.');

        $matchup->update([
            't1_first_set'          => $request->t1_first_set,
            't2_first_set'          => $request->t2_first_set,
            't1_second_set'         => $request->t1_second_set,
            't2_second_set'         => $request->t2_second_set,
            't1_third_set'          => $request->t1_third_set,
            't2_third_set'          => $request->t2_third_set,
            'result_status'         => 'pending',
            'submitted_by_user_id'  => auth()->id(),
            'result_submitted_at'   => now(),
        ]);

        // Notify the opponent player's user
        $opponentTeam  = $userInTeam1 ? $team2 : $team1;
        $t1Name = $team1?->playerNames() ?? '?';
        $t2Name = $team2?->playerNames() ?? '?';

        $leagueUrl = null;
        $bracket = \App\Models\Bracket::find($matchup->bracket_id);
        if ($bracket) $leagueUrl = route('league', $bracket->league_id);

        $opponentUserFound = false;

        if ($opponentTeam) {
            foreach (array_filter([$opponentTeam->p1_id, $opponentTeam->p2_id]) as $pid) {
                $opponentUser = User::where('player_id', $pid)
                    ->where('registration_status', 'approved')
                    ->first();
                if ($opponentUser) {
                    $opponentUserFound = true;
                    Mail::to($opponentUser->email)->send(
                        new MatchResultSubmittedMail(auth()->user()->name, $matchup, $t1Name, $t2Name)
                    );
                    AppNotification::notify(
                        $opponentUser->id,
                        'result_pending',
                        'Nov rezultat čaka potrditev',
                        auth()->user()->name . ' je oddal rezultat: ' . $t1Name . ' vs ' . $t2Name . ' (' . $matchup->endResult . ')',
                        $leagueUrl
                    );
                }
            }
        }

        // No opponent user account — send to admin for review
        if (!$opponentUserFound) {
            $matchup->update(['result_status' => 'admin_review']);
            $message = 'Rezultat oddan. Nasprotnik nima računa — admin bo potrdil rezultat.';
        } else {
            $message = 'Rezultat oddan. Čakate na potrditev nasprotnika.';
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return back()->with('message', $message);
    }

    public function confirm(CustomMatchUp $matchup)
    {
        $authPlayerId = auth()->user()->player_id;
        abort_unless($authPlayerId && $matchup->result_status === 'pending', 403);
        abort_unless(auth()->id() !== $matchup->submitted_by_user_id, 403, 'Ne morete potrditi lastnega rezultata.');

        $team1 = \App\Models\Team::find($matchup->team1_id);
        $team2 = \App\Models\Team::find($matchup->team2_id);
        $inTeam1 = $team1 && in_array($authPlayerId, array_filter([$team1->p1_id, $team1->p2_id]));
        $inTeam2 = $team2 && in_array($authPlayerId, array_filter([$team2->p1_id, $team2->p2_id]));
        abort_unless($inTeam1 || $inTeam2, 403);

        $matchup->update(['result_status' => 'confirmed']);

        $submitter = $matchup->submittedByUser;
        if ($submitter) {
            $bracket = \App\Models\Bracket::find($matchup->bracket_id);
            $t1 = \App\Models\Team::find($matchup->team1_id);
            $t2 = \App\Models\Team::find($matchup->team2_id);
            AppNotification::notify(
                $submitter->id,
                'result_confirmed',
                'Rezultat potrjen',
                auth()->user()->name . ' je potrdil rezultat: ' . ($t1?->playerNames() ?? '?') . ' vs ' . ($t2?->playerNames() ?? '?') . ' (' . $matchup->endResult . ')',
                $bracket ? route('league', $bracket->league_id) : null
            );
        }

        return back()->with('message', 'Rezultat potrjen.');
    }

    public function dispute(CustomMatchUp $matchup)
    {
        $authPlayerId = auth()->user()->player_id;
        abort_unless($authPlayerId && $matchup->result_status === 'pending', 403);
        abort_unless(auth()->id() !== $matchup->submitted_by_user_id, 403);

        $team1 = \App\Models\Team::find($matchup->team1_id);
        $team2 = \App\Models\Team::find($matchup->team2_id);
        $inTeam1 = $team1 && in_array($authPlayerId, array_filter([$team1->p1_id, $team1->p2_id]));
        $inTeam2 = $team2 && in_array($authPlayerId, array_filter([$team2->p1_id, $team2->p2_id]));
        abort_unless($inTeam1 || $inTeam2, 403);

        $matchup->update(['result_status' => 'disputed']);

        $submitter = $matchup->submittedByUser;
        if ($submitter) {
            $bracket = \App\Models\Bracket::find($matchup->bracket_id);
            $t1 = \App\Models\Team::find($matchup->team1_id);
            $t2 = \App\Models\Team::find($matchup->team2_id);
            AppNotification::notify(
                $submitter->id,
                'result_disputed',
                'Rezultat označen kot sporen',
                auth()->user()->name . ' je označil rezultat kot sporen: ' . ($t1?->playerNames() ?? '?') . ' vs ' . ($t2?->playerNames() ?? '?') . ' (' . $matchup->endResult . ')',
                $bracket ? route('league', $bracket->league_id) : null
            );
        }

        return back()->with('message', 'Rezultat označen kot sporen. Administrator bo odločil.');
    }

    public function adminConfirm(Request $request, CustomMatchUp $matchup)
    {
        $data = ['result_status' => 'confirmed'];

        if ($request->has('t1_first_set')) {
            $request->validate([
                't1_first_set'  => ['required', 'integer', 'min:0', 'max:99'],
                't2_first_set'  => ['required', 'integer', 'min:0', 'max:99'],
                't1_second_set' => ['required', 'integer', 'min:0', 'max:99'],
                't2_second_set' => ['required', 'integer', 'min:0', 'max:99'],
                't1_third_set'  => ['nullable', 'integer', 'min:0', 'max:99'],
                't2_third_set'  => ['nullable', 'integer', 'min:0', 'max:99'],
            ]);
            $data += [
                't1_first_set'  => $request->t1_first_set,
                't2_first_set'  => $request->t2_first_set,
                't1_second_set' => $request->t1_second_set,
                't2_second_set' => $request->t2_second_set,
                't1_third_set'  => $request->t1_third_set ?: null,
                't2_third_set'  => $request->t2_third_set ?: null,
                'submitted_by_user_id' => auth()->id(),
                'result_submitted_at'  => now(),
            ];
        }

        $matchup->update($data);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('message', 'Rezultat potrjen s strani admina.');
    }

    public function adminClear(CustomMatchUp $matchup)
    {
        $matchup->update([
            'result_status'        => 'none',
            'submitted_by_user_id' => null,
            'result_submitted_at'  => null,
            't1_first_set'  => null, 't2_first_set'  => null,
            't1_second_set' => null, 't2_second_set' => null,
            't1_third_set'  => null, 't2_third_set'  => null,
        ]);
        return back()->with('message', 'Rezultat ponastavljen.');
    }
}

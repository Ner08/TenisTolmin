@foreach ($brackets as $key => $bracket)
    @php
        $lastRound = $bracket->matchUps->max('round');
    @endphp

    {{-- Standings table --}}
    <div class="overflow-x-auto">
        <table class="w-full bg-white divide-y divide-gray-100">
            <thead>
                <tr class="bg-gray-100 text-gray-500 text-xs font-semibold uppercase tracking-wide border-b border-gray-200">
                    <th class="px-3 py-2.5 text-left">#</th>
                    <th class="px-3 py-2.5 text-left">Ime</th>
                    <th class="px-3 py-2.5 text-center">Status</th>
                    <th class="px-3 py-2.5 text-center">Tekme</th>
                    <th class="px-3 py-2.5 text-center">Seti</th>
                    <th class="px-3 py-2.5 text-center">Gemi</th>
                    <th class="px-3 py-2.5 text-center">Točke</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-xs">
                @php
                    $sortedTeams = $bracket->teams->where('is_fake', false)->sortByDesc(function ($team) {
                        return [$team->group_points(), $team->group_set_delta(), $team->group_game_delta()];
                    });
                    $total = $sortedTeams->count();
                @endphp
                @foreach ($sortedTeams as $team)
                    @php
                        $p1 = $team->player1; $p2 = $team->player2;
                        $pUrl = fn($p) => route('player.show', $p->id);
                        $team_name = isset($team->name)
                            ? $team->name . '<span class="text-amber-500"> (' . $p1->ranking() . ')</span>'
                            : (isset($p2)
                                ? '<a href="' . $pUrl($p1) . '" class="hover:text-amber-600 transition-colors">' . e($p1->p_name) . '</a><span class="text-amber-500"> (' . $p1->ranking() . ')</span>, <a href="' . $pUrl($p2) . '" class="hover:text-amber-600 transition-colors">' . e($p2->p_name) . '</a><span class="text-amber-500"> (' . $p2->ranking() . ')</span>'
                                : '<a href="' . $pUrl($p1) . '" class="hover:text-amber-600 transition-colors">' . e($p1->p_name) . '</a><span class="text-amber-500"> (' . $p1->ranking() . ')</span>');
                        $playedMatchupsCount = $team->matchups->filter(fn($m) => $m->game_played())->count();
                        $zoneInfo = $bracket->zoneInfo($loop->iteration, $total);
                    @endphp
                    <tr class="hover:bg-amber-50 transition-colors {{ $loop->first ? 'bg-amber-50/30' : '' }}">
                        <td class="px-3 py-2 font-semibold text-gray-700">{!! $bracket->tag . $loop->iteration !!}</td>
                        <td class="px-3 py-2 text-gray-900">{!! $team_name !!}</td>
                        <td class="px-3 py-2 text-center">
                            @if ($zoneInfo)
                                <span @class([
                                    'inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold whitespace-nowrap',
                                    'bg-green-100 text-green-800' => $zoneInfo['color'] === 'green',
                                    'bg-orange-100 text-orange-800' => $zoneInfo['color'] === 'orange',
                                    'bg-red-100 text-red-800' => $zoneInfo['color'] === 'red',
                                ])>{{ $zoneInfo['label'] }}</span>
                            @endif
                        </td>
                        <td class="px-3 py-2 text-center text-gray-600">{{ $playedMatchupsCount }}</td>
                        <td class="px-3 py-2 text-center text-gray-600">{{ $team->group_set_delta() }}</td>
                        <td class="px-3 py-2 text-center text-gray-600">{{ $team->group_game_delta() }}</td>
                        <td class="px-3 py-2 text-center font-bold text-amber-700">{{ $team->group_points() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Match rounds --}}
    @foreach ($bracket->matchUps->sortBy('round')->groupBy('round') as $key => $match)
        <div class="px-4 py-2.5 bg-gray-100 border-y border-gray-200 flex items-center gap-2">
            <span class="text-xs font-bold text-gray-700 uppercase tracking-widest">{{ $key . '. Kolo' }}</span>
        </div>
        <div class="grid grid-cols-1 gap-2 p-3">
            @foreach ($bracket->matchUps->where('round', $key) as $match)
                @php
                    $team1 = App\Models\Team::where('id', $match->team1_id)->first();
                    $t1p1 = $team1->player1; $t1p2 = $team1->player2;
                    $team2 = App\Models\Team::where('id', $match->team2_id)->first();
                    $t2p1 = $team2->player1; $t2p2 = $team2->player2;
                    $t1_name = isset($t1p2) ? $t1p1->p_name . ', ' . $t1p2->p_name : $t1p1->p_name;
                    $t2_name = isset($t2p2) ? $t2p1->p_name . ', ' . $t2p2->p_name : $t2p1->p_name;
                    $pLink = fn($p) => '<a href="' . route('player.show', $p->id) . '" class="hover:text-amber-600 transition-colors">' . e($p->p_name) . '</a>';
                    $t1_display = isset($t1p2) ? $pLink($t1p1) . ', ' . $pLink($t1p2) : $pLink($t1p1);
                    $t2_display = isset($t2p2) ? $pLink($t2p1) . ', ' . $pLink($t2p2) : $pLink($t2p1);
                    $winner = $match->winner() ?? null;
                    $t1_sets_won = $match->t1SetsWon();
                    $t2_sets_won = $match->t2SetsWon();
                    $game_played = $match->game_played();
                @endphp
                @php
                    $t1Win = $game_played && isset($winner) && $winner;
                    $t2Win = $game_played && isset($winner) && !$winner;
                @endphp
                <div class="relative bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                    <div class="flex items-center gap-2 px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-medium text-gray-900 flex-1 min-w-0 truncate">{!! $t1_display !!}</p>
                        <span @class(['text-sm font-bold w-7 h-7 flex items-center justify-center rounded-full flex-shrink-0', 'bg-green-500 text-white' => $t1Win, 'bg-red-400 text-white' => $game_played && !$t1Win && isset($winner), 'bg-gray-100 text-gray-500' => $game_played && !isset($winner), 'bg-gray-100 text-gray-300' => !$game_played])>{{ $game_played ? $t1_sets_won : '–' }}</span>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-3">
                        <p class="text-sm font-medium text-gray-900 flex-1 min-w-0 truncate">{!! $t2_display !!}</p>
                        <span @class(['text-sm font-bold w-7 h-7 flex items-center justify-center rounded-full flex-shrink-0', 'bg-green-500 text-white' => $t2Win, 'bg-red-400 text-white' => $game_played && !$t2Win && isset($winner), 'bg-gray-100 text-gray-500' => $game_played && !isset($winner), 'bg-gray-100 text-gray-300' => !$game_played])>{{ $game_played ? $t2_sets_won : '–' }}</span>
                    </div>
                    @if ($match->exception || ($match->endResult && $match->endResult !== 'Prihajajoča igra'))
                        <div class="px-4 py-1.5 bg-gray-50 border-t border-gray-100 text-xs text-gray-500 text-center font-medium">
                            {{ $match->exception ?? $match->endResult }}
                        </div>
                    @endif
                    @include('partials._match_result_ui', ['match' => $match, 't1_name' => $t1_name, 't2_name' => $t2_name, 't1p1' => $t1p1, 't1p2' => $t1p2 ?? null, 't2p1' => $t2p1, 't2p2' => $t2p2 ?? null])
                </div>
            @endforeach
        </div>
    @endforeach
@endforeach

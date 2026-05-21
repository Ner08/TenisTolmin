@foreach ($brackets as $key => $bracket)
    @php
        $lastRound = $bracket->matchUps->max('round');
        $roundTitles = [
            1 => ['1. Kolo'],
            2 => ['1. Kolo', '2. Kolo'],
            3 => ['1. Kolo', '2. Kolo', '3. Kolo'],
            4 => ['1. Kolo', '2. Kolo', '3. Kolo', '4. Kolo'],
            5 => ['1. Kolo', '2. Kolo', '3. Kolo', '4. Kolo', '5. Kolo'],
            6 => ['1. Kolo', '2. Kolo', '3. Kolo', '4. Kolo', '5. Kolo', '6. Kolo'],
            7 => ['1. Kolo', '2. Kolo', '3. Kolo', '4. Kolo', '5. Kolo', '6. Kolo', '7. Kolo'],
            8 => ['1. Kolo', '2. Kolo', '3. Kolo', '4. Kolo', '5. Kolo', '6. Kolo', '7. Kolo', '8. Kolo'],
            9 => ['1. Kolo', '2. Kolo', '3. Kolo', '4. Kolo', '5. Kolo', '6. Kolo', '7. Kolo', '8. Kolo', '9. Kolo'],
        ];
    @endphp

    <div class="border-b border-gray-200 bg-white cursor-pointer hover:bg-gray-50 transition-colors group"
         onclick="toggleComponent('groupMobile{{ $key }}')">
        <div class="px-5 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-1 h-5 bg-amber-500 rounded-full"></div>
                <h2 class="text-sm font-semibold text-gray-800">{{ $bracket->name }}</h2>
            </div>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>

    <div id="groupMobile{{ $key }}" style="display: none">
        {{-- Standings table --}}
        <div class="overflow-x-auto">
            <table class="w-full bg-white divide-y divide-gray-100">
                <thead>
                    <tr class="bg-gray-900 text-gray-300 text-xs font-semibold uppercase tracking-wide">
                        <th class="px-3 py-2.5 text-left">#</th>
                        <th class="px-3 py-2.5 text-left">Ime</th>
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
                    @endphp
                    @foreach ($sortedTeams as $team)
                        @php
                            $p1 = $team->player1; $p2 = $team->player2;
                            $team_name = isset($team->name)
                                ? $team->name . '<span class="text-amber-500"> (' . $p1->ranking() . ')</span>'
                                : (isset($p2)
                                    ? $p1->p_name . '<span class="text-amber-500"> (' . $p1->ranking() . ')</span>, ' . $p2->p_name . '<span class="text-amber-500"> (' . $p2->ranking() . ')</span>'
                                    : $p1->p_name . '<span class="text-amber-500"> (' . $p1->ranking() . ')</span>');
                            $playedMatchupsCount = $team->matchups->filter(fn($m) => $m->game_played())->count();
                        @endphp
                        <tr class="hover:bg-amber-50 transition-colors {{ $loop->first ? 'bg-amber-50/30' : '' }}">
                            <td class="px-3 py-2 font-semibold text-gray-700">{!! $bracket->tag . $loop->iteration !!}</td>
                            <td class="px-3 py-2 text-gray-900">{!! $team_name !!}</td>
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
            <div class="px-5 py-2 bg-gray-50 border-b border-gray-100">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">{{ $roundTitles[$lastRound][$key - 1] }}</span>
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
                        $t1_ranking = ($t1p1->ranking() ?? '') . (isset($t1p2) ? '-' . $t1p2->ranking() : '');
                        $t2_ranking = ($t2p1->ranking() ?? '') . (isset($t2p2) ? '-' . $t2p2->ranking() : '');
                        $winner = $match->winner() ?? null;
                        $t1_sets_won = $match->t1SetsWon();
                        $t2_sets_won = $match->t2SetsWon();
                        $game_played = $match->game_played();
                    @endphp
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-medium text-gray-900 flex-1 leading-snug">
                                {{ $t1_name }}
                                @if (!isset($t1p2))
                                    <span class="text-amber-700 text-xs font-medium">&nbsp;({{ $t1_ranking }})</span>
                                @endif
                            </p>
                            @if ($game_played)
                                <span @class([
                                    'text-sm font-bold w-7 h-7 flex items-center justify-center rounded-full ml-3 flex-shrink-0',
                                    'bg-green-500 text-white' => isset($winner) && $winner,
                                    'bg-red-400 text-white' => isset($winner) && !$winner,
                                    'bg-gray-100 text-gray-500' => !isset($winner),
                                ])>{{ $t1_sets_won }}</span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between px-4 py-3">
                            <p class="text-sm font-medium text-gray-900 flex-1 leading-snug">
                                {{ $t2_name }}
                                @if (!isset($t2p2))
                                    <span class="text-amber-700 text-xs font-medium">&nbsp;({{ $t2_ranking }})</span>
                                @endif
                            </p>
                            @if ($game_played)
                                <span @class([
                                    'text-sm font-bold w-7 h-7 flex items-center justify-center rounded-full ml-3 flex-shrink-0',
                                    'bg-green-500 text-white' => isset($winner) && !$winner,
                                    'bg-red-400 text-white' => isset($winner) && $winner,
                                    'bg-gray-100 text-gray-500' => !isset($winner),
                                ])>{{ $t2_sets_won }}</span>
                            @endif
                        </div>
                        @if ($match->exception || ($match->endResult && $match->endResult !== 'Prihajajoča igra'))
                            <div class="px-4 py-1.5 bg-gray-50 border-t border-gray-100 text-xs text-gray-500 text-center font-medium">
                                {{ $match->exception ?? $match->endResult }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endforeach

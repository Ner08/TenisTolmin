@foreach ($brackets as $key => $bracket)
    @php
        $lastRound = $bracket->matchUps->max('round');
        $roundTitles = [
            1 => ['1.Kolo'],
            2 => ['1.Kolo', '2.Kolo'],
            3 => ['1.Kolo', '2.Kolo', '3.Kolo'],
            4 => ['1.Kolo', '2.Kolo', '3.Kolo', '4.Kolo'],
            5 => ['1.Kolo', '2.Kolo', '3.Kolo', '4.Kolo', '5.Kolo'],
            6 => ['1.Kolo', '2.Kolo', '3.Kolo', '4.Kolo', '5.Kolo', '6.Kolo'],
            7 => ['1.Kolo', '2.Kolo', '3.Kolo', '4.Kolo', '5.Kolo', '6.Kolo', '7.Kolo'],
            8 => ['1.Kolo', '2.Kolo', '3.Kolo', '4.Kolo', '5.Kolo', '6.Kolo', '7.Kolo', '8.Kolo'],
            9 => ['1.Kolo', '2.Kolo', '3.Kolo', '4.Kolo', '5.Kolo', '6.Kolo', '7.Kolo', '7.Kolo', '9.Kolo'],
        ];
    @endphp

    <div class="p-3 pl-12 bg-gray-200" onclick="toggleComponent('groupMobile{{ $key }}')">
        <h2 class="text-gray-900 font-bold text-xl">{{ $bracket->name }}</h2>
    </div>

    <div id="groupMobile{{ $key }}" style="display: none">
        {{-- Table of points in group --}}

        <div class="overflow-x-auto border-gray-100 border-8 ">
            <table class="w-full bg-white shadow-md  overflow-hidden divide-y divide-gray-200 pb-4">
                <thead class="bg-gray-50 ">
                    <tr>
                        <th scope="col"
                            class="px-2 sm:px-3 py-1 sm:py-3 text-center text-sm sm:text-base font-semibold text-gray-700 uppercase tracking-wider">
                            Mesto
                        </th>
                        <th scope="col"
                            class="px-2 sm:px-3 py-1 sm:py-3 text-center text-sm sm:text-base font-semibold text-gray-700 uppercase tracking-wider">
                            Ime
                        </th>
                        <th scope="col"
                            class="px-2 sm:px-3 py-1 sm:py-3 text-center text-sm sm:text-base font-semibold text-gray-700 uppercase tracking-wider">
                            Št. Tekem
                        </th>
                        <th scope="col"
                            class="px-2 sm:px-3 py-1 sm:py-3 text-center text-sm sm:text-base font-semibold text-gray-700 uppercase tracking-wider">
                            D/I Seti
                        </th>
                        <th scope="col"
                            class="px-2 sm:px-3 py-1 sm:py-3 text-center text-sm sm:text-base font-semibold text-gray-700 uppercase tracking-wider">
                            D/I Game-i
                        </th>
                        <th scope="col"
                            class="px-2 sm:px-3 py-1 sm:py-3 text-center text-sm sm:text-base font-semibold text-gray-700 uppercase tracking-wider">
                            točke
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        // Sort the teams by multiple criteria
                        $sortedTeams = $bracket->teams->where('is_fake', false)->sortByDesc(function ($team) {
                            // Sort by group points first
                            $points = $team->group_points();
                            // Then by group set delta
                            $setDelta = $team->group_set_delta();
                            // Finally by group game delta
                            $gameDelta = $team->group_game_delta();
                            // Combine all criteria into a single value for sorting
                            return [$points, $setDelta, $gameDelta];
                        });
                    @endphp
                    @foreach ($sortedTeams as $team)
                        @php
                            $p1 = $team->player1;
                            $p2 = $team->player2;
                            $team_name = isset($team->name)
                                ? $team->name . '<span class="text-blue-500"> (' . $p1->ranking() . ')</span>'
                                : (isset($p2)
                                    ? $p1->p_name .
                                        '<span class="text-blue-500"> (' .
                                        $p1->ranking() .
                                        ')</span> | ' .
                                        $p2->p_name .
                                        '<span class="text-blue-500"> (' .
                                        $p2->ranking() .
                                        ')</span>'
                                    : $p1->p_name . '<span class="text-blue-500"> (' . $p1->ranking() . ')</span>');

                            $playedMatchupsCount = $team->matchups
                                ->filter(function ($matchup) {
                                    return $matchup->game_played();
                                })
                                ->count();

                            $t1_ranking = ($p1->ranking() ?? '') . (isset($p2) ? '-' . $p2->ranking() : '');
                            // Calculate total points for the team
                        @endphp
                        <tr class="hover:bg-gray-100">
                            <td class="px-2 sm:px-3 py-2 sm:py-4 whitespace-nowrap text-center text-xs">
                                {!! $bracket->tag . $loop->iteration !!}
                            </td>
                            <td class="px-2 sm:px-3 py-2 sm:py-4 whitespace-nowrap text-center text-xs">
                                {!! $team_name !!}
                            </td>
                            <td class="px-2 sm:px-3 py-2 sm:py-4 whitespace-nowrap text-center text-sm">
                                {{ $playedMatchupsCount }}
                            </td>
                            <td class="px-2 sm:px-3 py-2 sm:py-4 whitespace-nowrap text-center text-sm">
                                {{ $team->group_set_delta() }}
                            </td>
                            <td class="px-2 sm:px-3 py-2 sm:py-4 whitespace-nowrap text-center text-sm">
                                {{ $team->group_game_delta() }}
                            </td>
                            <td class="px-2 sm:px-3 py-2 sm:py-4 whitespace-nowrap text-center text-sm">
                                {{ $team->group_points() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        @foreach ($bracket->matchUps->sortBy('round')->groupBy('round') as $key => $match)
            <div class="p-2 pl-12 w-full bg-gray-200">
                <h2 class="text-gray-900 font-bold text-lg">{{ $roundTitles[$lastRound][$key - 1] }}</h2>
            </div>
            <div class="grid grid-cols-1 gap-1 my-5">
                @foreach ($bracket->matchUps->where('round', $key) as $match)
                    <div class="bg-gray-100 rounded-md overflow-hidden shadow-md mx-4 mb-2">
                        <div class="bg-gray-200 p-2 grid grid-cols-2 gap-4">
                            @php
                                $team1 = App\Models\Team::where('id', $match->team1_id)->first();
                                $t1p1 = $team1->player1;
                                $t1p2 = $team1->player2;
                                $team2 = App\Models\Team::where('id', $match->team2_id)->first();
                                $t2p1 = $team2->player1;
                                $t2p2 = $team2->player2;

                                $t1_name = isset($t1p2) ? $t1p1->p_name . ', ' . $t1p2->p_name : $t1p1->p_name;
                                $t2_name = isset($t2p2) ? $t2p1->p_name . ', ' . $t2p2->p_name : $t2p1->p_name;

                                $t1_ranking = ($t1p1->ranking() ?? '') . (isset($t1p2) ? '-' . $t1p2->ranking() : '');
                                $t2_ranking = ($t2p1->ranking() ?? '') . (isset($t2p2) ? '-' . $t2p2->ranking() : '');

                                $winner = $match->winner() ?? null;

                                $t1_sets_won = $match->t1SetsWon();
                                $t2_sets_won = $match->t2SetsWon();

                                $game_played = $match->game_played();
                            @endphp
                            <div
                                class="text-center border-r border-gray-400 pr-4 flex flex-col justify-center items-center">
                                <p class="font-semibold mb-2">{{ $t1_name }} @if (!isset($t1p2))
                                        <span class="text-blue-500">({{ $t1_ranking }})</span>
                                    @endif
                                </p>
                                @if (isset($t1_sets_won) && $game_played)
                                    <div class="flex items-center justify-center">
                                        <div @class([
                                            'text-white' => isset($winner),
                                            'px-4',
                                            'py-2',
                                            'rounded-full',
                                            'bg-green-600' => isset($winner) && $winner,
                                            'bg-red-600' => isset($winner) && !$winner,
                                            'font-semibold',
                                            'text-gray-100' => isset($winner),
                                        ])>
                                            <p>{{ $t1_sets_won }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="text-center pl-4 flex flex-col justify-center items-center">
                                <p class="font-semibold mb-2">{{ $t2_name }} @if (!isset($t2p2))
                                        <span class="text-blue-500">({{ $t2_ranking }})</span>
                                    @endif
                                </p>
                                @if (isset($t2_sets_won) && $game_played)
                                    <div class="flex items-center justify-center">
                                        <div @class([
                                            'text-white' => isset($winner),
                                            'px-4',
                                            'py-2',
                                            'rounded-full',
                                            'bg-green-600' => isset($winner) && !$winner,
                                            'bg-red-600' => isset($winner) && $winner,
                                            'font-semibold',
                                            'text-gray-100' => isset($winner),
                                        ])>
                                            <p>{{ $t2_sets_won }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if (isset($match->endResult))
                            @if (isset($match->exception))
                                <div
                                    class="text-center bg-gray-600 text-gray-200 rounded-b-md font-semibold items-center pb-1">
                                    {{ $match->exception }}</div>
                            @elseif (isset($match->endResult))
                                <div
                                    class="text-center bg-gray-600 text-gray-200 rounded-b-md font-semibold items-center pb-1">
                                    {{ $match->endResult }}</div>
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endforeach

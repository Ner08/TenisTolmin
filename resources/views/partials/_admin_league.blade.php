<div
    class="mb-4 grid-flow-col items-center border-0 border-b-2 border-gray-200 text-center text-lg font-bold uppercase hidden md:grid">
    @foreach ($roundTitles[$lastRound] as $title)
        <div class="w-full md:w-auto md:flex-grow-0 md:w-{{ $colWidth }}">{{ $title }}
        </div>
    @endforeach
</div>

<div @class([
    'grid',
    'grid-flow-col',
    'grid-cols-' . $lastRound,
    'items-center',
    'pt-4'
])>
    @foreach ($bracket->matchUps->sortBy('round')->groupBy('round') as $key => $match)
        <div @class([
            'mx-2',
            'h-1/' . 2 ** ($key + 1) => $key != 1,
            'grid',
            'grid-flow-row',
            'grid-rows-' . ($lastRound - ($key - 1)),
        ])>
            @foreach ($bracket->matchUps->where('round', $key) as $match)
                @php
                    $team1 = App\Models\Team::where('id', $match->team1_id)->first();
                    $t1p1 = $team1->player1;
                    $t1p2 = $team1->player2;
                    $team2 = App\Models\Team::where('id', $match->team2_id)->first();
                    $t2p1 = $team2->player1;
                    $t2p2 = $team2->player2;

                    $t1_name = $team1->name ?? (isset($t1p2) ? $t1p1->p_name . ' | ' . $t1p2->p_name : $t1p1->p_name);
                    $t2_name = $team2->name ?? (isset($t2p2) ? $t2p1->p_name . ' | ' . $t2p2->p_name : $t2p1->p_name);

                    $t1_ranking = ($t1p1->ranking() ?? '') . (isset($t1p2) ? '-' . $t1p2->ranking() : '');
                    $t2_ranking = ($t2p1->ranking() ?? '') . (isset($t2p2) ? '-' . $t2p2->ranking() : '');

                    $winner = $match->winner() ?? null;

                    $t1_sets_won = $match->t1SetsWon();
                    $t2_sets_won = $match->t2SetsWon();
                @endphp
                <div class="mb-4 rounded-md bg-gray-200 pt-2 text-gray-900">
                    <div class="flex justify-between items-center px-4">
                        <div>
                            <p class="font-semibold text-sm">{{ $t1_name }} <span
                                    class="text-blue-500">({{ $t1_ranking }})</span></p>
                        </div>
                        @if (isset($t1_sets_won))
                            <div @class([
                                'text-white' => isset($winner),
                                'px-3',
                                'py-1',
                                'rounded-full',
                                'bg-green-600' => isset($winner) && $winner,
                                'bg-red-600' => isset($winner) && !$winner,
                            ]) class=" ">
                                <p class="text-right">{{ $t1_sets_won }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="flex justify-between items-center my-2 px-4 ">
                        <div>
                            <p class="font-semibold text-sm">{{ $t2_name }} <span
                                    class="text-blue-500">({{ $t2_ranking }})</span></p>
                        </div>
                        @if (isset($t2_sets_won))
                            <div @class([
                                'text-white' => isset($winner),
                                'px-3',
                                'py-1',
                                'rounded-full',
                                'bg-green-600' => isset($winner) && !$winner,
                                'bg-red-600' => isset($winner) && $winner,
                            ]) class=" ">
                                <p class="text-right">{{ $t2_sets_won }}</p>
                            </div>
                        @endif

                    </div>
                    @if (isset($match->endResult))
                        <div class="text-center bg-gray-600 text-gray-200 rounded-b-md font-semibold items-center pb-1">
                            {{ $match->endResult }}</div>
                    @endif
                </div>
            @endforeach
        </div>
    @endforeach
</div>
<div class="m-3 mr-8 pb-4 flex justify-end">
    <div class="bg-gray-100 rounded-lg p-4 shadow-md">
        <p class="text-gray-700 leading-relaxed">{{ $bracket->points_description }}</p>
    </div>
</div>


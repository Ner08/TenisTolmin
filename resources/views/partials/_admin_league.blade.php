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
                                $team2 = App\Models\Team::where('id', $match->team2_id)->first();

                                $p1_name = $team1->name ?? $team1->p1_name;
                                $p2_name = $team2->name ?? $team2->p1_name;
                                $p1_score = $team1->team_score ?? $team1->p1_score;
                                $p2_score = $team2->team_score ?? $team2->p1_score;
                                $p1_ranking =
                                    ($team1->p1_ranking ?? '') .
                                    (isset($team1->p2_ranking) ? '-' . $team1->p2_ranking : '');
                                $p2_ranking =
                                    ($team2->p1_ranking ?? '') .
                                    (isset($team2->p2_ranking) ? '-' . $team2->p2_ranking : '');

                                $winner = $match->winner ?? null;
                            @endphp
                            <div class="mb-4 rounded-md bg-gray-200 pt-2 text-gray-900">
                                <div class="flex justify-between items-center px-4">
                                    <div>
                                        <p class="font-semibold text-sm">{{ $p1_name }} <span
                                                class="text-blue-500">({{ $p1_ranking }})</span></p>
                                    </div>
                                    @if (isset($match->t1_sets_won))
                                        <div @class([
                                            'text-white' => isset($winner),
                                            'px-3',
                                            'py-1',
                                            'rounded-full',
                                            'bg-green-600' => isset($winner) && $winner,
                                            'bg-red-600' => isset($winner) && !$winner,
                                        ]) class=" ">
                                            <p class="text-right">{{ $match->t1_sets_won }}</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex justify-between items-center my-2 px-4 ">
                                    <div>
                                        <p class="font-semibold text-sm">{{ $p2_name }} <span
                                                class="text-blue-500">({{ $p2_ranking }})</span></p>
                                    </div>
                                    @if (isset($match->t2_sets_won))
                                        <div @class([
                                            'text-white' => isset($winner),
                                            'px-3',
                                            'py-1',
                                            'rounded-full',
                                            'bg-green-600' => isset($winner) && !$winner,
                                            'bg-red-600' => isset($winner) && $winner,
                                        ]) class=" ">
                                            <p class="text-right">{{ $match->t2_sets_won }}</p>
                                        </div>
                                    @endif

                                </div>
                                @if (isset($match->endResult))
                                    <div
                                        class="text-center bg-gray-600 text-gray-200 rounded-b-md font-semibold items-center pb-1">
                                        {{ $match->endResult }}</div>
                                @endif

                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

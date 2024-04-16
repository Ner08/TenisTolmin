@foreach ($brackets as $bracket)
    @php
        $lastRound = $bracket->matchUps->max('round') ?? 10;
        $roundTitles = [
            1 => ['Finale'],
            2 => ['Polfinale', 'Finale'],
            3 => ['Četrtfinale', 'Polfinale', 'Finale'],
            4 => ['Osminafinala', 'Četrtfinale', 'Polfinale', 'Finale'],
            5 => ['1.Krog', 'Osminafinala', 'Četrtfinale', 'Polfinale', 'Finale'],
            6 => ['1.Krog', '2.Krog', 'Osminafinala', 'Četrtfinale', 'Polfinale', 'Finale'],
            7 => ['1.Krog', '2.Krog', '3.Krog', 'Osminafinala', 'Četrtfinale', 'Polfinale', 'Finale'],
            8 => [
                '1.Krog',
                '2.Krog',
                '3.Krog',
                '4.Krog',
                '5.Krog',
                'Osminafinala',
                'Četrtfinale',
                'Polfinale',
                'Finale',
            ],
            9 => [
                '1.Krog',
                '2.Krog',
                '3.Krog',
                '4.Krog',
                '5.Krog',
                '6.Krog',
                'Osminafinala',
                'Četrtfinale',
                'Polfinale',
                'Finale',
            ],
            10 => ['Tekme še niso določene.'],
        ];
    @endphp

    <div class="mx-2- p-3 pl-12 bg-gray-700">
        <h2 class="text-gray-200 font-bold text-xl">{{ $bracket->name }}</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
        @foreach ($bracket->matchUps->sortBy('round')->groupBy('round') as $key => $match)
            <div class="mx-2- p-1 pl-12 bg-gray-200">
                <h2 class="text-gray-900 font-bold text-lg">{{ $roundTitles[$lastRound][$key - 1] }}</h2>
            </div>
            @foreach ($bracket->matchUps->where('round', $key) as $match)
                <div class="bg-gray-100 rounded-md overflow-hidden shadow-md mx-4">
                    <div class="bg-gray-200 p-4 grid grid-cols-2 gap-4">
                        @php
                            $team1 = App\Models\Team::where('id', $match->team1_id)->first();
                            $t1p1 = $team1->player1;
                            $t1p2 = $team1->player2;
                            $team2 = App\Models\Team::where('id', $match->team2_id)->first();
                            $t2p1 = $team2->player1;
                            $t2p2 = $team2->player2;

                            $t1_name =
                                $team1->name ?? (isset($t1p2) ? $t1p1->p_name . ' | ' . $t1p2->p_name : $t1p1->p_name);
                            $t2_name =
                                $team2->name ?? (isset($t2p2) ? $t2p1->p_name . ' | ' . $t2p2->p_name : $t2p1->p_name);

                            $t1_ranking = ($t1p1->ranking() ?? '') . (isset($t1p2) ? '-' . $t1p2->ranking() : '');
                            $t2_ranking = ($t2p1->ranking() ?? '') . (isset($t2p2) ? '-' . $t2p2->ranking() : '');

                            $winner = $match->winner() ?? null;

                            $t1_sets_won = $match->t1SetsWon();
                            $t2_sets_won = $match->t2SetsWon();
                        @endphp
                        <div class="text-center border-r border-gray-400 pr-4 flex flex-col justify-between">
                            <div>
                                <p class="font-semibold mb-2">{{ $t1_name }} <span
                                        class="text-blue-500">({{ $t1_ranking }})</span></p>
                                <!-- Player 1 content here -->
                            </div>
                            <div class="text-center">
                                @if (isset($t1_sets_won))
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
                        </div>
                        <div class="text-center pl-4 flex flex-col justify-between">
                            <div>
                                <p class="font-semibold mb-2">{{ $t2_name }} <span
                                        class="text-blue-500">({{ $t2_ranking }})</span></p>
                                <!-- Player 2 content here -->
                            </div>
                            <div class="text-center">
                                @if (isset($t2_sets_won))
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
                    </div>
                    @if (isset($match->endResult))
                        <div class="text-center bg-gray-600 text-gray-200 rounded-b-md font-semibold items-center pb-1">
                            <p>{{ $match->endResult }} </p>
                        </div>
                    @endif
                </div>
            @endforeach
        @endforeach
    </div>
@endforeach

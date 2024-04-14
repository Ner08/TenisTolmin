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
                            $team1 = App\Models\Team::find($match->team1_id);
                            $team2 = App\Models\Team::find($match->team2_id);
                            $p1_name = $team1 ? $team1->name ?? $team1->p1_name : '';
                            $p2_name = $team2 ? $team2->name ?? $team2->p1_name : '';
                            $p1_score = $team1 ? $team1->team_score ?? $team1->p1_score : '';
                            $p2_score = $team2 ? $team2->team_score ?? $team2->p1_score : '';
                            $p1_sets_won = $match->t1_sets_won;
                            $p2_sets_won = $match->t2_sets_won;
                        @endphp
                        <div class="text-center border-r border-gray-400 pr-4 flex flex-col justify-between">
                            <div>
                                <p class="font-semibold mb-2">{{ $p1_name }} <span class="text-blue-500">({{ $p1_score }})</span></p>
                                <!-- Player 1 content here -->
                            </div>
                            <div class="text-center">
                                @if (isset($match->t1_sets_won))
                                    <div class="flex items-center justify-center">
                                        <div @class([
                                            'text-white' => isset($match->winner),
                                            'px-4',
                                            'py-2',
                                            'rounded-full',
                                            'bg-green-600' => isset($match->winner) && $match->winner,
                                            'bg-red-600' => isset($match->winner) && !$match->winner,
                                            'font-semibold',
                                            'text-gray-100' => isset($match->winner)
                                        ])>
                                            <p>{{ $match->t1_sets_won }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="text-center pl-4 flex flex-col justify-between">
                            <div>
                                <p class="font-semibold mb-2">{{ $p2_name }} <span class="text-blue-500">({{ $p2_score }})</span></p>
                                <!-- Player 2 content here -->
                            </div>
                            <div class="text-center">
                                @if (isset($match->t2_sets_won))
                                    <div class="flex items-center justify-center">
                                        <div @class([
                                            'text-white' => isset($match->winner),
                                            'px-4',
                                            'py-2',
                                            'rounded-full',
                                            'bg-green-600' => isset($match->winner) && !$match->winner,
                                            'bg-red-600' => isset($match->winner) && $match->winner,
                                            'font-semibold',
                                            'text-gray-100' => isset($match->winner)
                                        ])>
                                            <p>{{ $match->t2_sets_won }}</p>
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

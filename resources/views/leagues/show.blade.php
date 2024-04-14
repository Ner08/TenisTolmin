<x-layout :login="$login" :admin="$admin">
    <div>
        @if ($isMobile)
            <x-sm-league-title :data="['name' => $league->name, 'start_date' => $league->start_date, 'end_date' => $league->end_date]" />
            @if ($brackets->isNotEmpty())
                <x-league-group-title title="Izločitveni del" />
            @endif
            <x-sm-screen-leagues :brackets="$brackets" />
            @if ($brackets_group->isNotEmpty())
                <x-league-group-title title="Skupinski del" />
            @endif
            @if ($brackets->isEmpty() && $brackets_group->isEmpty())
                <div class="m-6">
                    <div class="text-xl font-bold text-gray-700 bg-gray-300 p-4 rounded-lg inline-block">
                        Liga še ni nastavljena, mogoče pa se prikaže kmalu :)
                    </div>
                </div>
            @endif
            @include('partials._sm_league_group_stage', ['brackets' => $brackets_group])
        @else
            <x-league-title :data="['name' => $league->name, 'start_date' => $league->start_date, 'end_date' => $league->end_date]" />
            @if ($brackets->isNotEmpty())
                <x-league-group-title title="Izločitveni del" />
            @endif
            @foreach ($brackets as $bracket)
                <div class="p-2 pl-12 bg-gray-200">
                    <h1 class="p-2 inline-block text-gray-900 font-bold text-2xl">{{ $bracket->name }}</h1>
                </div>

                <div class="m-2 p-4 bg-white rounded-xl">
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

                        // Calculate the width of each column
                        $colWidth = 12 / $lastRound; // Divide 12 (the number of columns in Bootstrap grid system) by the total number of rounds
                    @endphp

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
                </div>
            @endforeach
            @if ($brackets_group->isNotEmpty())
                <x-league-group-title title="Skupinski del" />
            @endif
            @if ($brackets->isEmpty() && $brackets_group->isEmpty())
                <div class="m-6">
                    <div class="text-xl font-bold text-gray-700 bg-gray-300 p-4 rounded-lg inline-block">
                        Liga še ni nastavljena, mogoče pa se prikaže kmalu :)
                    </div>
                </div>
            @endif
            @include('partials._league_group_stage', ['brackets' => $brackets_group])
        @endif
    </div>
</x-layout>

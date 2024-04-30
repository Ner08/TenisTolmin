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

                <div class="m-2 p-4 pb-0 bg-white rounded-xl">
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
                                        $t1p1 = $team1->player1;
                                        $t1p2 = $team1->player2;
                                        $team2 = App\Models\Team::where('id', $match->team2_id)->first();
                                        $t2p1 = $team2->player1;
                                        $t2p2 = $team2->player2;

                                        $t1_name = isset($t1p2) ? $t1p1->p_name . ' | ' . $t1p2->p_name : $t1p1->p_name;
                                        $t2_name = isset($t2p2) ? $t2p1->p_name . ' | ' . $t2p2->p_name : $t2p1->p_name;

                                        $t1_ranking =
                                            ($t1p1->ranking() ?? '') . (isset($t1p2) ? '-' . $t1p2->ranking() : '');
                                        $t2_ranking =
                                            ($t2p1->ranking() ?? '') . (isset($t2p2) ? '-' . $t2p2->ranking() : '');

                                        $winner = $match->winner() ?? null;

                                        $t1_sets_won = $match->t1SetsWon();
                                        $t2_sets_won = $match->t2SetsWon();
                                    @endphp
                                    <div class="mb-4 rounded-md bg-gray-200 pt-2 text-gray-900">
                                        <div class="flex justify-between items-center px-4">
                                            @if ($match->t1_tag)
                                                <div
                                                    class="bg-gray-900 text-white px-2 py-1 font-semibold text-sm rounded-md mr-4">
                                                    {{ $match->t1_tag }}</div>
                                            @endif
                                            @if (isset($t2_name))
                                                @if (!isset($match->t1_tag) && $team1->is_fake)
                                                    <div>
                                                        <p class="font-semibold text-sm">{{ $t1_name }}</p>
                                                    </div>
                                                @elseif (isset($match->t1_tag) && $team1->is_fake)

                                                @elseif (!$team1->is_fake)
                                                    <div>
                                                        <p class="font-semibold text-sm">{{ $t1_name }} <span
                                                                class="text-blue-500">({{ $t1_ranking }})</span></p>
                                                    </div>
                                                @endif
                                            @endif
                                            @if (isset($t1_sets_won))
                                                <div @class([
                                                    'text-white' => isset($winner),
                                                    'px-3',
                                                    'ml-2',
                                                    'py-1',
                                                    'rounded-full',
                                                    'bg-green-600' => isset($winner) && $winner,
                                                    'bg-red-600' => isset($winner) && !$winner,
                                                ])>
                                                    <p class="text-right">{{ $t1_sets_won }}</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex justify-between items-center my-2 px-4 ">
                                            @if ($match->t2_tag)
                                                <div
                                                    class="bg-gray-900 text-white px-2 py-1 font-semibold text-sm rounded-md mr-4">
                                                    {{ $match->t2_tag }}</div>
                                            @endif
                                            @if (isset($t2_name))
                                                @if (!isset($match->t2_tag) && $team2->is_fake)
                                                    <div>
                                                        <p class="font-semibold text-sm">{{ $t2_name }}</p>
                                                    </div>
                                                @elseif (isset($match->t2_tag) && $team2->is_fake)

                                                @elseif (!$team2->is_fake)
                                                    <div>
                                                        <p class="font-semibold text-sm">{{ $t2_name }} <span
                                                                class="text-blue-500">({{ $t2_ranking }})</span></p>
                                                    </div>
                                                @endif
                                            @endif
                                            @if (isset($t2_sets_won))
                                                <div @class([
                                                    'text-white' => isset($winner),
                                                    'px-3',
                                                    'ml-2',
                                                    'py-1',
                                                    'rounded-full',
                                                    'bg-green-600' => isset($winner) && !$winner,
                                                    'bg-red-600' => isset($winner) && $winner,
                                                ])>
                                                    <p class="text-right">{{ $t2_sets_won }}</p>
                                                </div>
                                            @endif

                                        </div>
                                        @if (isset($match->exception))
                                            <div
                                                class="text-center bg-gray-600 text-gray-200 rounded-b-md font-semibold items-center pb-1">
                                                {{ $match->exception }}</div>
                                        @elseif (isset($match->endResult))
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
                <div class="m-3 mr-8 pb-4 flex justify-end">
                    <div class="bg-gray-100 rounded-lg p-4 shadow-md">
                        <p class="text-gray-700 leading-relaxed">{{ $bracket->points_description }}</p>
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

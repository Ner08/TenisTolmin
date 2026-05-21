@foreach ($brackets as $key => $bracket)
    @php
        $lastRound = $bracket->matchUps->max('round') ?? 10;
        $roundTitles = [
            1 => ['Finale'],
            2 => ['Polfinale', 'Finale'],
            3 => ['Četrtfinale', 'Polfinale', 'Finale'],
            4 => ['Osminafinala', 'Četrtfinale', 'Polfinale', 'Finale'],
            5 => ['1. Krog', 'Osminafinala', 'Četrtfinale', 'Polfinale', 'Finale'],
            6 => ['1. Krog', '2. Krog', 'Osminafinala', 'Četrtfinale', 'Polfinale', 'Finale'],
            7 => ['1. Krog', '2. Krog', '3. Krog', 'Osminafinala', 'Četrtfinale', 'Polfinale', 'Finale'],
            8 => ['1. Krog', '2. Krog', '3. Krog', '4. Krog', 'Osminafinala', 'Četrtfinale', 'Polfinale', 'Finale'],
            9 => ['1. Krog', '2. Krog', '3. Krog', '4. Krog', '5. Krog', 'Osminafinala', 'Četrtfinale', 'Polfinale', 'Finale'],
            10 => ['Tekme še niso določene.'],
        ];
    @endphp

    <div class="border-b border-gray-200 bg-white cursor-pointer hover:bg-gray-50 transition-colors group"
         onclick="toggleComponent('bracketMobile{{ $key }}')">
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

    <div id="bracketMobile{{ $key }}" style="display: none">
        <div class="p-3 space-y-1">
            @foreach ($bracket->matchUps->sortBy('round')->groupBy('round') as $key => $match)
                <div class="px-4 py-2 bg-gray-50 border-b border-gray-100">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">{{ $roundTitles[$lastRound][$key - 1] }}</span>
                </div>
                <div class="grid grid-cols-1 gap-2 px-3 py-3">
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
                            {{-- Team 1 --}}
                            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                                @if ($match->t1_tag)
                                    <span class="text-sm font-semibold bg-gray-900 text-white px-2.5 py-0.5 rounded-md">{{ $match->t1_tag }}</span>
                                @elseif (!$team1->is_fake)
                                    <p class="text-sm font-medium text-gray-900 flex-1 leading-snug">
                                        {{ $t1_name }}
                                        @if (!isset($t1p2))
                                            <span class="text-amber-700 text-xs font-medium">&nbsp;({{ $t1_ranking }})</span>
                                        @endif
                                    </p>
                                @else
                                    <p class="text-sm text-gray-400 italic">{{ $t1_name }}</p>
                                @endif
                                @if ($game_played)
                                    <span @class([
                                        'text-sm font-bold w-7 h-7 flex items-center justify-center rounded-full ml-3 flex-shrink-0',
                                        'bg-green-500 text-white' => isset($winner) && $winner,
                                        'bg-red-400 text-white' => isset($winner) && !$winner,
                                        'bg-gray-100 text-gray-500' => !isset($winner),
                                    ])>{{ $t1_sets_won }}</span>
                                @endif
                            </div>
                            {{-- Team 2 --}}
                            <div class="flex items-center justify-between px-4 py-3">
                                @if ($match->t2_tag)
                                    <span class="text-sm font-semibold bg-gray-900 text-white px-2.5 py-0.5 rounded-md">{{ $match->t2_tag }}</span>
                                @elseif (!$team2->is_fake)
                                    <p class="text-sm font-medium text-gray-900 flex-1 leading-snug">
                                        {{ $t2_name }}
                                        @if (!isset($t2p2))
                                            <span class="text-amber-700 text-xs font-medium">&nbsp;({{ $t2_ranking }})</span>
                                        @endif
                                    </p>
                                @else
                                    <p class="text-sm text-gray-400 italic">{{ $t2_name }}</p>
                                @endif
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
            @if (isset($bracket->points_description))
                <div class="px-3 pb-3">
                    <div class="bg-amber-50 border border-amber-100 rounded-xl px-4 py-3 text-sm text-amber-800">
                        {!! nl2br($bracket->points_description) !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endforeach

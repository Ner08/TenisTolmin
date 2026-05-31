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
                            <div class="flex-1 min-w-0">
                                @if ($match->t1_tag)
                                    <span class="text-sm font-semibold bg-gray-900 text-white px-2.5 py-0.5 rounded-md">{{ $match->t1_tag }}</span>
                                @elseif (!$team1->is_fake)
                                    <p class="text-sm font-medium text-gray-900 truncate">{!! $t1_display !!}
                                        @if (!isset($t1p2))<span class="text-gray-400 text-xs font-normal">&nbsp;({{ $t1_ranking }})</span>@endif
                                    </p>
                                @else
                                    <p class="text-sm text-gray-400 italic truncate">{{ $t1_name }}</p>
                                @endif
                            </div>
                            <span @class(['text-sm font-bold w-7 h-7 flex items-center justify-center rounded-full flex-shrink-0', 'bg-green-500 text-white' => $t1Win, 'bg-red-400 text-white' => $game_played && !$t1Win && isset($winner), 'bg-gray-100 text-gray-500' => $game_played && !isset($winner), 'bg-gray-100 text-gray-300' => !$game_played])>{{ $game_played ? $t1_sets_won : '–' }}</span>
                        </div>
                        <div class="flex items-center gap-2 px-4 py-3">
                            <div class="flex-1 min-w-0">
                                @if ($match->t2_tag)
                                    <span class="text-sm font-semibold bg-gray-900 text-white px-2.5 py-0.5 rounded-md">{{ $match->t2_tag }}</span>
                                @elseif (!$team2->is_fake)
                                    <p class="text-sm font-medium text-gray-900 truncate">{!! $t2_display !!}
                                        @if (!isset($t2p2))<span class="text-gray-400 text-xs font-normal">&nbsp;({{ $t2_ranking }})</span>@endif
                                    </p>
                                @else
                                    <p class="text-sm text-gray-400 italic truncate">{{ $t2_name }}</p>
                                @endif
                            </div>
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
        @if (isset($bracket->points_description))
            <div class="px-3 pb-3">
                <div class="bg-amber-50 border border-amber-100 rounded-xl px-4 py-3 text-sm text-amber-800">
                    {!! nl2br($bracket->points_description) !!}
                </div>
            </div>
        @endif

        {{-- Final standings --}}
        @if ($bracket->places_from)
            @php
                $standingsGroups = [];
                $place = $bracket->places_from;
                $isFirst = true;
                foreach ($bracket->matchUps->sortByDesc('round')->groupBy('round') as $matches) {
                    $played = $matches->filter(fn($m) => $m->game_played() && $m->winner() !== null);
                    if ($played->isEmpty()) continue;
                    if ($isFirst) {
                        $final = $played->first();
                        $w = $final->winner();
                        $standingsGroups[] = ['from' => $place, 'to' => $place, 'teams' => [$w ? $final->team1 : $final->team2]];
                        $place++;
                        $standingsGroups[] = ['from' => $place, 'to' => $place, 'teams' => [$w ? $final->team2 : $final->team1]];
                        $place++;
                        $isFirst = false;
                    } else {
                        $losers = $played->map(fn($m) => $m->winner() ? $m->team2 : $m->team1)->values()->all();
                        $standingsGroups[] = ['from' => $place, 'to' => $place + count($losers) - 1, 'teams' => $losers];
                        $place += count($losers);
                    }
                }
            @endphp
            @if (count($standingsGroups))
                <div class="px-3 pb-4 mt-2">
                    <div class="flex items-center gap-2 mb-2 px-1">
                        <div class="w-1 h-5 bg-amber-500 rounded-full"></div>
                        <h3 class="text-xs font-bold text-gray-600 uppercase tracking-wide">
                            Končne uvrstitve
                            <span class="text-gray-400 font-normal normal-case">({{ $bracket->places_from }}–{{ $bracket->places_to ?? $place - 1 }}.&nbsp;mesto)</span>
                        </h3>
                    </div>
                    <div class="relative bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                        @foreach ($standingsGroups as $group)
                            @php
                                $tied  = $group['to'] > $group['from'];
                                $label = $tied ? ($group['from'] . '–' . $group['to'] . '.') : $group['from'] . '.';
                                $medal = !$tied ? match($group['from']) { 1 => '🥇', 2 => '🥈', 3 => '🥉', default => null } : null;
                                $names = collect($group['teams'])->map(function($t) {
                                    $p1 = $t?->player1; $p2 = $t?->player2;
                                    return $p1 ? ($p2 ? $p1->p_name . ' & ' . $p2->p_name : $p1->p_name) : '—';
                                })->join(', ');
                            @endphp
                            <div class="flex items-center gap-3 px-4 py-3 {{ !$loop->last ? 'border-b border-gray-100' : '' }} {{ $group['from'] === $bracket->places_from ? 'bg-amber-50/50' : '' }}">
                                <span class="@if($tied) w-12 text-xs @else w-8 text-sm @endif font-bold {{ $group['from'] === $bracket->places_from ? 'text-amber-600' : 'text-gray-400' }} flex-shrink-0">
                                    {{ $medal ?? $label }}
                                </span>
                                <span class="text-sm font-medium text-gray-800">{{ $names }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif

    </div>
@endforeach

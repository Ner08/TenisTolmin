@foreach ($brackets as $bracketKey => $bracket)
<div id="league{{ $bracketKey }}">
    <div class="px-3 py-4">
        @php
            $roundGroups  = $bracket->matchUps->sortBy('round')->groupBy('round');
            $totalRounds  = $roundGroups->count();
            $baseSlotH    = 175; // px — must exceed tallest card (pending UI + admin button = ~155px)
            $connW        = 20;  // px — connector stub width
        @endphp

        @if ($roundGroups->isNotEmpty())
        <div class="overflow-x-auto">

            {{-- Round headers --}}
            <div class="flex mb-3">
                @foreach ($roundGroups as $roundNum => $_)
                    @php
                        $rev = $totalRounds - 1 - $loop->index;
                        $title = match($rev) {
                            0 => 'Finale',
                            1 => 'Polfinale',
                            2 => 'Četrtfinale',
                            3 => 'Osminafinala',
                            default => ($rev - 3) . '. Krog',
                        };
                    @endphp
                    <div class="flex items-center justify-center py-2.5 bg-gray-100 border-y border-gray-200"
                         style="flex:1; min-width:180px;">
                        <span class="text-xs font-bold text-gray-700 uppercase tracking-widest">{{ $title }}</span>
                    </div>
                @endforeach
            </div>

            {{-- Bracket --}}
            <div class="flex">
                @foreach ($roundGroups as $roundNum => $_)
                    @php
                        $matches  = $bracket->matchUps->where('round', $roundNum)->values();
                        $slotH    = $baseSlotH * (2 ** $loop->index);
                        $isFirst  = $loop->first;
                        $isLast   = $loop->last;
                    @endphp

                    <div class="flex flex-col" style="flex:1; min-width:180px;">
                        @foreach ($matches as $match)
                            @php
                                $team1      = App\Models\Team::where('id', $match->team1_id)->first();
                                $t1p1       = $team1->player1; $t1p2 = $team1->player2;
                                $team2      = App\Models\Team::where('id', $match->team2_id)->first();
                                $t2p1       = $team2->player1; $t2p2 = $team2->player2;
                                $t1_name    = isset($t1p2) ? $t1p1->p_name . ' / ' . $t1p2->p_name : $t1p1->p_name;
                                $t2_name    = isset($t2p2) ? $t2p1->p_name . ' / ' . $t2p2->p_name : $t2p1->p_name;
                                $pLink      = fn($p) => '<a href="' . route('player.show', $p->id) . '" class="hover:text-amber-600 transition-colors">' . e($p->p_name) . '</a>';
                                $t1_display = isset($t1p2) ? $pLink($t1p1) . ' / ' . $pLink($t1p2) : $pLink($t1p1);
                                $t2_display = isset($t2p2) ? $pLink($t2p1) . ' / ' . $pLink($t2p2) : $pLink($t2p1);
                                $winner     = $match->winner() ?? null;
                                $t1_sets_won = $match->t1SetsWon();
                                $t2_sets_won = $match->t2SetsWon();
                                $game_played = $match->game_played();
                                $t1Win      = $game_played && isset($winner) && $winner;
                                $t2Win      = $game_played && isset($winner) && !$winner;
                                $isOdd      = $loop->iteration % 2 === 1;
                            @endphp

                            <div class="relative" style="height:{{ $slotH }}px;">

                                {{-- Left connector: horizontal stub from previous round's vertical bar --}}
                                @if (!$isFirst)
                                    <div class="absolute" style="left:0; width:{{ $connW }}px; top:50%; border-top:2px solid #d1d5db;"></div>
                                @endif

                                {{-- Match card --}}
                                <div class="absolute rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden"
                                     style="left:{{ $isFirst ? 4 : ($connW + 4) }}px;
                                            right:{{ $isLast ? 4 : ($connW + 4) }}px;
                                            top:50%; transform:translateY(-50%);">

                                    {{-- Team 1 --}}
                                    <div class="flex items-center gap-2 px-3 py-2.5 border-b border-gray-100 {{ $t1Win ? 'bg-green-50' : '' }}">
                                        <div class="flex-1 min-w-0">
                                            @if ($match->t1_tag && ($team1->is_fake || !$game_played))
                                                <span class="text-xs md:text-sm font-bold bg-gray-900 text-white px-2 py-0.5 rounded">{{ $match->t1_tag }}</span>
                                            @elseif (!$team1->is_fake)
                                                <p class="text-xs md:text-sm font-medium text-gray-900 truncate">{!! $t1_display !!}</p>
                                            @else
                                                <p class="text-xs md:text-sm text-gray-400 italic truncate">TBD</p>
                                            @endif
                                        </div>
                                        <span @class(['text-xs font-bold w-6 h-6 md:w-7 md:h-7 flex items-center justify-center rounded-full flex-shrink-0',
                                            'bg-green-500 text-white'   => $t1Win,
                                            'bg-red-400 text-white'     => $game_played && !$t1Win && isset($winner),
                                            'bg-gray-100 text-gray-400' => !$game_played,
                                        ])>{{ $game_played ? $t1_sets_won : '–' }}</span>
                                    </div>

                                    {{-- Team 2 --}}
                                    <div class="flex items-center gap-2 px-3 py-2.5 {{ $t2Win ? 'bg-green-50' : '' }}">
                                        <div class="flex-1 min-w-0">
                                            @if ($match->t2_tag && ($team2->is_fake || !$game_played))
                                                <span class="text-xs md:text-sm font-bold bg-gray-900 text-white px-2 py-0.5 rounded">{{ $match->t2_tag }}</span>
                                            @elseif (!$team2->is_fake)
                                                <p class="text-xs md:text-sm font-medium text-gray-900 truncate">{!! $t2_display !!}</p>
                                            @else
                                                <p class="text-xs md:text-sm text-gray-400 italic truncate">TBD</p>
                                            @endif
                                        </div>
                                        <span @class(['text-xs font-bold w-6 h-6 md:w-7 md:h-7 flex items-center justify-center rounded-full flex-shrink-0',
                                            'bg-green-500 text-white'   => $t2Win,
                                            'bg-red-400 text-white'     => $game_played && !$t2Win && isset($winner),
                                            'bg-gray-100 text-gray-400' => !$game_played,
                                        ])>{{ $game_played ? $t2_sets_won : '–' }}</span>
                                    </div>

                                    {{-- Footer --}}
                                    @if ($match->exception || ($match->endResult && $match->endResult !== 'Prihajajoča igra'))
                                        <div class="px-3 py-1 bg-gray-50 border-t border-gray-100 text-xs text-gray-500 text-center">
                                            {{ $match->exception ?? $match->endResult }}
                                        </div>
                                    @endif

                                    @include('partials._match_result_ui', [
                                        'match'   => $match,
                                        't1_name' => $t1_name, 't2_name' => $t2_name,
                                        't1p1'    => $t1p1,   't1p2' => $t1p2 ?? null,
                                        't2p1'    => $t2p1,   't2p2' => $t2p2 ?? null,
                                    ])
                                </div>

                                {{-- Right connector: bracket-shaped stub to next round --}}
                                @if (!$isLast)
                                    @if ($isOdd)
                                        {{-- Odd match: stub from center going down to slot bottom --}}
                                        <div class="absolute" style="right:0; width:{{ $connW }}px; top:50%; bottom:0; border-top:2px solid #d1d5db; border-right:2px solid #d1d5db; border-top-right-radius:4px;"></div>
                                    @else
                                        {{-- Even match: stub from slot top going down to center --}}
                                        <div class="absolute" style="right:0; width:{{ $connW }}px; top:0; bottom:50%; border-bottom:2px solid #d1d5db; border-right:2px solid #d1d5db; border-bottom-right-radius:4px;"></div>
                                    @endif
                                @endif

                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
        @else
            <p class="text-sm text-gray-400 italic px-2">Tekme še niso določene.</p>
        @endif
    </div>

    {{-- Points description --}}
    @if (isset($bracket->points_description))
        <div class="px-4 pb-4 flex justify-end">
            <div class="bg-amber-50 border border-amber-100 rounded-xl px-5 py-3 text-sm text-amber-800 max-w-md">
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
            foreach ($bracket->matchUps->sortByDesc('round')->groupBy('round') as $roundMatches) {
                $played = $roundMatches->filter(fn($m) => $m->game_played() && $m->winner() !== null);
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
            <div class="px-4 pb-6 mt-2">
                <div class="max-w-sm">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-1 h-5 bg-amber-500 rounded-full"></div>
                        <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide">
                            Končne uvrstitve
                            <span class="text-gray-400 font-normal normal-case ml-1">
                                ({{ $bracket->places_from }}–{{ $bracket->places_to ?? $place - 1 }}.&nbsp;mesto)
                            </span>
                        </h3>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
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
            </div>
        @endif
    @endif
</div>
@endforeach

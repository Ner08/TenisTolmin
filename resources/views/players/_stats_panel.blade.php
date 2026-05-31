@php
    $wins       = $stats['wins'];
    $losses     = $stats['losses'];
    $played     = $stats['played'];
    $winRate    = $stats['winRate'];
    $setsWon    = $stats['setsWon'];
    $setsLost   = $stats['setsLost'];
    $gamesWon   = $stats['gamesWon'];
    $gamesLost  = $stats['gamesLost'];
    $h2h        = $stats['h2h'];
    $leagueStats = $stats['leagueStats'];
    $rollingForm = $stats['rollingForm'];
    $formGuide  = array_slice(array_reverse($history), 0, 10);
@endphp

{{-- Stats grid --}}
<div class="grid grid-cols-3 sm:grid-cols-6 divide-x divide-y sm:divide-y-0 divide-gray-100">
    <div class="px-3 py-4 text-center">
        <p class="text-xl font-bold text-gray-900">{{ $played }}</p>
        <p class="text-xs text-gray-500 mt-0.5">Tekme</p>
    </div>
    <div class="px-3 py-4 text-center">
        <p class="text-xl font-bold text-green-600">{{ $wins }}</p>
        <p class="text-xs text-gray-500 mt-0.5">Zmage</p>
    </div>
    <div class="px-3 py-4 text-center">
        <p class="text-xl font-bold text-red-500">{{ $losses }}</p>
        <p class="text-xs text-gray-500 mt-0.5">Porazi</p>
    </div>
    <div class="px-3 py-4 text-center">
        <p class="text-xl font-bold text-amber-600">{{ $winRate }}%</p>
        <p class="text-xs text-gray-500 mt-0.5">Uspešnost</p>
    </div>
    <div class="px-3 py-4 text-center">
        <p class="text-xl font-bold text-gray-700">{{ $setsWon }}/{{ $setsLost }}</p>
        <p class="text-xs text-gray-500 mt-0.5">Seti Z/P</p>
    </div>
    <div class="px-3 py-4 text-center">
        <p class="text-xl font-bold text-gray-700">{{ $gamesWon }}/{{ $gamesLost }}</p>
        <p class="text-xs text-gray-500 mt-0.5">Gemi Z/P</p>
    </div>
</div>

@if ($played > 0)
    <div class="px-6 pb-4 pt-1">
        <div class="flex h-2 rounded-full overflow-hidden bg-red-100">
            <div class="bg-green-500 h-full rounded-full" style="width: {{ $winRate }}%"></div>
        </div>
        <div class="flex justify-between text-xs text-gray-400 mt-1">
            <span>{{ $wins }} zmag</span>
            <span>{{ $losses }} porazov</span>
        </div>
    </div>
@endif

{{-- The rest of the content cards --}}
<div class="space-y-4 px-6 pb-6">

    {{-- Form guide --}}
    @if (!empty($formGuide))
        <div class="bg-gray-50 rounded-xl px-4 py-3">
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Zadnje tekme</h3>
            <div class="flex gap-1.5 flex-wrap">
                @foreach ($formGuide as $entry)
                    <div title="{{ $entry['won'] ? 'Zmaga' : 'Poraz' }}"
                         @class(['w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold',
                                 'bg-green-500 text-white' => $entry['won'],
                                 'bg-red-400 text-white'   => !$entry['won']])>
                        {{ $entry['won'] ? 'Z' : 'P' }}
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Charts --}}
    @if ($played > 0)
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-gray-50 rounded-xl px-4 py-3 flex flex-col items-center">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-3 self-start">Razmerje zmag</h3>
                <div class="relative w-32 h-32">
                    <canvas id="chartDonut_{{ $tabId }}"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-2xl font-bold text-gray-900">{{ $winRate }}%</span>
                        <span class="text-xs text-gray-400">uspešnost</span>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 rounded-xl px-4 py-3 sm:col-span-2">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-3">Zmage po ligah</h3>
                <div class="h-32"><canvas id="chartLeague_{{ $tabId }}"></canvas></div>
            </div>
        </div>
        @if (count($rollingForm) > 1)
            <div class="bg-gray-50 rounded-xl px-4 py-3">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-3">Kumulativna uspešnost (%)</h3>
                <div class="h-28"><canvas id="chartForm_{{ $tabId }}"></canvas></div>
            </div>
        @endif
    @endif

    {{-- Head-to-head --}}
    @if (!empty($h2h))
        <div class="bg-gray-50 rounded-xl overflow-hidden">
            <div class="px-4 py-2.5 border-b border-gray-200">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wide">Izkaz proti nasprotnikom</h3>
            </div>
            <ul class="divide-y divide-gray-200">
                @foreach ($h2h as $entry)
                    @php $total = $entry['wins'] + $entry['losses']; $rate = $total > 0 ? round(($entry['wins']/$total)*100) : 0; @endphp
                    <li class="px-4 py-2.5">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('player.show', $entry['player']->id) }}"
                               class="text-sm font-medium text-gray-900 hover:text-amber-600 transition-colors flex-1 min-w-0 truncate">
                                {{ $entry['player']->p_name }}
                            </a>
                            <span class="text-xs font-semibold text-green-600 w-6 text-center">{{ $entry['wins'] }}</span>
                            <span class="text-xs text-gray-300">—</span>
                            <span class="text-xs font-semibold text-red-500 w-6 text-center">{{ $entry['losses'] }}</span>
                            <span class="text-xs text-gray-400 w-9 text-right">{{ $rate }}%</span>
                        </div>
                        <div class="mt-1.5 h-1.5 bg-red-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full {{ $rate >= 50 ? 'bg-green-500' : 'bg-red-400' }}" style="width: {{ $rate }}%"></div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Match history --}}
    <div class="bg-gray-50 rounded-xl overflow-hidden">
        <div class="px-4 py-2.5 border-b border-gray-200">
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wide">Zgodovina tekem</h3>
        </div>
        @if (empty($history))
            <div class="px-4 py-8 text-center text-sm text-gray-400">Ni odigranih tekem.</div>
        @else
            <ul class="divide-y divide-gray-200">
                @foreach ($history as $entry)
                    @php
                        $matchup  = $entry['matchup'];
                        $opponent = $entry['opponent'];
                        $won      = $entry['won'];
                        $isTeam1  = $entry['is_team1'];
                        $oppName  = $opponent->player2
                            ? ($opponent->player1->p_name ?? '?') . ' & ' . ($opponent->player2->p_name ?? '?')
                            : ($opponent->player1->p_name ?? '?');
                        $context  = $entry['league']?->name
                            ? $entry['league']->name . ($entry['bracket'] ? ' · ' . $entry['bracket']->name : '')
                            : ($entry['bracket']?->name ?? '');
                        $score = $matchup->endResult;
                        if (!$isTeam1 && $score !== 'Prihajajoča igra') {
                            $sets  = explode('  ', $score);
                            $score = implode('  ', array_map(fn($s) => implode(':', array_reverse(explode(':', $s))), $sets));
                        }
                    @endphp
                    <li class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100 transition-colors">
                        <span @class(['flex-shrink-0 w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold',
                                      'bg-green-100 text-green-700' => $won,
                                      'bg-red-100 text-red-600'     => !$won])>
                            {{ $won ? 'Z' : 'P' }}
                        </span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $oppName }}</p>
                            @if ($context)
                                <p class="text-xs text-gray-400 truncate">{{ $context }}</p>
                            @endif
                        </div>
                        <span class="text-xs font-mono text-gray-600 flex-shrink-0 tabular-nums">
                            {{ $score !== 'Prihajajoča igra' ? $score : '' }}
                        </span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

</div>

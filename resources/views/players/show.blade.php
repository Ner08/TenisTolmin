<x-layout>
    @title($player->p_name . ' - Tenis Tolmin')

    <x-title :title="$player->p_name" back-route="scoreboard" back-label="Lestvica" />

    <section class="pt-4 pb-10 md:py-10 px-4">
        <div class="container mx-auto max-w-3xl space-y-4">

            {{-- Header card --}}
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                <div class="bg-gray-900 px-6 py-5 flex items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ $player->p_name }}</h1>
                        <p class="text-gray-400 text-sm mt-0.5">{{ $player->points }} točk</p>
                    </div>
                    <div @class([
                        'flex flex-col items-center justify-center w-16 h-16 rounded-full flex-shrink-0',
                        'bg-amber-400' => $player->ranking() === 1,
                        'bg-gray-300'  => $player->ranking() === 2,
                        'bg-amber-700' => $player->ranking() === 3,
                        'bg-gray-700'  => $player->ranking() > 3,
                    ])>
                        @if ($player->ranking() === 1)
                            <svg class="w-4 h-4 text-amber-800 mb-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endif
                        <span class="text-xl font-bold {{ $player->ranking() <= 3 ? 'text-gray-900' : 'text-white' }}">#{{ $player->ranking() }}</span>
                    </div>
                </div>

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

                {{-- Win rate bar --}}
                @if ($played > 0)
                    <div class="px-6 pb-4 pt-1">
                        <div class="flex h-2 rounded-full overflow-hidden bg-red-100">
                            <div class="bg-green-500 h-full rounded-full transition-all" style="width: {{ $winRate }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-400 mt-1">
                            <span>{{ $wins }} zmag</span>
                            <span>{{ $losses }} porazov</span>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Form guide --}}
            @if (!empty($formGuide))
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm px-5 py-4">
                    <h2 class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-3">Zadnje tekme</h2>
                    <div class="flex gap-1.5 flex-wrap">
                        @foreach ($formGuide as $entry)
                            <div title="{{ $entry['won'] ? 'Zmaga' : 'Poraz' }} vs {{ $entry['opponent']->player1->p_name ?? '?' }}"
                                 @class([
                                     'w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold',
                                     'bg-green-500 text-white' => $entry['won'],
                                     'bg-red-400 text-white'   => !$entry['won'],
                                 ])>
                                {{ $entry['won'] ? 'Z' : 'P' }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Head-to-head --}}
            @if (!empty($h2h))
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                    <div class="px-5 py-3 border-b border-gray-100">
                        <h2 class="text-sm font-semibold text-gray-800">Izkaz proti nasprotnikom</h2>
                    </div>
                    <ul class="divide-y divide-gray-100">
                        @foreach ($h2h as $entry)
                            @php
                                $total = $entry['wins'] + $entry['losses'];
                                $rate  = $total > 0 ? round(($entry['wins'] / $total) * 100) : 0;
                            @endphp
                            <li class="px-5 py-3">
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
                                    <div class="h-full rounded-full transition-all {{ $rate >= 50 ? 'bg-green-500' : 'bg-red-400' }}"
                                         style="width: {{ $rate }}%"></div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Match history --}}
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                <div class="px-5 py-3 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-800">Zgodovina tekem</h2>
                </div>
                @if (empty($matchHistory))
                    <div class="px-5 py-10 text-center text-sm text-gray-400">Ni odigranih tekem.</div>
                @else
                    <ul class="divide-y divide-gray-100">
                        @foreach ($matchHistory as $entry)
                            @php
                                $matchup  = $entry['matchup'];
                                $opponent = $entry['opponent'];
                                $won      = $entry['won'];
                                $isTeam1  = $entry['is_team1'];
                                $oppName  = $opponent->player2
                                    ? $opponent->player1->p_name . ', ' . $opponent->player2->p_name
                                    : $opponent->player1->p_name;
                                $context  = $entry['league']?->name
                                    ? $entry['league']->name . ($entry['bracket'] ? ' · ' . $entry['bracket']->name : '')
                                    : ($entry['bracket']?->name ?? '');
                                $score = $matchup->endResult;
                                if (!$isTeam1 && $score !== 'Prihajajoča igra') {
                                    $sets = explode('  ', $score);
                                    $score = implode('  ', array_map(fn($s) => implode(':', array_reverse(explode(':', $s))), $sets));
                                }
                            @endphp
                            <li class="flex items-center gap-3 px-5 py-3.5 hover:bg-gray-50 transition-colors">
                                <span @class([
                                    'flex-shrink-0 w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold',
                                    'bg-green-100 text-green-700' => $won,
                                    'bg-red-100 text-red-600'     => !$won,
                                ])>{{ $won ? 'Z' : 'P' }}</span>
                                <div class="flex-1 min-w-0">
                                    <a href="{{ route('player.show', $opponent->player1->id) }}"
                                       class="text-sm font-medium text-gray-900 hover:text-amber-600 transition-colors truncate block">
                                        {{ $oppName }}
                                    </a>
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
    </section>
</x-layout>

<x-layout>
    @title($player->p_name . ' - Tenis Tolmin')

    <section class="py-10 px-4">
        <div class="container mx-auto max-w-3xl">

            <a href="{{ route('scoreboard') }}"
               class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 transition-colors mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Lestvica
            </a>

            {{-- Profile header --}}
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm mb-5">
                <div class="bg-gray-900 px-6 py-5 flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-bold text-white">{{ $player->p_name }}</h1>
                        <p class="text-gray-400 text-sm mt-0.5">{{ $player->points }} točk</p>
                    </div>
                    <div class="flex flex-col items-center justify-center w-14 h-14 rounded-full
                        {{ $player->ranking() === 1 ? 'bg-amber-400' : ($player->ranking() === 2 ? 'bg-gray-300' : ($player->ranking() === 3 ? 'bg-amber-700' : 'bg-gray-700')) }}">
                        @if ($player->ranking() === 1)
                            <svg class="w-4 h-4 text-amber-800 mb-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endif
                        <span class="text-lg font-bold {{ $player->ranking() <= 3 ? 'text-gray-900' : 'text-white' }}">#{{ $player->ranking() }}</span>
                    </div>
                </div>

                {{-- Stats row --}}
                <div class="grid grid-cols-4 divide-x divide-gray-100">
                    <div class="px-4 py-4 text-center">
                        <p class="text-2xl font-bold text-gray-900">{{ $played }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Odigrano</p>
                    </div>
                    <div class="px-4 py-4 text-center">
                        <p class="text-2xl font-bold text-green-600">{{ $wins }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Zmage</p>
                    </div>
                    <div class="px-4 py-4 text-center">
                        <p class="text-2xl font-bold text-red-500">{{ $losses }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Porazi</p>
                    </div>
                    <div class="px-4 py-4 text-center">
                        <p class="text-2xl font-bold text-amber-600">{{ $winRate }}%</p>
                        <p class="text-xs text-gray-500 mt-0.5">Uspešnost</p>
                    </div>
                </div>

                @if ($played > 0)
                    <div class="px-6 pb-4">
                        <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-green-500 rounded-full" style="width: {{ $winRate }}%"></div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Match history --}}
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                <div class="px-5 py-3 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-800">Zgodovina tekem</h2>
                </div>

                @if (empty($matchHistory))
                    <div class="px-5 py-10 text-center text-sm text-gray-400">
                        Ni odigranih tekem.
                    </div>
                @else
                    <ul class="divide-y divide-gray-100">
                        @foreach ($matchHistory as $entry)
                            @php
                                $matchup  = $entry['matchup'];
                                $opponent = $entry['opponent'];
                                $won      = $entry['won'];
                                $isTeam1  = $entry['is_team1'];

                                $opp_name = isset($opponent->name)
                                    ? $opponent->name
                                    : (isset($opponent->player2)
                                        ? $opponent->player1->p_name . ', ' . $opponent->player2->p_name
                                        : $opponent->player1->p_name);

                                $context = $entry['league']?->name
                                    ? ($entry['league']->name . ($entry['bracket'] ? ' · ' . $entry['bracket']->name : ''))
                                    : ($entry['bracket']?->name ?? '');

                                $score = $matchup->endResult;
                                if (!$isTeam1 && $score !== 'Prihajajoča igra') {
                                    $sets = explode('  ', $score);
                                    $flipped = array_map(function($s) {
                                        $parts = explode(':', $s);
                                        return count($parts) === 2 ? $parts[1] . ':' . $parts[0] : $s;
                                    }, $sets);
                                    $score = implode('  ', $flipped);
                                }
                            @endphp
                            <li class="flex items-center justify-between px-5 py-3.5 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span @class([
                                        'flex-shrink-0 w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold',
                                        'bg-green-100 text-green-700' => $won,
                                        'bg-red-100 text-red-600'     => !$won,
                                    ])>{{ $won ? 'Z' : 'P' }}</span>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $opp_name }}</p>
                                        @if ($context)
                                            <p class="text-xs text-gray-400 truncate">{{ $context }}</p>
                                        @endif
                                    </div>
                                </div>
                                <span class="text-xs font-mono text-gray-600 flex-shrink-0 ml-4 tabular-nums">
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

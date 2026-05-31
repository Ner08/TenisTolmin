<x-layout>
    @title('Tminska ATP lestvica - Tenis Tolmin')
    <x-title title="Tminska ATP lestvica" />
    @php $maxPoints = $maxPoints > 0 ? $maxPoints : 100; @endphp

    @if ($players->isEmpty())
        <div class="max-w-screen-2xl mx-auto px-4 py-8">
            <x-empty model1="Rezultati" />
        </div>
    @else
        <section class="pt-4 md:pt-6 pb-10 px-4">
            <div class="max-w-screen-2xl mx-auto space-y-1">

                @foreach ($players as $player)
                    @php
                        $ranking = $player->ranking();
                        $pct     = round(($player->points / $maxPoints) * 100);
                        $isTop3  = $ranking <= 3;

                        $medalBg   = $ranking === 1 ? 'bg-amber-400 text-amber-900'
                                   : ($ranking === 2 ? 'bg-gray-300 text-gray-700'
                                   : ($ranking === 3 ? 'bg-amber-700 text-amber-100' : ''));
                        $barColor  = $ranking === 1 ? 'bg-amber-400'
                                   : ($ranking === 2 ? 'bg-gray-400'
                                   : ($ranking === 3 ? 'bg-amber-700'
                                   : 'bg-gray-300'));
                        $rowBg     = $ranking === 1 ? 'bg-amber-50 border-amber-200'
                                   : 'bg-white border-gray-200';
                    @endphp

                    <a href="{{ route('player.show', $player->id) }}"
                       class="{{ $rowBg }} border rounded-xl shadow-sm hover:shadow-md transition-all duration-200 group
                              flex items-center gap-3 sm:gap-5 px-4 sm:px-6
                              {{ $isTop3 ? 'py-4 sm:py-5' : 'py-2.5 sm:py-3' }}">

                        <div class="flex-shrink-0 flex items-center justify-center {{ $isTop3 ? 'w-10 h-10' : 'w-8' }}">
                            @if ($isTop3)
                                <span class="w-10 h-10 rounded-full flex items-center justify-center font-black text-lg {{ $medalBg }} shadow-sm">
                                    {{ $ranking }}
                                </span>
                            @else
                                <span class="text-sm font-bold text-gray-300 text-center w-full">{{ $ranking }}</span>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="font-bold truncate group-hover:text-amber-600 transition-colors
                               {{ $ranking === 1 ? 'text-lg text-gray-900' : ($isTop3 ? 'text-base text-gray-900' : 'text-sm text-gray-700') }}">
                                {{ $player->p_name }}
                            </p>
                            @if ($isTop3)
                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ $ranking === 1 ? 'Vodilni igralec' : ($ranking === 2 ? 'Drugo mesto' : 'Tretje mesto') }}
                                </p>
                            @endif
                        </div>

                        <div class="hidden md:block flex-1 max-w-xs">
                            <div class="{{ $isTop3 ? 'h-2' : 'h-1' }} bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full {{ $barColor }} transition-all duration-500"
                                     style="width: {{ $pct }}%"></div>
                            </div>
                        </div>

                        <div class="flex-shrink-0 text-right">
                            <span class="font-black tabular-nums
                                {{ $ranking === 1 ? 'text-xl text-amber-600' : ($isTop3 ? 'text-lg text-gray-700' : 'text-sm text-gray-500') }}">
                                {{ $player->points }}
                            </span>
                            <span class="text-xs text-gray-400 ml-0.5">t.</span>
                        </div>

                    </a>
                @endforeach

            </div>
        </section>
    @endif
</x-layout>

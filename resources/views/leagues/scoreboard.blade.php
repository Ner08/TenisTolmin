<x-layout>
    @title('Tminska ATP lestvica - Tenis Tolmin')
    <x-title title="Tminska ATP lestvica" />
    @php
        $maxPoints = $maxPoints > 0 ? $maxPoints : 100;
    @endphp
    @if ($players->isEmpty())
        <div class="container mx-auto px-4 py-8">
            <x-empty model1="Rezultati" />
        </div>
    @else
        <section class="py-8 px-4">
            <div class="container mx-auto max-w-4xl">
                <div class="space-y-3">
                    @foreach ($players as $key => $player)
                        @php
                            $ranking = $player->ranking();
                        @endphp
                        <a href="{{ route('player.show', $player->id) }}" class="bg-white border border-gray-200 rounded-xl overflow-hidden flex items-stretch shadow-sm hover:shadow-md transition-shadow duration-200 group">
                            {{-- Rank badge --}}
                            <div @class([
                                'w-16 flex flex-col items-center justify-center text-center flex-shrink-0 py-4',
                                'bg-amber-400' => $ranking === 1,
                                'bg-gray-300' => $ranking === 2,
                                'bg-amber-700' => $ranking === 3,
                                'bg-gray-100' => $ranking > 3,
                            ])>
                                @if ($ranking === 1)
                                    <svg class="w-5 h-5 text-amber-800 mb-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endif
                                <span class="text-xl font-bold {{ $ranking <= 3 ? 'text-gray-800' : 'text-gray-500' }}">{{ $ranking }}</span>
                            </div>
                            {{-- Player info --}}
                            <div class="flex-grow px-5 py-4">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="font-semibold text-gray-900 group-hover:text-amber-600 transition-colors">{{ $player->p_name }}</span>
                                    <span class="text-sm font-semibold text-amber-600 bg-amber-50 border border-amber-200 px-3 py-0.5 rounded-full">
                                        {{ $player->points }} točk
                                    </span>
                                </div>
                                <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-amber-400 rounded-full transition-all duration-500"
                                         style="width: {{ ($player->points / $maxPoints) * 100 }}%"></div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layout>

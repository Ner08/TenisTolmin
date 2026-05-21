<div class="container mx-auto py-10 px-4">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-1">Lige in turnirji</h2>
        <p class="text-gray-500 text-sm">Tekmuj posamično ali v dvojicah — vsak turnir je nova priložnost.</p>
    </div>

    @if ($leagues->isEmpty())
        <x-empty model1="Lige in turnirji" />
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($leagues as $league)
            <a href="{{ route('league', $league->id) }}"
               class="group block bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden">
                <div class="flex flex-col h-full">
                    <div class="p-5 pb-4 flex-grow">
                        <h3 class="text-base font-semibold text-gray-900 mb-2 group-hover:text-amber-600 transition-colors duration-150">{{ $league->name }}</h3>
                        <p class="text-gray-500 text-sm line-clamp-2">{{ $league->description }}</p>
                    </div>
                    <div class="px-5 py-3 bg-gray-900 flex justify-between items-center text-gray-300 text-xs font-medium">
                        <span>{{ \Carbon\Carbon::parse($league->start_date)->format('d.m.Y') }}</span>
                        <span class="text-gray-500">&rarr;</span>
                        <span>{{ $league->end_date ? \Carbon\Carbon::parse($league->end_date)->format('d.m.Y') : 'Ni določen' }}</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <div class="flex justify-center mt-8 gap-3">
        <a href="{{ route('leagues') }}"
           class="bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold py-2.5 px-6 rounded-lg transition-colors duration-200">
            Vse lige
        </a>
        <a href="{{ route('scoreboard') }}"
           class="bg-white border border-gray-300 hover:border-gray-400 text-gray-700 text-sm font-semibold py-2.5 px-6 rounded-lg transition-colors duration-200">
            ATP lestvica
        </a>
    </div>
</div>

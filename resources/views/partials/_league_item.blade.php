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
            <span class="text-gray-400 ml-2">{{ $league->totalPlayers }} igralk./ekip</span>
        </div>
    </div>
</a>

<a href="{{ route('league', $league->id) }}"
   class="group block bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden">
    <div class="flex flex-col h-full">
        <div class="p-5 xl:p-7 pb-4 xl:pb-5 flex-grow">
            <h3 class="text-base xl:text-lg font-semibold text-gray-900 mb-2 group-hover:text-amber-600 transition-colors duration-150">{{ $league->name }}</h3>
            <p class="text-gray-500 text-sm xl:text-base line-clamp-2">{{ $league->description }}</p>
        </div>
        <div class="px-5 xl:px-7 py-3 xl:py-4 bg-gray-900 flex justify-between items-center text-gray-300 text-xs xl:text-sm font-medium">
            <span>{{ \Carbon\Carbon::parse($league->start_date)->format('d.m.Y') }}</span>
            <span class="text-gray-500">&rarr;</span>
            <span>{{ $league->end_date ? \Carbon\Carbon::parse($league->end_date)->format('d.m.Y') : 'Ni določen' }}</span>
            <span class="text-gray-400 ml-2">{{ $league->totalPlayers }} igralcev/ekip</span>
        </div>
    </div>
</a>

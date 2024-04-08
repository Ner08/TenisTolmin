<a href="{{ route('league', $league->id) }}" class="bg-gray-100 hover:bg-gray-200 cursor-pointer rounded-lg shadow-md overflow-hidden transition duration-300 ease-in-out transform hover:-translate-y-1">
    <div class="flex flex-col h-full">
        <div class="p-6 pb-3 flex-grow">
            <h3 class="text-xl font-semibold mb-4 text-gray-800">{{ $league->name }}</h3>
            <p class="text-gray-600 mb-6">{{ $league->description }}</p>
        </div>
        <div class="py-3 px-6 flex justify-between items-center text-gray-300 bg-gray-900">
            <div>
                <p class="flex items-center">
                    <svg class="w-4 h-4 mr-2 fill-current text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                        <circle cx="12" cy="12" r="5" fill="#fff"/>
                    </svg>
                    <span class="text-sm font-medium">Začetek: {{ \Carbon\Carbon::parse($league->start_date)->format('d.m.Y') }}</span>
                </p>
                @if ($league->end_date)
                    <p class="flex items-center">
                        <svg class="w-4 h-4 mr-2 fill-current text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                            <circle cx="12" cy="12" r="5" fill="#fff"/>
                        </svg>
                        <span class="text-sm font-medium">Konec: {{ \Carbon\Carbon::parse($league->end_date)->format('d.m.Y') }}</span>
                    </p>
                @else
                    <p class="flex items-center">
                        <svg class="w-4 h-4 mr-2 fill-current text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                            <circle cx="12" cy="12" r="5" fill="#fff"/>
                        </svg>
                        <span class="text-sm font-medium">Konec: Ni določen</span>
                    </p>
                @endif
            </div>
            <p class="text-sm font-medium"> {{ $league->totalPlayers }} igralcev/ekip</p>
        </div>
    </div>
</a>

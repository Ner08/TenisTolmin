<div class="container mx-auto mt-3 px-4" id="admin_dogodki" style="display: none">
    <div class="bg-gray-900 text-white px-5 py-3 rounded-t-xl">
        <h2 class="text-sm font-semibold">Dodaj dogodek</h2>
    </div>
    <form action="{{ route('events_store') }}" method="POST" class="mb-6 bg-white border border-gray-200 border-t-0 rounded-b-xl p-5">
        @csrf
        <div class="mb-4">
            <label for="e_title" class="block text-xs font-semibold text-gray-700 mb-1.5">Naslov</label>
            <input type="text" name="e_title" id="e_title" placeholder="Vnesite naslov dogodka"
                class="border border-gray-200 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-amber-500 py-2.5 px-3.5 text-sm"
                value="{{ old('e_title') }}" required>
            @error('e_title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="e_description" class="block text-xs font-semibold text-gray-700 mb-1.5">Opis</label>
            <textarea name="e_description" id="e_description" placeholder="Vnesite opis dogodka"
                class="border border-gray-200 rounded-lg w-full h-36 focus:outline-none focus:ring-2 focus:ring-amber-500 py-2.5 px-3.5 text-sm" required>{{ old('description') }}</textarea>
            @error('e_description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="location" class="block text-xs font-semibold text-gray-700 mb-1.5">Lokacija</label>
            <input type="text" name="location" id="location" placeholder="Vnesite lokacijo"
                class="border border-gray-200 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-amber-500 py-2.5 px-3.5 text-sm"
                value="{{ old('location') }}" required>
            @error('location')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
            <div>
                <label for="fromDate" class="block text-xs font-semibold text-gray-700 mb-1.5">Datum in čas začetka</label>
                <input type="datetime-local" name="fromDate" id="fromDate"
                    class="border border-gray-200 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-amber-500 py-2.5 px-3.5 text-sm"
                    value="{{ old('start_date') }}" required>
                @error('start_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="toDate" class="block text-xs font-semibold text-gray-700 mb-1.5">Datum in čas zaključka <span class="font-normal text-gray-400">(neobvezno)</span></label>
                <input type="datetime-local" name="toDate" id="toDate"
                    class="border border-gray-200 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-amber-500 py-2.5 px-3.5 text-sm"
                    value="{{ old('end_date') }}">
                @error('end_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <button type="submit"
            class="bg-gray-900 text-white text-sm px-6 py-2.5 rounded-lg hover:bg-gray-700 transition-colors">
            Dodaj dogodek
        </button>
    </form>

    <form action="" method="GET">
        <div class="flex mb-5" id="events">
            <input type="text" name="search_events" id="search_events" placeholder="Iskanje dogodkov..."
                class="border border-gray-200 rounded-l-lg py-2.5 px-3.5 text-sm w-full sm:w-72 focus:outline-none focus:ring-2 focus:ring-amber-500"
                value="{{ isset($search_events) ? $search_events : '' }}">
            <button type="submit"
                class="bg-gray-900 text-white text-sm px-5 rounded-r-lg hover:bg-gray-700 transition-colors flex-shrink-0">
                Išči
            </button>
        </div>
    </form>

    <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @if ($events->isEmpty())
            <p class="text-sm text-gray-500 col-span-3 py-4">Nismo našli nobenega dogodka.</p>
        @else
            @foreach ($events as $item)
                <li class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                    <div class="p-5">
                        <h3 class="text-sm font-semibold text-gray-900 mb-1.5">{{ $item->e_title }}</h3>
                        <p class="text-xs text-gray-600 line-clamp-3 leading-relaxed mb-3">{{ $item->e_description }}</p>
                        <div class="space-y-1">
                            <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($item->fromDate)->format('d.m.Y H:i') }}</span>
                                @if ($item->toDate)
                                    <span class="text-gray-400">→</span>
                                    <span>{{ \Carbon\Carbon::parse($item->toDate)->format('d.m.Y H:i') }}</span>
                                @endif
                            </div>
                            @if (isset($item->location))
                                <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>{{ $item->location }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center justify-end gap-2 px-5 py-3 border-t border-gray-100 bg-gray-50">
                        <a href="{{ route('event_edit', $item->id) }}"
                            class="text-xs font-medium text-gray-700 bg-white border border-gray-200 px-3 py-1.5 rounded-lg hover:border-gray-300 transition-colors">
                            Uredi
                        </a>
                        <form id="deleteEventsForm{{ $item->id }}"
                            action="{{ route('events_destroy', ['event' => $item->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                onclick="showDeleteConfirmation('deleteEventsForm', {{ $item->id }})"
                                class="text-xs font-medium text-red-600 bg-white border border-red-200 px-3 py-1.5 rounded-lg hover:bg-red-50 transition-colors">
                                Izbriši
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
    <div class="mt-4">{{ $events->links() }}</div>
</div>

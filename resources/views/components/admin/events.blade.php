<div class="container mx-auto mt-3 px-4" id="admin_dogodki" style="display: none">
    <!-- Add new events form -->
    <div class="bg-zinc-900 text-white py-2 px-4 rounded-t-lg">
        <h2 class="text-xl font-bold">Dodaj dogodek</h2>
    </div>
    <form action="{{ route('events_store') }}" method="POST" class="mb-5 bg-gray-100 rounded-lg p-6">
        @csrf
        <div class="mb-4">
            <label for="e_title" class="block text-gray-700 font-semibold">Naslov:</label>
            <input type="text" name="e_title" id="e_title" placeholder="Vnesite naslov dogodka"
                class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                value="{{ old('e_title') }}" required>
            @error('e_title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="e_description" class="block text-gray-700 font-semibold">Vsebina:</label>
            <textarea name="e_description" id="e_description" placeholder="Vnesite opis dogodka"
                class="form-textarea rounded-lg w-full h-48 focus:outline-none  border-gray-300 py-3 px-4" required>{{ old('description') }}</textarea>
            @error('e_description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="location" class="block text-gray-700 font-semibold">Lokacija:</label>
            <input type="text" name="location" id="location" placeholder="Vnesite lokacijo dogodka"
                class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                value="{{ old('location') }}" required>
            @error('location')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="start_date" class="block text-gray-700 font-semibold">Datum in čas
                začetka:</label>
            <input type="datetime-local" name="fromDate" id="fromDate"
                class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                value="{{ old('start_date') }}" required>
            @error('start_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="end_date" class="block text-gray-700 font-semibold">Datum in čas zaključka
                (neobvezno):</label>
            <input type="datetime-local" name="toDate" id="toDate"
                class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                value="{{ old('end_date') }}">
            @error('end_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit"
            class="bg-zinc-500 text-white px-8 py-3 rounded-lg hover:bg-zinc-600 focus:outline-none transition duration-300">
            Dodaj
        </button>
    </form>


    <form action="" method="GET" class="flex flex-col items-start">
        <div class="flex mb-4" id="events">
            <input type="text" name="search_events" id="search_events" placeholder="Iskanje"
                class="form-input rounded-lg py-3 px-4 w-full h-12 sm:w-64 mb-2 sm:mb-0 focus:outline-none "
                value="{{ isset($search_events) ? $search_events : '' }}">
            <button type="submit"
                class="bg-zinc-600 text-white px-6 h-12 ml-2 rounded-lg hover:bg-zinc-700 focus:outline-none focus:bg-zinc-7s00">Iskanje
            </button>
        </div>
    </form>
    <!-- Display list of events with edit and delete buttons -->
    <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @if ($events->isEmpty())
            <h2 class="p-4 text-gray-900">Nismo našli nobenega dogodka.</h2>
        @else
            @foreach ($events as $item)
                <li class="bg-white rounded-lg shadow-md p-6 mb-4 overflow-hidden">
                    <h3 class="text-xl font-bold mb-2">{{ $item->e_title }}</h3>
                    <p class="text-gray-700 line-clamp-3">{{ $item->e_description }}</p>
                    <p class="text-gray-500 mt-4">
                        <span class="text-sm font-semibold">Od:</span>
                        <span
                            class="text-sm">{{ \Carbon\Carbon::parse($item->fromDate)->format('d.m.Y H:i') }}</span>
                        <span class="text-sm font-semibold ml-4">Do:</span>
                        <span
                            class="text-sm">{{ \Carbon\Carbon::parse($item->toDate)->format('d.m.Y H:i') }}</span>
                        @if (isset($item->location))
                            <br>
                            <span class="text-sm font-semibold">Lokacija:</span>
                            <span class="text-sm">{{ $item->location }}</span>
                        @endif
                    </p>
                    <div class="flex justify-end mt-4">
                        <a href="{{ route('event_edit', $item->id) }}"
                            class="text-blue-500 hover:underline mr-4">Uredi</a>
                        <!-- Delete Form with Confirmation Dialog -->
                        <form id="deleteEventsForm{{ $item->id }}"
                            action="{{ route('events_destroy', ['event' => $item->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                onclick="showDeleteConfirmation('deleteEventsForm', {{ $item->id }})"
                                class="text-red-500 hover:underline">Izbriši</button>
                        </form>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
    <div class="p-4">{{ $events->links() }}</div>
</div>

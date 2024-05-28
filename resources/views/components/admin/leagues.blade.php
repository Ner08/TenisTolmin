<div class="container mx-auto pt-4 px-4" id="admin_lige" style="display: none">
    <!-- Add new legue form -->
    <div class="bg-zinc-900 text-white py-2 px-4 rounded-t-lg">
        <h2 class="text-xl font-bold">Dodaj ligo ali turnir</h2>
    </div>
    <form action="{{ route('leagues.store') }}" method="POST" class="mb-5 bg-gray-100 rounded-lg p-6">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold">Ime lige ali turnirja:</label>
            <input type="text" name="name" id="name" placeholder="Enter league name"
                class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                value="{{ old('name') }}" required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-semibold">Opis:</label>
            <textarea name="description" id="description" placeholder="Enter league description"
                class="form-textarea rounded-lg w-full h-48 focus:outline-none  border-gray-300 py-3 px-4" required>{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <input type="checkbox" name="l_home_page" id="l_home_page"
                class="mr-2 bg-gray-300 rounded-sm h-5 w-5" value="1">
            <label for="l_home_page" class="text-gray-700 font-semibold mr-4">Na domači strani</label>
            @error('l_home_page')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="mt-4 text-gray-600"><b>Informacija:</b> Na domači strani se pokažejo 3 najnovejše
                lige označene z "Na domači strani"</p>
        </div>
        <div class="mb-4">
            <label for="start_date" class="block text-gray-700 font-semibold">Start Date:</label>
            <input type="date" name="start_date" id="start_date"
                class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                value="{{ old('start_date') }}" required>
            @error('start_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="end_date" class="block text-gray-700 font-semibold">End Date (neobvezno):</label>
            <input type="date" name="end_date" id="end_date"
                class="form-input rounded-lg w-full focus:outline-none border-gray-300 py-3 px-4"
                value="{{ old('end_date') }}">
            @error('end_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit"
            class="bg-zinc-500 text-white px-8 py-3 rounded-lg hover:bg-zinc-600 focus:outline-none transition duration-300">Dodaj
        </button>
    </form>


    <form action="" method="GET" class="flex flex-col items-start">
        <div class="flex mb-4" id="news">
            <input type="text" name="search_leagues" id="search_news" placeholder="Iskanje"
                class="form-input rounded-lg py-3 px-4 w-full h-12 sm:w-64 mb-2 sm:mb-0 focus:outline-none "
                value="{{ isset($search_leagues) ? $search_leagues : '' }}">
            <button type="submit"
                class="bg-zinc-600 text-white px-6 h-12 ml-2 rounded-lg hover:bg-zinc-700 focus:outline-none focus:bg-zinc-7s00">Iskanje
            </button>
        </div>
    </form>
    <!-- Display list of leagues with edit and delete buttons -->
    <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @if ($leagues->isEmpty())
            <h2 class="p-4 text-gray-900">Nismo našli nobene lige.</h2>
        @else
            @foreach ($leagues as $item)
                <li class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <!-- League Details -->
                    <div class="flex items-center justify-between mb-4 overflow-hidden">
                        <div>
                            <h3 class="text-xl font-bold mb-2">{{ $item->name }}</h3>
                            <p class="text-gray-700 line-clamp-3">{{ $item->description }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 mt-4">
                                <span class="text-sm font-semibold">Od:</span>
                                <span
                                    class="text-sm">{{ \Carbon\Carbon::parse($item->start_date)->format('d.m.Y') }}</span>
                                @if ($item->end_date)
                                    <span class="text-sm font-semibold ml-4">Do:</span>
                                    <span
                                        class="text-sm">{{ \Carbon\Carbon::parse($item->end_date)->format('d.m.Y') }}</span>
                                @endif
                            </p>
                        </div>
                        @if ($item->l_home_page)
                            <div class="mr-4">
                                <img src="{{ asset('images/home.png') }}" alt="Home" class="w-5 h-5">
                            </div>
                        @endif
                    </div>
                    <div class="flex items-center justify-between">
                        <p>
                            <span class="text-sm font-semibold text-gray-500">Ustvarjeno:</span>
                            <span
                                class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($item->created_at)->format('d.m.Y') }}</span>
                        </p>
                        <div class="flex items-center">
                            <a href="{{ route('bracket_setup', $item->id) }}"
                                class="text-blue-500 hover:underline mr-4">Uredi</a>
                            <!-- Delete Form with Confirmation Dialog -->
                            <form id="deleteForm{{ $item->id }}"
                                action="{{ route('league.destroy', ['league' => $item->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    onclick="showDeleteConfirmation('deleteForm', {{ $item->id }})"
                                    class="text-red-500 hover:underline">Izbriši</button>
                            </form>
                        </div>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
    <div class="p-4">{{ $leagues->links() }}</div>
</div>

<x-layout :message="$message ?? null" :flash="$flash ?? null" :model="$model ?? null">
    <!-- Include Delete Confirmation Component -->
    <x-delete-confirmation />

    <x-admin-title title="Adminstracijska plošča" />

    <div id="lige">
        <x-title-admin title="Lige in turnirji" divId="admin_lige" />
    </div>

    <div class="bg-gray-200">

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

        <div id="igralci">
            <x-title-admin title="Igralci" divId="admin_igralci" />
        </div>
        <!-- Players Section -->
        <div class="container mx-auto pt-4 px-4 mb-8" id="admin_igralci" style="display: none">
            <div class="mb-4">
                <form action="{{ route('players_store') }}" method="POST"
                    class="bg-gray-100 rounded-lg overflow-hidden">
                    <div class="bg-zinc-900 text-white py-2 px-4 rounded-t-lg">
                        <h2 class="text-xl font-bold">Dodaj igralca</h2>
                    </div>
                    <div class="p-4">
                        @csrf
                        <div class="flex flex-col mb-2 sm:flex-row">
                            <div class="flex flex-col mr-4 mb-2 sm:mb-0">
                                <label for="p_name" class="mb-2">Ime:</label>
                                <input type="text" name="p_name" id="p_name" placeholder="Vnesi ime igralca"
                                    class="form-input rounded-lg py-3 px-4 w-full sm:w-64 mb-2 sm:mb-0 focus:outline-none "
                                    value="{{ old('p_name') }}" required>
                                @error('p_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex flex-col mr-4 mb-2 sm:mb-0">
                                <label for="points" class="mb-2">Točke:</label>
                                <input type="number" name="points" id="points" value="0" min="0"
                                    class="form-input rounded-lg py-3 px-4 w-full sm:w-24 mb-2 sm:mb-0 focus:outline-none "
                                    value="{{ old('points') }}" required>
                                @error('points')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex items-end pb-4 sm:mb-0">
                                <input type="checkbox" name="is_fake" id="is_fake"
                                    class="mr-2 bg-gray-300 rounded-sm h-5 w-5" onchange="togglePointsInput()"
                                    value="1">
                                <label for="is_fake" class="text-gray-700 font-semibold mr-4">Ni na ATP
                                    lestvici</label>
                                @error('is_fake')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex flex-col mr-4">
                                <button type="submit"
                                    class="bg-zinc-600 text-white mt-8 px-3 py-3 rounded-lg hover:bg-zinc-700 focus:outline-none focus:bg-zinc-700">Dodaj</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <form action="" method="GET" class="flex flex-col items-start">
                <div class="flex mb-4" id="players">
                    <input type="text" name="search_players" id="search_players" placeholder="Iskanje"
                        class="form-input rounded-lg py-3 px-4 w-full h-12 sm:w-64 mb-2 sm:mb-0 focus:outline-none"
                        value="{{ isset($search_players) ? $search_players : '' }}">
                    <button type="submit"
                        class="bg-zinc-600 text-white px-6 h-12 ml-2 rounded-lg hover:bg-zinc-700 focus:outline-none focus:bg-zinc-7s00">Iskanje
                    </button>
                </div>
            </form>

            <!-- Display list of players with edit and delete buttons -->
            <ul class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-3">
                @if ($players->isEmpty())
                    <h2 class="p-4 text-gray-900">Nismo našli nobenega igralca.</h2>
                @else
                    @foreach ($players as $player)
                        <li class="rounded-lg shadow-md p-3 bg-white">
                            <div class="flex flex-col md:flex-row justify-between items-center">
                                <div class="mb-2 md:mb-0">
                                    <p
                                        class="text-xl font-semibold {{ $player->is_fake ? 'text-gray-400' : 'text-gray-900' }}">
                                        {{ $player->p_name }}</p>
                                    <p class="text-gray-600">Točke: {{ $player->points }}</p>
                                </div>
                                <div class="flex items-center">
                                    <!-- Form to add points -->
                                    <form action="{{ route('players_add_points', ['player_id' => $player->id]) }}"
                                        method="POST" class="mr-4">
                                        @csrf
                                        <input type="number" name="points" id="points" placeholder="Točke"
                                            class="form-input rounded-lg pl-2 h-8 w-16 focus:outline-none bg-gray-300"
                                            required>
                                        <button type="submit"
                                            class="bg-green-500 text-white px-2 py-1 rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600">Dodaj</button>
                                    </form>
                                    <!-- Edit and Delete buttons -->
                                    <a href="{{ route('player_edit', $player->id) }}"
                                        class="text-blue-500 hover:underline mr-4">Uredi</a>
                                    <form id="deletePlayersForm{{ $player->id }}"
                                        action="{{ route('players_destroy', ['player' => $player->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            onclick="showDeleteConfirmation('deletePlayersForm', {{ $player->id }})"
                                            class="text-red-500 hover:underline">Izbriši</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach

                @endif
            </ul>
            <div class="p-2">{{ $players->links('pagination::tailwind') }}</div>
        </div>

        <!-- News Section -->
        <div id="novice">
            <x-title-admin title="Novice" divId="admin_novice" />
        </div>

        <div class="container mx-auto mt-3 mb-8 px-4" id="admin_novice" style="display: none">
            <!-- Add new news form -->
            <div class="bg-zinc-900 text-white py-2 px-4 rounded-t-lg">
                <h2 class="text-xl font-bold">Dodaj novice</h2>
            </div>
            <form action="{{ route('news_store') }}" method="POST" class="mb-5 bg-gray-100 rounded-lg p-6"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-semibold">Naslov:</label>
                    <input type="text" name="title" id="title" placeholder="Vnesite naslov"
                        class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                        value="{{ old('title') }}" required>
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="content" class="block text-gray-700 font-semibold">Vsebina:</label>
                    <textarea name="content" id="content" placeholder="Vnesite vsebino"
                        class="form-textarea rounded-lg w-full h-48 focus:outline-none  border-gray-300 py-3 px-4" required>{{ old('content') }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="file" class="block text-gray-700 font-semibold">Datoteka:</label>
                    <input type="file" name="image" id="image"
                        class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3"
                        value="{{ old('image') }}">
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                    class="bg-zinc-500 text-white px-8 py-3 rounded-lg hover:bg-zinc-600 focus:outline-none transition duration-300">Dodaj
                </button>
            </form>


            <form action="" method="GET" class="flex flex-col items-start">
                <div class="flex mb-4" id="news">
                    <input type="text" name="search_news" id="search_news" placeholder="Iskanje"
                        class="form-input rounded-lg py-3 px-4 w-full h-12 sm:w-64 mb-2 sm:mb-0 focus:outline-none "
                        value="{{ isset($search_news) ? $search_news : '' }}">
                    <button type="submit"
                        class="bg-zinc-600 text-white px-6 h-12 ml-2 rounded-lg hover:bg-zinc-700 focus:outline-none focus:bg-zinc-7s00">Iskanje
                    </button>
                </div>
            </form>
            <!-- Display list of news with edit and delete buttons -->
            <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @if ($news->isEmpty())
                    <h2 class="p-4 text-gray-900">Nismo našli nobene novice.</h2>
                @else
                    @foreach ($news as $item)
                        <li class="bg-white rounded-lg shadow-md p-6 overflow-hidden">
                            <h3 class="text-xl font-bold mb-2">{{ $item->title }}</h3>
                            <p class="text-gray-700 line-clamp-3">{{ $item->content }}</p>
                            <p class="text-gray-500 mt-2"> {{ $item->created_at->format('d.m.Y') }}</p>
                            <div class="flex justify-end mt-4">
                                <a href="{{ route('news_edit_view', $item->id) }}"
                                    class="text-blue-500 hover:underline mr-4">Uredi</a>
                                <!-- Delete Form with Confirmation Dialog -->
                                <form id="deleteNewsForm{{ $item->id }}"
                                    action="{{ route('news_destroy', ['news' => $item->id]) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="button"
                                        onclick="showDeleteConfirmation('deleteNewsForm', {{ $item->id }})"
                                        class="text-red-500 hover:underline">Izbriši</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                @endif
            </ul>
            <div class="p-4">{{ $news->links() }}</div>
        </div>

        <!-- Events Section -->
        <div id="dogodki">
            <x-title-admin title="Dogodki" divId="admin_dogodki" />
        </div>
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

        <!-- Gallery Section -->
        <div id="galerija">
            <x-title-admin title="Galerija" divId="admin_galerija" />
        </div>

        <div class="container mx-auto mt-3 pb-6 px-4" id="admin_galerija" style="display: none">
            <!-- Add new gallery form -->
            <div class="bg-zinc-900 text-white py-2 px-4 rounded-t-lg">
                <h2 class="text-xl font-bold">Dodaj Sliko v Galerijo</h2>
            </div>
            <form action="{{ route('gallery_store') }}" method="POST" class="mb-5 bg-gray-100 rounded-lg p-6"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="g_title" class="block text-gray-700 font-semibold">Naslov:</label>
                    <input type="text" name="g_title" id="g_title" placeholder="Vnesite naslov"
                        class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                        value="{{ old('g_title') }}" required>
                    @error('g_title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <input type="checkbox" name="home_page" id="home_page"
                        class="mr-2 bg-gray-300 rounded-sm h-5 w-5" value="1">
                    <label for="is_standin" class="text-gray-700 font-semibold mr-4">Na domači strani</label>
                    @error('home_page')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="mt-4 text-gray-600"><b>Informacija:</b> Na domači strani se pokažejo 3 najnovejše
                        slike označene z "Na domači strani"</p>
                </div>
                <div class="mb-4">
                    <label for="file" class="block text-gray-700 font-semibold">Datoteka:</label>
                    <input type="file" name="g_image" id="g_image"
                        class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3"
                        value="{{ old('g_image') }}">
                    @error('g_image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                    class="bg-zinc-500 text-white px-8 py-3 rounded-lg hover:bg-zinc-600 focus:outline-none transition duration-300">Dodaj
                </button>
            </form>

            <form action="" method="GET" class="flex flex-col items-start">
                <div class="flex mb-4" id="news">
                    <input type="text" name="search_gallery" id="search_gallery" placeholder="Iskanje"
                        class="form-input rounded-lg py-3 px-4 w-full h-12 sm:w-64 mb-2 sm:mb-0 focus:outline-none "
                        value="{{ isset($search_gallery) ? $search_gallery : '' }}">
                    <button type="submit"
                        class="bg-zinc-600 text-white px-6 h-12 ml-2 rounded-lg hover:bg-zinc-700 focus:outline-none focus:bg-zinc-7s00">Iskanje
                    </button>
                </div>
            </form>
            <!-- Display list of images with edit and delete buttons -->
            <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @if ($gallery->isEmpty())
                    <h2 class="p-4 text-gray-900">Nismo našli nobene slike.</h2>
                @else
                    @foreach ($gallery as $item)
                        <li class="flex flex-col bg-gray-100 rounded-lg text-gray-900 shadow-md">
                            <div class="w-full h-64 overflow-hidden rounded-t-lg">
                                <img class="object-cover w-full h-full"
                                    src="{{ asset('storage/' . $item->g_image) }}" alt="{{ $item->g_title }}">
                            </div>
                            <div class="flex justify-between items-center my-2 mx-5">
                                <h2 class="text-lg font-bold mt-1 mb-2">{{ $item->g_title }}</h2>
                                <div class="flex">
                                    @if ($item->home_page)
                                        <div class="mr-4">
                                            <img src="{{ asset('images/home.png') }}" alt="Home"
                                                class="w-5 h-5">
                                        </div>
                                    @endif
                                    <a href="{{ route('gallery_edit', $item->id) }}"
                                        class="text-blue-500 hover:underline mr-4">Uredi</a>
                                    <!-- Delete Form with Confirmation Dialog -->
                                    <form id="deleteGallerysForm{{ $item->id }}"
                                        action="{{ route('gallery_destroy', ['gallery' => $item->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            onclick="showDeleteConfirmation('deleteGallerysForm', {{ $item->id }})"
                                            class="text-red-500 hover:underline">Izbriši</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @endif
            </ul>
            <div class="p-4">{{ $news->links() }}</div>
        </div>
        {{-- <div class="h-3 bg-zinc-900"></div> --}}
</x-layout>

<script>
    function togglePointsInput() {
        var pointsInput = document.getElementById('points');
        var isGroupStageCheckbox = document.getElementById('is_fake');

        pointsInput.disabled = isGroupStageCheckbox.checked;
        if (isGroupStageCheckbox.checked) {
            pointsInput.value = '0';
        }
    }
    window.onload = function() {
        // Loop through each component ID stored in localStorage
        Object.keys(localStorage).forEach(function(key) {
            // Get the visibility state from localStorage
            var displayState = localStorage.getItem(key);
            // Check if the element exists in the DOM
            var component = document.getElementById(key);
            if (component) {
                // Set the visibility of the component based on stored state
                component.style.display = displayState;
            }
        });
    };
</script>

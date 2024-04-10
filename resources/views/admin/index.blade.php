<x-layout :login="$login" :admin="$admin" :scroll="$scroll">

    <x-admin-title title="Adminstracijska plošča" />


    <div class="bg-gray-200 shadow-inner">
        <div class="pb-4 pt-5 md:pt-3 text-gray-100 text-2xl font-bold items-center justify-between max-w-screen-2xl flex flex-wrap mx-auto p-3">
            <div class="flex items-center">
                <button class="bg-zinc-500 hover:bg-zinc-600 text-white font-bold py-2 px-4 rounded mr-4">Urednik lig in turnirjev</button>
                <button class="bg-zinc-500 hover:bg-zinc-600 text-white font-bold py-2 px-4 rounded">Urednik uporabnikov</button>
            </div>
        </div>
    </div>


    <div id="igralci">
        <x-title title="Igralci" />
    </div>
    <div class="bg-gray-200">

        <!-- Players Section -->
        <div class="container mx-auto pt-4 px-4 mb-8">
            <div class="mb-4">
                <form action="{{-- {{ route('players.store') }} --}}" method="POST" class="bg-gray-100 rounded-lg overflow-hidden">
                    <div class="bg-zinc-900 text-white py-2 px-4 rounded-t-lg">
                        <h2 class="text-xl font-bold">Dodaj igralca</h2>
                    </div>
                    <div class="p-4">
                        @csrf
                        <div class="flex flex-col mb-2 sm:flex-row">
                            <div class="flex flex-col mr-4 mb-2 sm:mb-0">
                                <label for="name" class="mb-2">Ime:</label>
                                <input type="text" name="name" id="name" placeholder="Vnesi ime igralca"
                                    class="form-input rounded-lg py-3 px-4 w-full sm:w-64 mb-2 sm:mb-0 focus:outline-none focus:border-blue-500"
                                    required>
                            </div>
                            <div class="flex flex-col mr-4 mb-2 sm:mb-0">
                                <label for="points" class="mb-2">Točke:</label>
                                <input type="number" name="points" id="points" value="0" min="0"
                                    class="form-input rounded-lg py-3 px-4 w-full sm:w-24 mb-2 sm:mb-0 focus:outline-none focus:border-blue-500"
                                    required>
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
                        class="form-input rounded-lg py-3 px-4 w-full h-12 sm:w-64 mb-2 sm:mb-0 focus:outline-none focus:border-blue-500"
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
                        <li class="bg-white rounded-lg shadow-md p-3">
                            <div class="flex flex-col md:flex-row justify-between items-center">
                                <div class="mb-2 md:mb-0">
                                    <p class="text-xl font-semibold">{{ $player->name }}</p>
                                    <p class="text-gray-600">Točke: {{ $player->points }}</p>
                                </div>
                                <div class="flex items-center">
                                    <!-- Form to add points -->
                                    <form action="{{-- {{ route('players.add_points', $player->id) }} --}}" method="POST" class="mr-4">
                                        @csrf
                                        <input type="number" name="points" id="points" placeholder="Točke"
                                            class="form-input rounded-lg pl-2 h-8 w-16 focus:outline-none focus:border-blue-500 bg-gray-300"
                                            required>
                                        <button type="submit"
                                            class="bg-green-500 text-white px-2 py-1 rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600">Dodaj</button>
                                    </form>
                                    <!-- Edit and Delete buttons -->
                                    <a href="{{-- {{ route('players.edit', $player->id) }} --}}" class="text-blue-500 hover:underline mr-4">Uredi</a>
                                    <form action="{{-- {{ route('players.destroy', $player->id) }} --}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 hover:underline bg-transparent border-none">Zbriši</button>
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
            <x-title title="Novice" />
        </div>

        <div class="container mx-auto mt-3 mb-8 px-4">
            <!-- Add new news form -->
            <div class="bg-zinc-900 text-white py-2 px-4 rounded-t-lg">
                <h2 class="text-xl font-bold">Dodaj novice</h2>
            </div>
            <form action="{{-- {{ route('news.store') }} --}}" method="POST" class="mb-5 bg-gray-100 rounded-lg p-6" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-semibold">Naslov:</label>
                    <input type="text" name="title" id="title" placeholder="Vnesite naslov"
                        class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4" required>
                </div>
                <div class="mb-4">
                    <label for="content" class="block text-gray-700 font-semibold">Vsebina:</label>
                    <textarea name="content" id="content" placeholder="Vnesite vsebino"
                        class="form-textarea rounded-lg w-full h-48 focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="file" class="block text-gray-700 font-semibold">Datoteka:</label>
                    <input type="file" name="file" id="file"
                        class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4" required>
                </div>
                <button type="submit"
                    class="bg-zinc-500 text-white px-8 py-3 rounded-lg hover:bg-zinc-600 focus:outline-none focus:bg-blue-600 transition duration-300">Dodaj
                </button>
            </form>


            <form action="" method="GET" class="flex flex-col items-start">
                <div class="flex mb-4" id="news">
                    <input type="text" name="search_news" id="search_news" placeholder="Iskanje"
                        class="form-input rounded-lg py-3 px-4 w-full h-12 sm:w-64 mb-2 sm:mb-0 focus:outline-none focus:border-blue-500"
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
                        <li class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-xl font-bold mb-2">{{ $item->title }}</h3>
                            <p class="text-gray-700">{{ $item->content }}</p>
                            <p class="text-gray-500 mt-2"> {{ $item->created_at->format('d.m.Y') }}</p>
                            <div class="flex justify-end mt-4">
                                <a href="{{-- {{ route('news.edit', $item->id) }} --}}" class="text-blue-500 hover:underline mr-4">Edit</a>
                                <form action="{{-- {{ route('news.destroy', $item->id) }} --}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Delete</button>
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
            <x-title title="Dogodki" />
        </div>
        <div class="container mx-auto mt-3 px-4">
            <!-- Add new events form -->
            <div class="bg-zinc-900 text-white py-2 px-4 rounded-t-lg">
                <h2 class="text-xl font-bold">Dodaj dogodek</h2>
            </div>
            <form action="{{-- {{ route('events.store') }} --}}" method="POST" class="mb-5 bg-gray-100 rounded-lg p-6">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-semibold">Naslov:</label>
                    <input type="text" name="title" id="title" placeholder="Vnesite naslov dogodka"
                        class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4"
                        required>
                </div>
                <div class="mb-4">
                    <label for="content" class="block text-gray-700 font-semibold">Vsebina:</label>
                    <textarea name="content" id="content" placeholder="Vnesite opis dogodka"
                        class="form-textarea rounded-lg w-full h-48 focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4"
                        required></textarea>
                </div>
                <div class="mb-4">
                    <label for="datetime" class="block text-gray-700 font-semibold">Datum in čas začetka:</label>
                    <input type="datetime-local" name="datetime" id="datetime"
                        class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4"
                        required>
                </div>
                <div class="mb-4">
                    <label for="datetime" class="block text-gray-700 font-semibold">Datum in čas zaključka
                        (neobvezno):</label>
                    <input type="datetime-local" name="datetime" id="datetime"
                        class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4"
                        required>
                </div>
                <button type="submit"
                    class="bg-zinc-500 text-white px-8 py-3 rounded-lg hover:bg-zinc-600 focus:outline-none focus:bg-blue-600 transition duration-300">
                    Dodaj
                </button>
            </form>


            <form action="" method="GET" class="flex flex-col items-start">
                <div class="flex mb-4" id="events">
                    <input type="text" name="search_events" id="search_events" placeholder="Iskanje"
                        class="form-input rounded-lg py-3 px-4 w-full h-12 sm:w-64 mb-2 sm:mb-0 focus:outline-none focus:border-blue-500"
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
                        <li class="bg-white rounded-lg shadow-md p-6 mb-4">
                            <h3 class="text-xl font-bold mb-2">{{ $item->title }}</h3>
                            <p class="text-gray-700">{{ $item->description }}</p>
                            <p class="text-gray-500 mt-4">
                                <span class="font-semibold">From:</span>
                                {{ \Carbon\Carbon::parse($item->fromDate)->format('d.m.Y H:i') }}
                                <span class="font-semibold ml-4">To:</span>
                                {{ \Carbon\Carbon::parse($item->toDate)->format('d.m.Y H:i') }}
                                <br>
                                <span class="font-semibold">Location:</span> {{ $item->location }}
                            </p>
                            <div class="flex justify-end mt-4">
                                <a href="{{-- {{ route('news.edit', $item->id) }} --}}" class="text-blue-500 hover:underline mr-4">Edit</a>
                                <form action="{{-- {{ route('news.destroy', $item->id) }} --}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                @endif
            </ul>
            <div class="p-4">{{ $events->links() }}</div>
        </div>
    </div>
</x-layout>

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

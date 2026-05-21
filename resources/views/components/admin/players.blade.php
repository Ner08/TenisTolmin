<div class="container mx-auto pt-4 px-4 mb-8" id="admin_igralci" style="display: none">
    <div class="mb-6">
        <form action="{{ route('players_store') }}" method="POST" class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="bg-gray-900 text-white px-5 py-3">
                <h2 class="text-sm font-semibold">Dodaj igralca</h2>
            </div>
            <div class="p-5">
                @csrf
                <div class="flex flex-wrap gap-4 items-end">
                    <div class="flex flex-col flex-1 min-w-[180px]">
                        <label for="p_name" class="text-xs font-semibold text-gray-700 mb-1.5">Ime</label>
                        <input type="text" name="p_name" id="p_name" placeholder="Vnesi ime igralca"
                            class="border border-gray-200 rounded-lg py-2.5 px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"
                            value="{{ old('p_name') }}" required>
                        @error('p_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col w-28">
                        <label for="points" class="text-xs font-semibold text-gray-700 mb-1.5">Točke</label>
                        <input type="number" name="points" id="points" value="0" min="0"
                            class="border border-gray-200 rounded-lg py-2.5 px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"
                            value="{{ old('points') }}" required>
                        @error('points')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center gap-2 pb-2.5">
                        <input type="checkbox" name="is_fake" id="is_fake"
                            class="w-4 h-4 rounded border-gray-300 text-amber-500 focus:ring-amber-500" onchange="togglePointsInput()"
                            value="1">
                        <label for="is_fake" class="text-sm text-gray-700">Ni na ATP lestvici</label>
                        @error('is_fake')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="pb-0.5">
                        <button type="submit"
                            class="bg-gray-900 text-white text-sm px-5 py-2.5 rounded-lg hover:bg-gray-700 transition-colors whitespace-nowrap">
                            Dodaj
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <form action="" method="GET">
        <div class="flex mb-5">
            <input type="text" name="search_players" id="search_players" placeholder="Iskanje igralcev..."
                class="border border-gray-200 rounded-l-lg py-2.5 px-3.5 text-sm w-full sm:w-72 focus:outline-none focus:ring-2 focus:ring-amber-500"
                value="{{ isset($search_players) ? $search_players : '' }}">
            <button type="submit"
                class="bg-gray-900 text-white text-sm px-5 rounded-r-lg hover:bg-gray-700 transition-colors flex-shrink-0">
                Išči
            </button>
        </div>
    </form>

    <ul class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-3">
        @if ($players->isEmpty())
            <p class="text-sm text-gray-500 col-span-3 py-4">Nismo našli nobenega igralca.</p>
        @else
            @foreach ($players as $player)
                <li class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                    <div class="flex items-center justify-between px-4 py-3">
                        <div>
                            <p class="text-sm font-semibold {{ $player->is_fake ? 'text-gray-400' : 'text-gray-900' }}">
                                {{ $player->p_name }}
                            </p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $player->points }} točk</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <form action="{{ route('players_add_points', ['player_id' => $player->id]) }}"
                                method="POST" class="flex items-center gap-1.5">
                                @csrf
                                <input type="number" name="points" placeholder="±"
                                    class="border border-gray-200 rounded-lg pl-2 h-8 w-14 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"
                                    required>
                                <button type="submit"
                                    class="bg-amber-500 text-white text-xs px-2.5 h-8 rounded-lg hover:bg-amber-600 transition-colors font-medium">
                                    +
                                </button>
                            </form>
                            <a href="{{ route('player_edit', $player->id) }}"
                                class="text-xs font-medium text-gray-700 bg-white border border-gray-200 px-3 py-1.5 rounded-lg hover:border-gray-300 transition-colors">
                                Uredi
                            </a>
                            <form id="deletePlayersForm{{ $player->id }}"
                                action="{{ route('players_destroy', ['player' => $player->id]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    onclick="showDeleteConfirmation('deletePlayersForm', {{ $player->id }})"
                                    class="text-xs font-medium text-red-600 bg-white border border-red-200 px-3 py-1.5 rounded-lg hover:bg-red-50 transition-colors">
                                    Izbriši
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
    <div class="mt-3">{{ $players->links('pagination::tailwind') }}</div>
</div>

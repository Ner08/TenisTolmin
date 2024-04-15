<x-layout :login="$login" :admin="$admin">
    <x-admin-title-simple :title="'Liga / Turnir • ' . $bracket->league->name" />
    <x-title :title="'Skupina • ' . $bracket->name" />
    @php
        $lastRound = $bracket->matchUps->max('round') ?? 10;
        $roundTitles = [
            1 => ['Finale'],
            2 => ['Polfinale', 'Finale'],
            3 => ['Četrtfinale', 'Polfinale', 'Finale'],
            4 => ['Osminafinala', 'Četrtfinale', 'Polfinale', 'Finale'],
            5 => ['1.Krog', 'Osminafinala', 'Četrtfinale', 'Polfinale', 'Finale'],
            6 => ['1.Krog', '2.Krog', 'Osminafinala', 'Četrtfinale', 'Polfinale', 'Finale'],
            7 => ['1.Krog', '2.Krog', '3.Krog', 'Osminafinala', 'Četrtfinale', 'Polfinale', 'Finale'],
            8 => [
                '1.Krog',
                '2.Krog',
                '3.Krog',
                '4.Krog',
                '5.Krog',
                'Osminafinala',
                'Četrtfinale',
                'Polfinale',
                'Finale',
            ],
            9 => [
                '1.Krog',
                '2.Krog',
                '3.Krog',
                '4.Krog',
                '5.Krog',
                '6.Krog',
                'Osminafinala',
                'Četrtfinale',
                'Polfinale',
                'Finale',
            ],
            10 => ['Tekme še niso določene.'],
        ];

        // Calculate the width of each column
        $colWidth = 12 / $lastRound; // Divide 12 (the number of columns in Bootstrap grid system) by the total number of rounds
    @endphp

    @if ($bracket->is_group_stage)
        @include('partials._admin_league_group_stage', ['bracket' => $bracket])
    @else
        @include('partials._admin_league', ['bracket' => $bracket])
    @endif

    <div class="bg-gray-200">
        <div class="container mx-auto pt-4 px-4 ">
            <div class="bg-zinc-900 text-white py-2 px-4 rounded-t-lg">
                <h2 class="text-xl font-bold">Dodaj igro</h2>
            </div>

            <form action="{{ route('leagues.bracket_store') }}" method="POST" class="mb-5 bg-gray-100 rounded-lg p-6">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold">Ime skupine:</label>
                    <input type="text" name="name" id="name" placeholder="Vnesite ime skupine"
                        class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-semibold">Opis:</label>
                    <textarea name="description" id="description" placeholder="Vnesite opis skupine" value="{{old('description')}}"
                        class="form-textarea rounded-lg w-full h-48 focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4"></textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="is_group_stage">Skupinski del</label>
                    <input type="checkbox" name="is_group_stage" id="is_group_stage" class="ml-2" value="1">
                    @error('is_group_stage')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4 mb-4" id="teamsContainer">
                    <label for="teams" class="block text-gray-700 font-semibold mb-2">Ekipe:</label>
                    <div id="teamsInputs">
                        <div class="mb-2 teamInput">
                            <div class="border-b-2 border-gray-300 pb-4">
                                <input type="text" name="teams[0][name]" placeholder="Ime ekipe (neobvezno)"
                                    class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3">
                                <select name="teams[0][player_ids][]"
                                    class="form-select rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3"
                                    required>
                                    <option value="">Izberi prvega igralca</option>
                                    <!-- Use foreach to generate dropdown options for players -->
                                    @foreach ($players as $player)
                                        <option value="{{ $player->id }}">{{ $player->name }}</option>
                                    @endforeach
                                </select>
                                @error('teams.0.player_ids.0')
                                    {{-- Error for the first player ID --}}
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <select name="teams[0][player_ids][]"
                                    class="form-select rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-1">
                                    <option value="">Izberi drugega igralca (neobvezno)</option>
                                    <!-- Use foreach to generate dropdown options for players -->
                                    @foreach ($players as $player)
                                        <option value="{{ $player->id }}">{{ $player->name }}</option>
                                    @endforeach
                                </select>
                                @error('teams.0.player_ids.1')
                                    {{-- Error for the second player ID --}}
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="button" id="addTeamBtn"
                        class="bg-zinc-900 text-white px-4 py-2 rounded-lg hover:bg-zinc-800 focus:outline-none mt-4">Dodaj
                        ekipo</button>
                </div>

                <button type="submit"
                    class="bg-zinc-500 text-white px-8 py-3 rounded-lg hover:bg-zinc-600 focus:outline-none transition duration-300 mt-2">Dodaj
                    skupino
                </button>
            </form>
            <!-- Display list of brackets with edit and delete buttons -->
            <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @if ($matchups->isEmpty())
                    <h2 class="p-4 text-gray-900">Nismo našli nobene skupine.</h2>
                @else
                    @foreach ($matchups as $item)
                        <li class="bg-white rounded-lg shadow-md p-6 mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-xl font-bold mb-2">{{ $item->team_name }}</h3>
                                    <p class="text-gray-700">{{ $item->description }}</p>
                                </div>
                            </div>
                            <div class="text-sm underline text-gray-500">
                                {{ $item->is_group_stage ? 'Skupinski del' : 'Izločitveni del' }}</div>
                            <div class="flex items-center justify-between">
                                <p>
                                    <span class="text-sm font-semibold text-gray-500">Ustvarjeno:</span>
                                    <span
                                        class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($item->created_at)->format('d.m.Y') }}</span>
                                </p>
                                <div class="flex items-center">
                                    <a href="{{-- {{ route('news.edit', $item->id) }} --}}" class="text-blue-500 hover:underline mr-4">Uredi</a>
                                    <form action="{{-- {{ route('news.destroy', $item->id) }} --}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">Izbriši</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @endif
            </ul>

            <div class="p-4">{{ $matchups->links() }}</div>
        </div>
    </div>
</x-layout>

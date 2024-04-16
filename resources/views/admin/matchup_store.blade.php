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
            <form action="{{-- {{ route('leagues.matchup_store') }} --}}" method="POST" class="mb-5 bg-gray-100 rounded-lg p-6">
                @csrf
                <!-- Team 1 Inputs -->
                <div class="mb-4">
                    <label for="teams" class="block text-gray-700 font-semibold mb-2">Igralec / Ekipa 1:</label>
                    <div>
                        <!-- Team 1 ID -->
                        <select name="team1_id" class="form-select rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3" required>
                            <option value="">Izberite ekipo</option>
                            <!-- Use foreach to generate dropdown options for players -->
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}">{{ isset($team->name) ? $team->name : (isset($team->p2_id) ? $team->p2_name : $team->p1_name) }}</option>
                            @endforeach
                        </select>
                        @error('team1_id')
                            {{-- Error for the first player ID --}}
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Team 2 Inputs -->
                <div class="mb-4">
                    <label for="teams" class="block text-gray-700 font-semibold mb-2">Igralec / Ekipa 2:</label>
                    <div>
                        <!-- Team 2 ID -->
                        <select name="team2_id" class="form-select rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3" required>
                            <option value="">Izberite ekipo</option>
                            <!-- Use foreach to generate dropdown options for players -->
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}">{{ isset($team->name) ? $team->name : (isset($team->p2_id) ? $team->p2_name : $team->p1_name) }}</option>
                            @endforeach
                        </select>
                        @error('team2_id')
                            {{-- Error for the second team ID --}}
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <label for="t1_first_set" class="block text-gray-700 font-semibold mb-2">1. Set:</label>
                <!--Score input -->
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <input type="number" name="t1_first_set" class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3" placeholder="Ekipa/igralec 1 prvi set" />
                    </div>
                    <div>
                        <input type="number" name="t2_first_set" class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3" placeholder="Ekipa/igralec 2 prvi set" />
                    </div>
                </div>

                <label for="t1_first_set" class="block text-gray-700 font-semibold mb-2">2. Set:</label>
                <!-- Repeat for other sets -->
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <input type="number" name="t1_second_set" class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3" placeholder="Ekipa/igralec 1 drugi set" />
                    </div>
                    <div>
                        <input type="number" name="t2_second_set" class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3" placeholder="Ekipa/igralec 2 drugi set" />
                    </div>
                </div>

                <label for="t1_first_set" class="block text-gray-700 font-semibold mb-2">3. Set:</label>
                <!-- Repeat for other sets -->
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <input type="number" name="t1_third_set" min="0" class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3" placeholder="Ekipa/igralec 1 tretji set" />
                    </div>
                    <div>
                        <input type="number" name="t2_third_set" min="0" class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3" placeholder="Ekipa/igralec 2 tretji set" />
                    </div>
                </div>

                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <label for="round" class="block text-gray-700 font-semibold mb-2">Runda:</label>
                        <input type="number" name="round" min="0" max="9" class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3" placeholder="Enter Round" />
                    </div>
                </div>

                <!-- End of Additional Inputs -->

                <!-- Submit Button -->
                <button type="submit" class="bg-zinc-500 text-white px-8 py-3 rounded-lg hover:bg-zinc-600 focus:outline-none transition duration-300 mt-2">Dodaj igro</button>
            </form>

            <!-- Display list of brackets with edit and delete buttons -->
            <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @if ($matchups->isEmpty())
                    <h2 class="p-4 text-gray-900">Nismo našli nobene igre.</h2>
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

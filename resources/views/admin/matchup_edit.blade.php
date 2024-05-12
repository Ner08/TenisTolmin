<x-layout :message="$message ?? null" :flash="$flash ?? null" :model="$model ?? null">
    <div class="bg-gray-200 pb-5">
        <div class="container mx-auto pt-4 px-4">
            <div class="bg-zinc-900 text-white py-2 px-4 rounded-t-lg">
                <h2 class="text-xl font-bold">Uredi igro</h2>
            </div>
            <form action="{{ route('leagues.matchup_edit', ['customMatchup' => $matchup->id]) }}" method="POST" class="bg-gray-100 rounded-lg p-6">
                @method('PUT')
                @csrf
                <!-- Team 1 Inputs -->
                <div class="mb-4">
                    <input type="hidden" name="bracket_id" value="{{ $bracket->id }}">
                    <label for="teams" class="block text-gray-700 font-semibold mb-2">Igralec / Ekipa 1:</label>
                    <div>
                        <!-- Team 1 ID -->
                        <select name="team1_id"
                            class="form-select rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3">
                            <option disabled required>Izberite ekipo</option>
                            <!-- Use foreach to generate dropdown options for players -->
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}" @if ($team->id == $matchup->team1_id) selected @endif>
                                    {{ $team->playerNames() }}
                                </option>
                            @endforeach
                        </select>
                        @error('team1_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Oznaka for non-group stage -->
                    @if (!$bracket->is_group_stage)
                        <label for="t1_tag"
                            class="block bg-gray-400 text-white font-semibold text-sm py-1 mb-0 px-4 mt-3 rounded-b-none rounded-lg">Oznaka</label>
                        <input type="text" name="t1_tag"
                            class="form-input w-full focus:outline-none border-gray-300 py-2 px-4 mt-0 rounded-t-none rounded-lg"
                            placeholder="Oznaka igralca / ekipe" value="{{ $matchup->t1_tag }}"/>
                        @error('t1_tag')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <!-- Team 2 Inputs -->
                <div class="mb-4">
                    <label for="teams" class="block text-gray-700 font-semibold mb-2">Igralec / Ekipa 2:</label>
                    <div>
                        <!-- Team 2 ID -->
                        <select name="team2_id"
                            class="form-select rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3">
                            <option disabled required>Izberite ekipo</option>
                            <!-- Use foreach to generate dropdown options for players -->
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}" @if ($team->id == $matchup->team2_id) selected @endif>
                                    {{ $team->playerNames() }}
                                </option>
                            @endforeach
                        </select>
                        @error('team2_id')
                            {{-- Error for the second team ID --}}
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Oznaka for non-group stage -->
                    @if (!$bracket->is_group_stage)
                        <label for="t2_tag"
                            class="block bg-gray-400 text-white font-semibold text-sm py-1 mb-0 px-4 mt-3 rounded-b-none rounded-lg">Oznaka</label>
                        <input type="text" name="t2_tag"
                            class="form-input w-full focus:outline-none border-gray-300 py-2 px-4 mt-0 rounded-t-none rounded-lg"
                            placeholder="Oznaka igralca / ekipe" value="{{ $matchup->t2_tag }}"/>
                        @error('t2_tag')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    @endif
                </div>


                <label for="t1_first_set" class="block text-gray-700 font-semibold mb-2">1. Set:</label>
                <!--Score input -->
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <input type="number" name="t1_first_set"
                            class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3"
                            placeholder="Ekipa/igralec 1 prvi set" value="{{ $matchup->t1_first_set }}"/>
                    </div>
                    <div>
                        <input type="number" name="t2_first_set"
                            class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3"
                            placeholder="Ekipa/igralec 2 prvi set" value="{{ $matchup->t2_first_set }}"/>
                    </div>
                </div>
                @error('t1_first_set')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                @error('t2_first_set')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <label for="t1_first_set" class="block text-gray-700 font-semibold mb-2">2. Set:</label>
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <input type="number" name="t1_second_set"
                            class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3"
                            placeholder="Ekipa/igralec 1 drugi set" value="{{ $matchup->t1_second_set }}"/>
                    </div>
                    <div>
                        <input type="number" name="t2_second_set"
                            class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3"
                            placeholder="Ekipa/igralec 2 drugi set" value="{{ $matchup->t2_second_set }}"/>
                    </div>
                </div>
                @error('t1_second_set')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                @error('t2_second_set')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <label for="t1_first_set" class="block text-gray-700 font-semibold mb-2">3. Set:</label>
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <input type="number" name="t1_third_set" min="0"
                            class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3"
                            placeholder="Ekipa/igralec 1 tretji set" value="{{ $matchup->t1_third_set }}"/>
                    </div>
                    <div>
                        <input type="number" name="t2_third_set" min="0"
                            class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3"
                            placeholder="Ekipa/igralec 2 tretji set" value="{{ $matchup->t2_third_set }}"/>
                    </div>
                </div>
                @error('t1_third_set')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                @error('t2_third_set')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <div class="mb-4">
                    <label for="exception" class="block text-gray-700 font-semibold mb-2">Besedilo po meri</label>
                    <input type="text" name="exception"
                        class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3"
                        placeholder="Vnesi besedilo (Prepiše skupni rezultat) Primer: Brez boja " value="{{ $matchup->exception }}"/>
                </div>
                @error('exception')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <label for="round" class="block text-gray-700 font-semibold mb-2">Runda:</label>
                        <input type="number" name="round" min="1" max="9"
                            class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3"
                            placeholder="Vnesi rundo (v katerem krogu bo igra potekala)" value="{{ $matchup->round }}"/>
                    </div>
                </div>
                @error('round')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <!-- Submit Button -->
                <button type="submit"
                    class="bg-zinc-500 text-white px-8 py-3 rounded-lg hover:bg-zinc-600 focus:outline-none transition duration-300 mt-2">Shrani</button>
            </form>
        </div>
    </div>
</x-layout>

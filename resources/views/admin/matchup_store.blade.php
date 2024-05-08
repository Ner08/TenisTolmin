<x-layout :login="$login" :admin="$admin" :message="$message ?? null" :flash="$flash ?? null" :model="$model ?? null">
    <x-admin-title-simple :title="'Liga / Turnir • ' . $bracket->league->name" />
    <x-title :title="'Skupina • ' . $bracket->name" />

    <div class="container mx-auto mt-4 mb-8">
        <div class="bg-zinc-900 text-white py-2 px-4 rounded-t-lg">
            <h2 class="text-xl font-bold">Uredi skupino</h2>
        </div>

        <form action="{{ route('leagues.bracket_store') }}" method="POST" class="mb-5 bg-gray-100 rounded-lg p-6">
            @csrf
            <div class="mb-4">
                <input type="hidden" name="league_id" value="{{ $bracket->league->id }}">
                <label for="name" class="block text-gray-700 font-semibold">Ime skupine:</label>
                <input type="text" name="name" id="name" placeholder="Vnesite ime skupine"
                    class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4"
                    value="{{ $bracket->name }}" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="is_group_stage">Skupinski del</label>
                <input type="checkbox" name="is_group_stage" id="is_group_stage" class="ml-2" value="1"
                    @if ($bracket->is_group_stage == 1) checked @endif>
                @error('is_group_stage')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4" id="pointsDescriptionContainer">
                <label for="points_description" class="block text-gray-700 font-semibold">Opis števila
                    točk:</label>
                <input type="text" name="points_description" id="points_description"
                    placeholder="Vnesite opis števila točk pridobljenih glede na doseženo mesto"
                    class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4"
                    value="{{ old('points_description') }}" @if ($bracket->is_group_stage == 1) disabled @endif>
                @error('points_description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4" id="tagContainer">
                <label for="tag" class="block text-gray-700 font-semibold">Oznaka skupine:</label>
                <input type="text" name="tag" id="tag" placeholder="Vpišite oznako skupine (Primer: A)"
                    class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4"
                    value="{{ old('tag') }}" @if ($bracket->is_group_stage == 0) disabled @endif>
                @error('tag')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4 mb-4" id="teamsContainer">
                <label for="teams"
                    class="block bg-gray-600 text-white font-semibold py-2 mb-2 px-4 rounded">Ekipe:</label>
                <div id="teamsInputs">
                    @php
                        $nonFakeIndex = 0;
                    @endphp
                    @foreach ($bracket->teams as $index => $team)
                        @if ($team->is_fake)
                            @continue
                        @endif
                        <div class="mb-2 team">
                            <label for="teams"
                                class="block bg-gray-400 text-white font-semibold text-sm py-1 mb-2 px-4 rounded">Ekipa
                                {{ $nonFakeIndex + 1 }}</label>
                            <div class="mb-2 teamInput">
                                <div class="border-b-2 border-gray-300 pb-4">
                                    <label for="teamName" class="block text-gray-700 font-semibold">Ime ekipe:</label>
                                    <input type="text" name="teams[{{ $nonFakeIndex }}][name]"
                                        placeholder="Ime ekipe (neobvezno)"
                                        class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3"
                                        value="{{ $team->name }}">
                                    @foreach ($team->players as $playerIndex => $player)
                                        @if ($playerIndex == 0)
                                            <label for="firstPlayer" class="block text-gray-700 font-semibold mt-2">Prvi
                                                igralec:</label>
                                        @elseif ($playerIndex == 1)
                                            <label for="secondPlayer"
                                                class="block text-gray-700 font-semibold mt-2">Drugi
                                                igralec:</label>
                                        @endif
                                        <select name="teams[{{ $nonFakeIndex }}][player_ids][]"
                                            class="form-select rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3"
                                            required>
                                            <option value="">Izberi prvega igralca</option>
                                            <!-- Use foreach to generate dropdown options for players -->
                                            @foreach ($playersSelect as $optionPlayer)
                                                <option value="{{ $optionPlayer->id }}"
                                                    @if ($optionPlayer->id == $player->id) selected @endif>
                                                    {{ $optionPlayer->p_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error("teams.${nonFakeIndex}.player_ids.${playerIndex}")
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    @endforeach
                                    <button type="button" class="removeTeamBtn ml-2">Odstrani</a>
                                </div>
                            </div>
                            @php
                                $nonFakeIndex++;
                            @endphp
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="button" id="addTeamBtn"
                class="bg-zinc-900 text-white px-4 py-2 rounded-lg hover:bg-zinc-800 focus:outline-none mt-1">Dodaj
                ekipo</button>
            <div class="mt-3">
                <button type="submit"
                    class="bg-zinc-500 text-white px-8 py-3 rounded-lg hover:bg-zinc-600 focus:outline-none transition duration-300 mt-2">Shrani
                </button>
            </div>
    </div>


    </div>
    </form>
    </div>

    <x-title title="Igre v skupini" />
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
            8 => ['1.Krog', '2.Krog', '3.Krog', '4.Krog', 'Osminafinala', 'Četrtfinale', 'Polfinale', 'Finale'],
            9 => [
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
            10 => ['Tekme še niso določene.'],
        ];

        // Calculate the width of each column
        $colWidth = 12 / $lastRound; // Divide 12 (the number of columns in Bootstrap grid system) by the total number of rounds
    @endphp
    <div class="mt-4">
        @if ($bracket->is_group_stage)
            @include('partials._admin_league_group_stage', ['bracket' => $bracket])
        @else
            @include('partials._admin_league', ['bracket' => $bracket])
        @endif
    </div>
    <div class="bg-gray-200">
        <div class="container mx-auto pt-4 px-4 ">
            <div class="bg-zinc-900 text-white py-2 px-4 rounded-t-lg">
                <h2 class="text-xl font-bold">Dodaj igro</h2>
            </div>
            <form action="{{ route('leagues.matchup_store') }}" method="POST" class="mb-5 bg-gray-100 rounded-lg p-6">
                @csrf
                <!-- Team 1 Inputs -->
                <div class="mb-4">
                    <input type="hidden" name="bracket_id" value="{{ $bracket->id }}">
                    <label for="teams" class="block text-gray-700 font-semibold mb-2">Igralec / Ekipa 1:</label>
                    <div>
                        <!-- Team 1 ID -->
                        <select name="team1_id"
                            class="form-select rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3">
                            <option required>Izberite ekipo</option>
                            <!-- Use foreach to generate dropdown options for players -->
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}">
                                    {{ $team->playerNames() }}
                                </option>
                            @endforeach
                        </select>
                        @error('team1_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    @if (!$bracket->is_group_stage)
                        <label for="t1_tag"
                            class="block bg-gray-400 text-white font-semibold text-sm py-1 mb-0 px-4 mt-3 rounded-b-none rounded-lg">Oznaka</label>
                        <input type="text" name="t1_tag"
                            class="form-input w-full focus:outline-none border-gray-300 py-2 px-4 mt-0 rounded-t-none rounded-lg"
                            placeholder="Oznaka igralca / ekipe" />
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
                            <option required>Izberite ekipo</option>
                            <!-- Use foreach to generate dropdown options for players -->
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}">
                                    {{ $team->playerNames() }}
                                </option>
                            @endforeach
                        </select>
                        @error('team2_id')
                            {{-- Error for the second team ID --}}
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    @if (!$bracket->is_group_stage)
                        <label for="t2_tag"
                            class="block bg-gray-400 text-white font-semibold text-sm py-1 mb-0 px-4 mt-3 rounded-b-none rounded-lg">Oznaka</label>
                        <input type="text" name="t2_tag"
                            class="form-input w-full focus:outline-none border-gray-300 py-2 px-4 mt-0 rounded-t-none rounded-lg"
                            placeholder="Oznaka igralca / ekipe" />
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
                            placeholder="Ekipa/igralec 1 prvi set" />
                    </div>
                    <div>
                        <input type="number" name="t2_first_set"
                            class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3"
                            placeholder="Ekipa/igralec 2 prvi set" />
                    </div>
                </div>
                @error('t1_first_set')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                @error('t2_first_set')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <label for="t1_first_set" class="block text-gray-700 font-semibold mb-2">2. Set:</label>
                <!-- Repeat for other sets -->
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <input type="number" name="t1_second_set"
                            class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3"
                            placeholder="Ekipa/igralec 1 drugi set" />
                    </div>
                    <div>
                        <input type="number" name="t2_second_set"
                            class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3"
                            placeholder="Ekipa/igralec 2 drugi set" />
                    </div>
                </div>
                @error('t1_second_set')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                @error('t2_second_set')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <label for="t1_first_set" class="block text-gray-700 font-semibold mb-2">3. Set:</label>
                <!-- Repeat for other sets -->
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <input type="number" name="t1_third_set" min="0"
                            class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3"
                            placeholder="Ekipa/igralec 1 tretji set" />
                    </div>
                    <div>
                        <input type="number" name="t2_third_set" min="0"
                            class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3"
                            placeholder="Ekipa/igralec 2 tretji set" />
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
                        placeholder="Vnesi besedilo (Prepiše skupni rezultat) Primer: Brez boja " />
                </div>
                @error('exception')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <label for="round" class="block text-gray-700 font-semibold mb-2">Runda:</label>
                        <input type="number" name="round" min="0" max="9"
                            class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3"
                            placeholder="Vnesi rundo (v katerem krogu bo igra potekala)" />
                    </div>
                </div>
                @error('round')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <!-- End of Additional Inputs -->

                <!-- Submit Button -->
                <button type="submit"
                    class="bg-zinc-500 text-white px-8 py-3 rounded-lg hover:bg-zinc-600 focus:outline-none transition duration-300 mt-2">Dodaj
                    igro</button>
            </form>

            <!-- Display list of brackets with edit and delete buttons -->
            <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @if ($matchups->isEmpty())
                    <h2 class="p-4 text-gray-900">Nismo našli nobene igre.</h2>
                @else
                    @foreach ($matchups as $match)
                        @php
                            $team1 = App\Models\Team::where('id', $match->team1_id)->first();
                            $t1p1 = $team1->player1;
                            $t1p2 = $team1->player2;
                            $team2 = App\Models\Team::where('id', $match->team2_id)->first();
                            $t2p1 = $team2->player1;
                            $t2p2 = $team2->player2;

                            $t1_name =
                                isset($t1p2) ? ($t1p1->p_name . ' | ' . $t1p2->p_name) : $t1p1->p_name;
                            $t2_name =
                                isset($t2p2) ? ($t2p1->p_name . ' | ' . $t2p2->p_name) : $t2p1->p_name;

                            $t1_ranking = ($t1p1->ranking() ?? '') . (isset($t1p2) ? '-' . $t1p2->ranking() : '');
                            $t2_ranking = ($t2p1->ranking() ?? '') . (isset($t2p2) ? '-' . $t2p2->ranking() : '');

                            $winner = $match->winner() ?? null;

                            $t1_sets_won = $match->t1SetsWon();
                            $t2_sets_won = $match->t2SetsWon();
                        @endphp
                        <li class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-md font-semibold text-gray-900 mb-2">{{ $match->round }}.
                                        Runda</h3>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $t1_name }} -
                                        {{ $t2_name }}</h3>
                                    @if (isset($match->exception))
                                        <div class="inline-block mt-2">
                                            <h4 class="text-xl font-bold text-gray-500 mx-auto">
                                                <span
                                                    class="bg-gray-900 text-gray-100 px-2 py-1 rounded">{{ $match->exception }}</span>
                                            </h4>
                                        </div>
                                    @elseif (isset($match->endResult))
                                        <div class="inline-block mt-2">
                                            <h4 class="text-xl font-bold text-gray-500 mx-auto">
                                                <span
                                                    class="bg-gray-900 text-gray-100 px-2 py-1 rounded">{{ $match->endResult }}</span>
                                            </h4>
                                        </div>
                                    @endif
                                </div>

                            </div>
                            <p>
                                <span class="text-sm font-semibold text-gray-500">Ustvarjeno:</span>
                                <span
                                    class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($match->created_at)->format('d.m.Y') }}</span>
                            </p>
                            <div class="flex items-center">
                                <a href="{{-- {{ route('matchup_setup', $match->id) }} --}}" class="text-blue-500 hover:underline mr-4">Uredi</a>
                                <form id="deleteForm{{ $match->id }}"
                                    action="{{ route('league.matchup_destroy', ['matchup' => $match->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="showDeleteConfirmation('deleteForm', {{ $item->id }})"
                                        class="text-red-500 hover:underline">Izbriši</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                @endif
                <x-delete-confirmation/>
            </ul>
            <div class="p-4">{{ $matchups->links() }}</div>
        </div>
    </div>
</x-layout>

<style>
    .removeTeamBtn {
        background-color: transparent;
        border: none;
        margin-top: 10px;
        color: #EF4444;
        cursor: pointer;
        font-size: 15px;
        outline: none;
        transition: color 0.3s ease;
    }

    .removeTeamBtn:hover {
        color: #DC2626;
    }

    input:disabled {
        background-color: #e2e5ea;
        /* Custom color */
    }

    .team {
        border: 0;
        margin: 0;
        padding: 0;
    }
</style>

<script>
    // Add team input field
    function addTeamInput() {
        const teamsContainer = document.getElementById('teamsInputs');
        // Count the number of valid team inputs
        let teamIndex = 0;
        for (const child of teamsContainer.children) {
            if (child.classList.contains('teamInput')) {
                teamIndex++;
            }
        }
        const newInput = document.createElement('div');
        newInput.classList.add('mb-2', 'team');
        newInput.innerHTML = `
            <div class="border-b-2 border-gray-300 pb-4">
                <label for="teams" class="block bg-gray-400 text-white font-semibold text-sm py-1 mb-2 px-4 rounded">Ekipa ${teamIndex + 1}</label>
                <div class="teamInput">
                    <label for="teamName" class="block text-gray-700 font-semibold">Ime ekipe:</label>
                    <input type="text" name="teams[${teamIndex}][name]" placeholder="Ime ekipe (neobvezno)"
                        class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3">
                    <label for="firstPlayer" class="block text-gray-700 font-semibold mt-3">Prvi igralec:</label>
                    <select name="teams[${teamIndex}][player_ids][]" class="form-select rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3" required>
                        <option value="">Izberi prvega igralca</option>
                        <!-- Use foreach to generate dropdown options for players -->
                        @foreach ($playersSelect as $player)
                            <option value="{{ $player->id }}">{{ $player->p_name }}</option>
                        @endforeach
                    </select>
                    @error('teams.${teamIndex}.player_ids.0')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <label for="secondPlayer" class="block text-gray-700 font-semibold mt-3">Drugi igralec:</label>
                    <select name="teams[${teamIndex}][player_ids][]" class="form-select rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-1">
                        <option value="">Izberi drugega igralca (neobvezno)</option>
                        <!-- Use foreach to generate dropdown options for players -->
                        @foreach ($playersSelect as $player)
                            <option value="{{ $player->id }}">{{ $player->p_name }}</option>
                        @endforeach
                    </select>
                    @error('teams.${teamIndex}.player_ids.1') {{-- Error for the second player ID --}}
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <button type="button" class="removeTeamBtn ml-2">Odstrani</button>
                </div>
            </div>`;
        teamsContainer.appendChild(newInput);
        // Add event listener to remove button
        newInput.querySelector('.removeTeamBtn').addEventListener('click', function() {
            teamsContainer.removeChild(newInput);
        });
    }

    document.getElementById('addTeamBtn').addEventListener('click', addTeamInput);

    // Ensure that the value of is_group_stage is set to "0" if the checkbox is not checked when the form is submitted
    const form = document.querySelector('form');
    form.addEventListener('submit', function() {
        const isGroupStageCheckbox = document.getElementById('is_group_stage');
        if (!isGroupStageCheckbox.checked) {
            // Create a hidden input field for is_group_stage with value "0"
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'is_group_stage';
            hiddenInput.value = '0';
            form.appendChild(hiddenInput);
        }
    });

    // Function to enable/disable the points description input based on checkbox status
    document.getElementById('is_group_stage').addEventListener('change', function() {
        var pointsDescriptionInput = document.getElementById('points_description');
        var tagInput = document.getElementById('tag');
        pointsDescriptionInput.disabled = this.checked;
        tagInput.disabled = !this.checked;
    });

    // Remove team input field
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('removeTeamBtn')) {
            const team = event.target.closest('.team');
            team.remove();
        }
    });
</script>

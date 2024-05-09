<x-layout :login="$login" :admin="$admin" :message="$message ?? null" :flash="$flash ?? null" :model="$model ?? null">
    <x-admin-title-simple :title="'Liga / Turnir • ' . $league->name" />
    <div class="container mx-auto mt-4">
        <!-- Add new legue form -->
        <div class="bg-zinc-900 text-white py-2 px-4 rounded-t-lg">
            <h2 class="text-xl font-bold">Uredi</h2>
        </div>
        <form action="{{ route('leagues.edit', ['league' => $league->id]) }}" method="POST"
            class="mb-5 bg-gray-100 rounded-lg p-6">
            @method('PUT')
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold">Ime lige ali turnirja:</label>
                <input type="text" name="name" id="name" placeholder="Enter league name"
                    class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                    value="{{ $league->name }}" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-semibold">Opis:</label>
                <textarea name="description" id="description" placeholder="Enter league description"
                    class="form-textarea rounded-lg w-full h-48 focus:outline-none  border-gray-300 py-3 px-4" required>{{ $league->description }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="short_description" class="block text-gray-700 font-semibold">Kratek opis:</label>
                <input type="text" name="short_description" id="short_description"
                    placeholder="Enter short description"
                    class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                    value="{{ $league->short_description }}" required>
                @error('short_description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="start_date" class="block text-gray-700 font-semibold">Start Date:</label>
                <input type="date" name="start_date" id="start_date"
                    class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                    value="{{ $league->start_date }}" required>
                @error('start_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="end_date" class="block text-gray-700 font-semibold">End Date (neobvezno):</label>
                <input type="date" name="end_date" id="end_date"
                    class="form-input rounded-lg w-full focus:outline-none border-gray-300 py-3 px-4"
                    value="{{ $league->end_date }}">
                @error('end_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                class="bg-zinc-500 text-white px-8 py-3 rounded-lg hover:bg-zinc-600 focus:outline-none transition duration-300">Shrani
            </button>
        </form>
    </div>
    <x-title title='Skupine' />

    <div class="bg-gray-200 min-h-screen pt-4">
        <div class="container mx-auto">
            <div class="bg-zinc-900 text-white py-2 px-4 rounded-t-lg">
                <h2 class="text-xl font-bold">Dodaj skupino</h2>
            </div>

            <form action="{{ route('leagues.bracket_store') }}" method="POST" class="mb-5 bg-gray-100 rounded-lg p-6">
                @csrf
                <div class="mb-4">
                    <input type="hidden" name="league_id" value="{{ $league->id }}">
                    <label for="name" class="block text-gray-700 font-semibold">Ime skupine:</label>
                    <input type="text" name="name" id="name" placeholder="Vnesite ime skupine"
                        class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4"
                        value="{{ old('name') }}" required>
                    @error('name')
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

                <div class="mb-4" id="pointsDescriptionContainer">
                    <label for="points_description" class="block text-gray-700 font-semibold">Opis števila
                        točk:</label>
                    <input type="text" name="points_description" id="points_description"
                        placeholder="Vnesite opis števila točk pridobljenih glede na doseženo mesto"
                        class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4"
                        value="{{ old('points_description') }}">
                    @error('points_description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4" id="pointsDescriptionContainer">
                    <label for="tag" class="block text-gray-700 font-semibold">Oznaka skupine:</label>
                    <input type="text" name="tag" id="tag"
                        placeholder="Vpišite oznako skupine (Primer: A)"
                        class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4"
                        value="{{ old('tag') }}" disabled>
                    @error('tag')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4 mb-4" id="teamsContainer">
                    <label for="teams"
                        class="block bg-gray-600 text-white font-semibold py-2 mb-2 px-4 rounded">Ekipe:</label>
                    <div id="teamsInputs">
                        <div class="mb-2 teamInput">
                            <label for="teams"
                                class="block bg-gray-400 text-white font-semibold text-sm py-1 mb-2 px-4 rounded">Ekipa
                                1</label>
                            <div class="border-b-2 border-gray-300 pb-4">
                                <div>
                                    <label for="teamName" class="block text-gray-700 font-semibold">Ime ekipe:</label>
                                    <input type="text" name="teams[0][name]" id="teamName"
                                        placeholder="Ime ekipe (neobvezno)"
                                        class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3">
                                </div>
                                <div>
                                    <label for="firstPlayer" class="block text-gray-700 font-semibold mt-3">Prvi
                                        igralec:</label>
                                    <select name="teams[0][player_ids][]" id="firstPlayer"
                                        class="form-select rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-1"
                                        required>
                                        <option value="">Izberi prvega igralca</option>
                                        <!-- Use foreach to generate dropdown options for players -->
                                        @foreach ($playersSelect as $player)
                                            <option value="{{ $player->id }}">{{ $player->p_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('teams.0.player_ids.0')
                                        {{-- Error for the first player ID --}}
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="secondPlayer" class="block text-gray-700 font-semibold mt-3">Drugi
                                        igralec:</label>
                                    <select name="teams[0][player_ids][]" id="secondPlayer"
                                        class="form-select rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-1">
                                        <option value="">Izberi drugega igralca (neobvezno)</option>
                                        <!-- Use foreach to generate dropdown options for players -->
                                        @foreach ($playersSelect as $player)
                                            <option value="{{ $player->id }}">{{ $player->p_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('teams.0.player_ids.1')
                                        {{-- Error for the second player ID --}}
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
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
                @if ($brackets->isEmpty())
                    <h2 class="p-4 text-gray-900">Nismo našli nobene skupine.</h2>
                @else
                    @foreach ($brackets as $item)
                        <li class="bg-white rounded-lg shadow-md p-6 mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-xl font-bold mb-2">{{ $item->name }}</h3>
                                    <p class="text-gray-700">{{ $item->b_description }}</p>
                                </div>
                                <p class="text-sm font-semibold text-gray-500">{{ $item->teams->where('is_fake', false)->count() }}
                                    igralcev/ekip</p>
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
                                    <a href="{{ route('matchup_setup', $item->id) }}"
                                        class="text-blue-500 hover:underline mr-4">Uredi</a>
                                    <form id="deleteForm{{ $item->id }}"
                                        action="{{ route('league.bracket_destroy', ['bracket' => $item->id]) }}"
                                        method="POST">
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
                    <x-delete-confirmation />
                @endif
            </ul>
            <div class="p-4">{{ $brackets->links() }}</div>
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
</style>

<script>
    // Add team input field
    function addTeamInput() {
        const teamsContainer = document.getElementById('teamsInputs');
        const teamIndex = teamsContainer.children.length; // Get the number of teams
        const newInput = document.createElement('div');
        newInput.classList.add('mb-2', 'teamInput');
        newInput.innerHTML = `<div class="border-b-2 border-gray-300 pb-4">
            <label for="teams" class="block bg-gray-400 text-white font-semibold text-sm py-1 mb-2 px-4 rounded">Ekipa ${teamIndex + 1}</label>
                            <label for="teamName" class="block text-gray-700 font-semibold">Ime ekipe:</label>
                            <input type="text" name="teams[${teamIndex}][name]" placeholder="Ime ekipe (neobvezno)"
                                class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3">
                                <label for="firstPlayer" class="block text-gray-700 font-semibold mt-3">Prvi
                                        igralec:</label>
                            <select name="teams[${teamIndex}][player_ids][]" class="form-select rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4 mt-3" required>
                                <option value="">Izberi prvega igralca</option>
                                <!-- Use foreach to generate dropdown options for players -->
                                @foreach ($playersSelect as $player)
                                    <option value="{{ $player->id }}">{{ $player->p_name }}</option>
                                @endforeach
                            </select>
                            @error('teams.${teamIndex}.player_ids.0') {{-- Error for the first player ID --}}
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <label for="secondPlayer" class="block text-gray-700 font-semibold mt-3">Drugi
                                        igralec:</label>
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

    document.addEventListener('DOMContentLoaded', function() {
        const skupineNameInput = document.getElementById('name'); // Skupine name input

        skupineNameInput.addEventListener('click', function(event) {
            // Stop the propagation of the click event to prevent focusing on the league name input
            event.stopPropagation();
        });
    });
</script>

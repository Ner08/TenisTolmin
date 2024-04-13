<x-layout :login="$login" :admin="$admin">
    <div class="container mx-auto">
        <form action="{{-- {{ route('leagues.store') }} --}}" method="POST" class="mb-5 bg-gray-100 rounded-lg p-6">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold">League Name:</label>
                <input type="text" name="name" id="name" placeholder="Enter league name"
                    class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4"
                    required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-semibold">League Description:</label>
                <textarea name="description" id="description" placeholder="Enter league description"
                    class="form-textarea rounded-lg w-full h-48 focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4"
                    required></textarea>
            </div>
            <div class="mb-4">
                <label for="short_description" class="block text-gray-700 font-semibold">Short Description:</label>
                <input type="text" name="short_description" id="short_description"
                    placeholder="Enter short description"
                    class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4"
                    required>
            </div>
            <div class="mb-4">
                <label for="start_date" class="block text-gray-700 font-semibold">Start Date:</label>
                <input type="date" name="start_date" id="start_date"
                    class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4"
                    required>
            </div>
            <div class="mb-4">
                <label for="end_date" class="block text-gray-700 font-semibold">End Date:</label>
                <input type="date" name="end_date" id="end_date"
                    class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4">
            </div>
            <div class="mb-4" id="bracketsContainer">
                <label for="brackets" class="block text-gray-700 font-semibold mb-2">Brackets:</label>
                <div id="bracketsInputs">
                    <div class="mb-2 bracketInput">
                        <input type="text" name="bracket_names[]" placeholder="Bracket name"
                            class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4">
                        <textarea name="bracket_descriptions[]" placeholder="Bracket description"
                            class="form-textarea rounded-lg w-full h-32 focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4"></textarea>
                        <input type="checkbox" name="is_group_stage[]" id="is_group_stage" class="mr-2">
                        <label for="is_group_stage">Group Stage</label>
                    </div>
                </div>
                <button type="button" id="addBracketBtn"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none">Add
                    Bracket</button>
            </div>
            <div class="mb-4" id="teamsContainer">
                <label for="teams" class="block text-gray-700 font-semibold mb-2">Teams:</label>
                <div id="teamsInputs">
                    <div class="mb-2 teamInput">
                        <input type="text" name="team_names[]" placeholder="Team name"
                            class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4">
                        <select name="player_ids[]"
                            class="form-select rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4"
                            required>
                            <option value="">Select player</option>
                            <!-- Use foreach to generate dropdown options for players -->
                            @foreach ($players as $player)
                                <option value="{{ $player->id }}">{{ $player->name }}</option>
                            @endforeach
                        </select>
                        <select name="player_ids[]"
                            class="form-select rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4"
                            required>
                            <option value="">Select player</option>
                            <!-- Use foreach to generate dropdown options for players -->
                            @foreach ($players as $player)
                                <option value="{{ $player->id }}">{{ $player->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="button" id="addTeamBtn"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none">Add
                    Team</button>
            </div>
            <!-- Other input fields and submit button as before -->
        </form>
    </div>
    <script>
        // Add bracket input field
        document.getElementById('addBracketBtn').addEventListener('click', function() {
            const bracketsContainer = document.getElementById('bracketsInputs');
            const newInput = document.createElement('div');
            newInput.innerHTML = `<div class="mb-2">
                                <input type="text" name="brackets[]" placeholder="Bracket name" class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4">
                            </div>`;
            bracketsContainer.appendChild(newInput);
        });

        // Add team input field
        document.getElementById('addTeamBtn').addEventListener('click', function() {
            const teamsContainer = document.getElementById('teamsInputs');
            const newInput = document.createElement('div');
            newInput.innerHTML = `<div class="mb-2">
                                <input type="text" name="teams[]" placeholder="Team name" class="form-input rounded-lg w-full focus:outline-none focus:border-blue-500 border-gray-300 py-3 px-4">
                            </div>`;
            teamsContainer.appendChild(newInput);
        });
    </script>
</x-layout>

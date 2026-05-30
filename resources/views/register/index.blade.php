<x-layout-login>
    @title('Registracija - Tenis Tolmin')

    <div class="min-h-[calc(100vh-56px)] flex items-center justify-center bg-gray-950 px-4 py-8">
        <div class="w-full max-w-sm">
            <div class="text-center mb-6">
                <img class="mx-auto h-10 w-auto mb-3" src="{{ asset('images/logo10.png') }}" alt="logo">
                <h2 class="text-xl font-bold text-white">Registracija</h2>
                <p class="text-gray-500 text-xs mt-1">Teniški klub Tolmin</p>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl p-5">
                <form class="space-y-3" action="{{ route('register.store') }}" method="POST">
                    @csrf

                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1">Ime in priimek</label>
                        <input name="name" type="text" required value="{{ old('name') }}"
                            class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-lg text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-colors"
                            placeholder="Janez Novak">
                        @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1">E-mail</label>
                        <input name="email" type="email" required value="{{ old('email') }}"
                            class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-lg text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-colors"
                            placeholder="ime@primer.si">
                        @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1">Geslo</label>
                            <input name="password" type="password" required
                                class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-lg text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-colors"
                                placeholder="Vsaj 8 znakov">
                            @error('password') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1">Potrdi geslo</label>
                            <input name="password_confirmation" type="password" required
                                class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-lg text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-colors"
                                placeholder="••••••••">
                        </div>
                    </div>

                    {{-- Player profile --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1.5">Igralski profil</label>

                        <input type="hidden" name="player_choice" id="player_choice" value="{{ old('player_choice', 'none') }}">
                        <input type="hidden" name="player_id" id="player_id_input" value="{{ old('player_id') }}">

                        {{-- Compact 3-way toggle --}}
                        <div class="flex rounded-lg overflow-hidden border border-gray-700 text-xs font-semibold">
                            <button type="button" onclick="setPlayerChoice('existing')" id="opt_existing"
                                class="player-opt flex-1 py-2 text-center transition-colors duration-150 text-gray-400 hover:text-white">
                                Sem na seznamu
                            </button>
                            <button type="button" onclick="setPlayerChoice('new')" id="opt_new"
                                class="player-opt flex-1 py-2 text-center border-x border-gray-700 transition-colors duration-150 text-gray-400 hover:text-white">
                                Ustvari profil
                            </button>
                            <button type="button" onclick="setPlayerChoice('none')" id="opt_none"
                                class="player-opt flex-1 py-2 text-center transition-colors duration-150 text-gray-400 hover:text-white">
                                Preskoči
                            </button>
                        </div>

                        {{-- Searchable list (shown when 'existing') --}}
                        <div id="player_search_wrap" class="hidden mt-2">
                            <input type="text" id="player_search"
                                placeholder="Išči po imenu..."
                                oninput="filterPlayers()"
                                class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-t-lg text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-colors">
                            <div id="player_list"
                                class="max-h-32 overflow-y-auto border border-t-0 border-gray-700 rounded-b-lg bg-gray-800 divide-y divide-gray-700/50">
                                @foreach ($players as $player)
                                    <button type="button"
                                        data-id="{{ $player->id }}"
                                        data-name="{{ $player->p_name }}"
                                        onclick="selectPlayer({{ $player->id }}, '{{ addslashes($player->p_name) }}')"
                                        class="player-item w-full text-left px-3 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                                        {{ $player->p_name }}
                                    </button>
                                @endforeach
                            </div>
                            <p id="player_selected_name" class="hidden text-xs text-amber-400 mt-1 px-0.5">
                                Izbran: <span id="player_selected_label"></span>
                                <button type="button" onclick="clearPlayer()" class="ml-1.5 text-gray-500 hover:text-white">✕</button>
                            </p>
                        </div>

                        {{-- 'new' hint --}}
                        <p id="new_profile_hint" class="hidden text-xs text-gray-500 mt-1.5">
                            Profil bo ustvarjen z vašim imenom ob registraciji.
                        </p>

                        @error('player_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Comment --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1">
                            Sporočilo adminu <span class="text-gray-600">(neobvezno)</span>
                        </label>
                        <textarea name="registration_comment" rows="2"
                            class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-lg text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-colors resize-none"
                            placeholder="Kratko sporočilo za administratorja...">{{ old('registration_comment') }}</textarea>
                    </div>

                    <div class="flex items-start gap-2 bg-gray-800/60 border border-gray-700 rounded-lg px-3 py-2.5 text-xs text-gray-400">
                        <svg class="w-3.5 h-3.5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Registracijo bo pregledal in odobril administrator kluba. Po odobritvi boste prejeli e-mail.</span>
                    </div>

                    <button type="submit"
                        class="w-full py-2.5 px-4 bg-amber-500 hover:bg-amber-400 text-gray-900 text-sm font-semibold rounded-lg transition-colors duration-150">
                        Registracija
                    </button>
                </form>

                <p class="text-center text-xs text-gray-500 mt-4">
                    Že imate račun?
                    <a href="{{ route('login_view') }}" class="text-amber-400 hover:text-amber-300 font-medium">Prijavite se</a>
                </p>
            </div>
        </div>
    </div>

<script>
    function setPlayerChoice(choice) {
        document.getElementById('player_choice').value = choice;

        ['existing','new','none'].forEach(function(o) {
            var el = document.getElementById('opt_' + o);
            if (o === choice) {
                el.classList.add('bg-amber-500','text-gray-900');
                el.classList.remove('text-gray-400');
            } else {
                el.classList.remove('bg-amber-500','text-gray-900');
                el.classList.add('text-gray-400');
            }
        });

        document.getElementById('player_search_wrap').classList.toggle('hidden', choice !== 'existing');
        document.getElementById('new_profile_hint').classList.toggle('hidden', choice !== 'new');

        if (choice !== 'existing') clearPlayer();
    }

    function selectPlayer(id, name) {
        document.getElementById('player_id_input').value = id;
        document.getElementById('player_selected_label').textContent = name;
        document.getElementById('player_selected_name').classList.remove('hidden');
        document.getElementById('player_search').value = name;
        filterPlayers();
    }

    function clearPlayer() {
        document.getElementById('player_id_input').value = '';
        document.getElementById('player_selected_name').classList.add('hidden');
        var s = document.getElementById('player_search');
        if (s) { s.value = ''; filterPlayers(); }
    }

    function filterPlayers() {
        var q = document.getElementById('player_search').value.toLowerCase();
        document.querySelectorAll('.player-item').forEach(function(el) {
            el.style.display = el.dataset.name.toLowerCase().includes(q) ? '' : 'none';
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        setPlayerChoice('{{ old('player_choice', 'none') }}');
    });
</script>

</x-layout-login>

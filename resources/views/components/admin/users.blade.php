<div class="container mx-auto pt-4 px-4 pb-6" id="admin_uporabniki" style="display: none">

    {{-- Create user --}}
    <div class="mb-6">
        <div class="bg-gray-900 text-white px-5 py-3 rounded-t-xl">
            <h2 class="text-sm font-semibold">Ustvari uporabnika</h2>
        </div>
        <form action="{{ route('admin.users.create') }}" method="POST"
              class="bg-white border border-gray-200 border-t-0 rounded-b-xl p-5">
            @csrf
            <div class="flex flex-wrap gap-4 items-end">
                <div class="flex flex-col flex-1 min-w-[160px]">
                    <label class="text-xs font-semibold text-gray-700 mb-1.5">Ime</label>
                    <input type="text" name="name" placeholder="Ime in priimek"
                        class="border border-gray-200 rounded-lg py-2.5 px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"
                        value="{{ old('name') }}" required>
                </div>
                <div class="flex flex-col flex-1 min-w-[160px]">
                    <label class="text-xs font-semibold text-gray-700 mb-1.5">E-mail</label>
                    <input type="email" name="email" placeholder="E-mail"
                        class="border border-gray-200 rounded-lg py-2.5 px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"
                        value="{{ old('email') }}" required>
                </div>
                <div class="flex flex-col w-36">
                    <label class="text-xs font-semibold text-gray-700 mb-1.5">Geslo</label>
                    <input type="password" name="password" placeholder="Geslo"
                        class="border border-gray-200 rounded-lg py-2.5 px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"
                        required>
                </div>
                <div class="flex flex-col flex-1 min-w-[160px]">
                    <label class="text-xs font-semibold text-gray-700 mb-1.5">Igralec (neobvezno)</label>
                    <select name="player_id"
                        class="border border-gray-200 rounded-lg py-2.5 px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <option value="">— Brez —</option>
                        @foreach ($unlinkedPlayers as $player)
                            <option value="{{ $player->id }}">{{ $player->p_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="pb-0.5">
                    <button type="submit"
                        class="bg-gray-900 text-white text-sm px-5 py-2.5 rounded-lg hover:bg-gray-700 transition-colors whitespace-nowrap">
                        Ustvari
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Pending registrations --}}
    @if ($pendingUsers->isNotEmpty())
        <div class="mb-6">
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-3">
                Čakajoče registracije ({{ $pendingUsers->count() }})
            </h3>
            <ul class="space-y-3">
                @foreach ($pendingUsers as $user)
                    <li class="bg-white border border-amber-200 rounded-xl overflow-hidden">
                        <div class="flex items-center justify-between px-4 py-3 flex-wrap gap-3">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    Igralec: {{ $user->player?->p_name ?? '—' }}
                                    · {{ $user->created_at->format('d. m. Y H:i') }}
                                </p>
                                @if ($user->registration_comment)
                                    <p class="text-xs text-gray-500 italic mt-1 bg-gray-50 rounded px-2 py-1">
                                        "{{ $user->registration_comment }}"
                                    </p>
                                @endif
                            </div>
                            <div class="flex items-center gap-2">
                                <form action="{{ route('admin.users.approve', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="text-xs font-medium text-green-700 bg-green-50 border border-green-200 px-3 py-1.5 rounded-lg hover:bg-green-100 transition-colors">
                                        Odobri
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.reject', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="text-xs font-medium text-red-600 bg-white border border-red-200 px-3 py-1.5 rounded-lg hover:bg-red-50 transition-colors">
                                        Zavrni
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Disputed match results --}}
    @if ($disputedMatchups->isNotEmpty())
        <div class="mb-6">
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-3">
                Sporni rezultati ({{ $disputedMatchups->count() }})
            </h3>
            <ul class="space-y-3">
                @foreach ($disputedMatchups as $matchup)
                    @php
                        $t1 = App\Models\Team::find($matchup->team1_id);
                        $t2 = App\Models\Team::find($matchup->team2_id);
                    @endphp
                    <li class="bg-white border border-red-200 rounded-xl overflow-hidden">
                        <div class="flex items-center justify-between px-4 py-3 flex-wrap gap-3">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $t1?->playerNames() ?? '?' }} vs {{ $t2?->playerNames() ?? '?' }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    Rezultat: {{ $matchup->endResult }}
                                    · Oddal: {{ $matchup->submittedByUser?->name ?? '—' }}
                                </p>
                                <span class="text-xs font-medium text-red-600">
                                    {{ $matchup->result_status === 'admin_review' ? 'Čaka na admin odločitev' : 'Sporno' }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <form action="{{ route('matchups.admin.confirm', $matchup->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="text-xs font-medium text-green-700 bg-green-50 border border-green-200 px-3 py-1.5 rounded-lg hover:bg-green-100 transition-colors">
                                        Potrdi
                                    </button>
                                </form>
                                <form action="{{ route('matchups.admin.clear', $matchup->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="text-xs font-medium text-red-600 bg-white border border-red-200 px-3 py-1.5 rounded-lg hover:bg-red-50 transition-colors">
                                        Ponastavi
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- All approved users --}}
    <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-3">Vsi uporabniki</h3>
    <ul class="grid grid-cols-1 lg:grid-cols-2 gap-3">
        @forelse ($allUsers as $user)
            <li class="bg-white border border-gray-200 rounded-xl px-4 py-3 flex items-center justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                        {{ $user->name }}
                        @if ($user->is_super_admin)
                            <span class="text-xs font-medium text-purple-600 bg-purple-50 border border-purple-200 px-1.5 py-0.5 rounded">Super admin</span>
                        @elseif ($user->is_admin)
                            <span class="text-xs font-medium text-amber-600 bg-amber-50 border border-amber-200 px-1.5 py-0.5 rounded">Admin</span>
                        @endif
                    </p>
                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Igralec: {{ $user->player?->p_name ?? '—' }}</p>
                </div>
                <div class="flex flex-col items-end gap-2 flex-shrink-0">
                    {{-- Link player --}}
                    <form action="{{ route('admin.users.link-player', $user->id) }}" method="POST" class="flex gap-1.5 items-center">
                        @csrf
                        <select name="player_id" class="border border-gray-200 rounded-lg py-1.5 px-2.5 text-xs w-40 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="">— Brez igralca —</option>
                            @if ($user->player)
                                <option value="{{ $user->player->id }}" selected>{{ $user->player->p_name }}</option>
                            @endif
                            @foreach ($unlinkedPlayers as $player)
                                <option value="{{ $player->id }}">{{ $player->p_name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="text-xs font-medium text-gray-700 bg-gray-100 border border-gray-200 px-2.5 py-1.5 rounded-lg hover:bg-gray-200 transition-colors whitespace-nowrap">
                            Poveži
                        </button>
                    </form>
                    {{-- Set temporary password --}}
                    <form action="{{ route('admin.users.set-password', $user->id) }}" method="POST"
                          class="flex gap-1.5 items-center" id="setPassForm{{ $user->id }}">
                        @csrf
                        <input type="password" name="password" placeholder="Začasno geslo" required minlength="8"
                            class="border border-gray-200 rounded-lg py-1.5 px-2.5 text-xs w-36 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <button type="submit"
                            class="text-xs font-medium text-gray-700 bg-gray-100 border border-gray-200 px-2.5 py-1.5 rounded-lg hover:bg-gray-200 transition-colors whitespace-nowrap">
                            Nastavi geslo
                        </button>
                    </form>

                    @if (auth()->user()->is_super_admin && !$user->is_super_admin && $user->id !== auth()->id())
                        @if ($user->is_admin)
                            <form id="removeAdminForm{{ $user->id }}" method="POST" action="{{ route('admin.users.remove-admin', $user->id) }}">
                                @csrf
                                <button type="button"
                                    onclick="showConfirmAction('removeAdminForm', {{ $user->id }}, 'Odstrani admin pravice', 'Uporabnik {{ addslashes($user->name) }} ne bo več imel dostopa do admin plošče.', 'Odstrani', 'red')"
                                    class="text-xs font-medium text-red-600 bg-white border border-red-200 px-3 py-1.5 rounded-lg hover:bg-red-50 transition-colors">
                                    Odstrani admina
                                </button>
                            </form>
                        @else
                            <form id="makeAdminForm{{ $user->id }}" method="POST" action="{{ route('admin.users.make-admin', $user->id) }}">
                                @csrf
                                <button type="button"
                                    onclick="showConfirmAction('makeAdminForm', {{ $user->id }}, 'Dodeli admin pravice', 'Uporabnik {{ addslashes($user->name) }} bo dobil popoln dostop do upravljanja strani.', 'Naredi admina', 'amber')"
                                    class="text-xs font-medium text-amber-700 bg-amber-50 border border-amber-200 px-3 py-1.5 rounded-lg hover:bg-amber-100 transition-colors">
                                    Naredi admina
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </li>
        @empty
            <p class="text-sm text-gray-500 col-span-2 py-4">Ni odobrenih uporabnikov.</p>
        @endforelse
    </ul>
    <div class="mt-3">{{ $allUsers->links('pagination::tailwind') }}</div>

</div>

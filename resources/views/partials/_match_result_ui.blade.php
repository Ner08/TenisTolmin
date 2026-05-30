@auth
    @if (auth()->user()->isApproved() && auth()->user()->player_id)
        @php
            $authPlayerId = auth()->user()->player_id;
            $userInTeam1 = in_array($authPlayerId, array_filter([$t1p1?->id ?? null, $t1p2?->id ?? null]));
            $userInTeam2 = in_array($authPlayerId, array_filter([$t2p1?->id ?? null, $t2p2?->id ?? null]));
            $userInMatch = $userInTeam1 || $userInTeam2;
            $userIsSubmitter = auth()->id() === $match->submitted_by_user_id;
            $userIsOpponent = $userInMatch && !$userIsSubmitter;
        @endphp

        @if ($match->result_status === 'none' && !$match->game_played() && $userInMatch)
            {{-- Show submit button --}}
            <div class="border-t border-gray-100 group relative">
                <button onclick="document.getElementById('rf_{{ $match->id }}').classList.toggle('hidden'); this.parentElement.querySelector('button').classList.toggle('hidden');"
                    class="w-full px-4 py-2 text-xs font-semibold text-amber-700 hover:bg-amber-50 transition-colors text-left">
                    + Vnesi rezultat
                </button>
                <div class="absolute bottom-full left-4 mb-2 hidden group-hover:block bg-gray-900 text-white text-xs px-2 py-1 rounded whitespace-nowrap z-10">
                    Oddajte rezultat tekme
                </div>
                <div id="rf_{{ $match->id }}" class="hidden px-4 pb-3 pt-2 bg-amber-50 border-t border-amber-100">
                    <p class="text-xs font-semibold text-gray-700 mb-3">{{ $t1_name }} — {{ $t2_name }}</p>
                    <form id="form_{{ $match->id }}" class="space-y-3">
                        @csrf
                        <div class="space-y-2">
                            @foreach ([['1. set', 't1_first_set', 't2_first_set'], ['2. set', 't1_second_set', 't2_second_set'], ['3. set', 't1_third_set', 't2_third_set']] as [$label, $f1, $f2])
                                <div class="flex items-center gap-3">
                                    <span class="text-xs font-medium text-gray-600 w-12">{{ $label }}</span>
                                    <div class="flex items-center gap-2 flex-1">
                                        <input type="number" name="{{ $f1 }}" min="0" max="99"
                                            placeholder="0"
                                            {{ $label === '3. set' ? '' : 'required' }}
                                            class="flex-1 max-w-16 border border-amber-200 bg-white rounded px-2 py-2 text-sm font-semibold text-center focus:outline-none focus:ring-2 focus:ring-amber-400">
                                        <span class="text-gray-500 font-bold">:</span>
                                        <input type="number" name="{{ $f2 }}" min="0" max="99"
                                            placeholder="0"
                                            {{ $label === '3. set' ? '' : 'required' }}
                                            class="flex-1 max-w-16 border border-amber-200 bg-white rounded px-2 py-2 text-sm font-semibold text-center focus:outline-none focus:ring-2 focus:ring-amber-400">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex gap-2 pt-2">
                            <button type="button" onclick="submitScoreForm({{ $match->id }})"
                                class="flex-1 text-sm bg-amber-600 text-white px-4 py-2 rounded font-semibold hover:bg-amber-700 transition-colors">
                                Oddaj
                            </button>
                            <button type="button"
                                onclick="document.getElementById('rf_{{ $match->id }}').classList.add('hidden'); this.closest('.border-t').previousElementSibling.classList.remove('hidden');"
                                class="text-sm text-gray-500 hover:text-gray-700 px-3 py-2">
                                Prekliči
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        @elseif ($match->result_status === 'pending' && $userIsOpponent)
            {{-- Opponent: approve or dispute --}}
            <div class="flex gap-2 px-3 py-2 bg-blue-50 border-t border-blue-100">
                <form method="POST" action="{{ route('matchups.result.confirm', $match->id) }}" class="relative group">
                    @csrf
                    <button type="submit"
                        class="text-xs font-semibold text-green-700 bg-white border border-green-200 px-3 py-1.5 rounded hover:bg-green-50 transition-colors">
                        Potrdi
                    </button>
                    <div class="absolute bottom-full left-0 mb-2 hidden group-hover:block bg-gray-900 text-white text-xs px-2 py-1 rounded whitespace-nowrap z-10">
                        Potrdi rezultat
                    </div>
                </form>
                <form method="POST" action="{{ route('matchups.result.dispute', $match->id) }}" class="relative group">
                    @csrf
                    <button type="submit"
                        class="text-xs font-semibold text-red-600 bg-white border border-red-200 px-3 py-1.5 rounded hover:bg-red-50 transition-colors">
                        Sporno
                    </button>
                    <div class="absolute bottom-full left-0 mb-2 hidden group-hover:block bg-gray-900 text-white text-xs px-2 py-1 rounded whitespace-nowrap z-10">
                        Označi kot sporno
                    </div>
                </form>
            </div>

        @elseif ($match->result_status === 'pending' && $userIsSubmitter)
            {{-- Mobile --}}
            <div class="sm:hidden px-4 py-1.5 bg-gray-50 border-t border-gray-100 flex items-center gap-1.5 text-xs text-gray-400">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 2m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Čakanje na potrditev
            </div>
            {{-- Desktop --}}
            <div class="hidden sm:block absolute bottom-1 right-5" title="Čakanje na potrditev">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 2m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

        @elseif ($match->result_status === 'pending')
            {{-- Mobile --}}
            <div class="sm:hidden px-4 py-1.5 bg-gray-50 border-t border-gray-100 flex items-center gap-1.5 text-xs text-gray-400">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 2m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                V obravnavi
            </div>
            {{-- Desktop --}}
            <div class="hidden sm:block absolute bottom-1 right-3" title="V obravnavi">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 2m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

        @elseif (in_array($match->result_status, ['disputed', 'admin_review']))
            {{-- Mobile --}}
            <div class="sm:hidden px-4 py-1.5 bg-red-50 border-t border-red-100 flex items-center gap-1.5 text-xs text-red-500">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2L2 20h20L12 2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4"/><circle cx="12" cy="17" r="0.5" fill="currentColor"/></svg>
                Sporno — čaka odločitev
            </div>
            {{-- Desktop --}}
            <div class="hidden sm:block absolute bottom-1 right-5" title="Sporno — čaka odločitev">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 2L2 20h20L12 2z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4"/>
                    <circle cx="12" cy="17" r="0.5" fill="currentColor"/>
                </svg>
            </div>

        @endif
    @endif

    {{-- Admin score entry (always visible to admins) --}}
    @if (auth()->check() && auth()->user()->is_admin)
        <div class="border-t border-gray-100">
            <button onclick="document.getElementById('admin_rf_{{ $match->id }}').classList.toggle('hidden'); this.classList.toggle('hidden');"
                class="w-full px-4 py-1.5 text-xs font-semibold text-gray-400 hover:bg-gray-50 hover:text-gray-600 transition-colors text-left">
                ✎ Admin: vnesi rezultat
            </button>
            <div id="admin_rf_{{ $match->id }}" class="hidden px-4 pb-3 pt-2 bg-gray-50 border-t border-gray-100">
                <form id="admin_form_{{ $match->id }}" class="space-y-2">
                    @csrf
                    <div class="space-y-1.5">
                        @foreach ([['1. set', 't1_first_set', 't2_first_set'], ['2. set', 't1_second_set', 't2_second_set'], ['3. set', 't1_third_set', 't2_third_set']] as [$label, $f1, $f2])
                            <div class="flex items-center gap-3">
                                <span class="text-xs text-gray-500 w-12">{{ $label }}</span>
                                <input type="number" name="{{ $f1 }}" min="0" max="99" placeholder="0"
                                    value="{{ $match->$f1 }}"
                                    {{ $label === '3. set' ? '' : 'required' }}
                                    class="w-14 border border-gray-200 bg-white rounded px-2 py-1.5 text-sm font-semibold text-center focus:outline-none focus:ring-2 focus:ring-gray-400">
                                <span class="text-gray-400 font-bold">:</span>
                                <input type="number" name="{{ $f2 }}" min="0" max="99" placeholder="0"
                                    value="{{ $match->$f2 }}"
                                    {{ $label === '3. set' ? '' : 'required' }}
                                    class="w-14 border border-gray-200 bg-white rounded px-2 py-1.5 text-sm font-semibold text-center focus:outline-none focus:ring-2 focus:ring-gray-400">
                            </div>
                        @endforeach
                    </div>
                    <div class="flex gap-2 pt-1">
                        <button type="button" onclick="submitAdminScoreForm({{ $match->id }})"
                            class="text-xs bg-gray-800 text-white px-3 py-1.5 rounded font-semibold hover:bg-gray-600 transition-colors">
                            Shrani
                        </button>
                        <button type="button"
                            onclick="document.getElementById('admin_rf_{{ $match->id }}').classList.add('hidden'); this.closest('.border-t').previousElementSibling.classList.remove('hidden');"
                            class="text-xs text-gray-400 hover:text-gray-600 px-2">
                            Prekliči
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endauth

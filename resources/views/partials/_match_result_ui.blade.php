@auth
    @if (auth()->user()->isApproved() && auth()->user()->player_id)
        @php
            $authPlayerId  = auth()->user()->player_id;
            $userInTeam1   = in_array($authPlayerId, array_filter([$t1p1?->id ?? null, $t1p2?->id ?? null]));
            $userInTeam2   = in_array($authPlayerId, array_filter([$t2p1?->id ?? null, $t2p2?->id ?? null]));
            $userInMatch   = $userInTeam1 || $userInTeam2;
            $userIsSubmitter = auth()->id() === $match->submitted_by_user_id;
            $userIsOpponent  = $userInMatch && !$userIsSubmitter;
        @endphp

        @if ($match->result_status === 'none' && !$match->game_played() && $userInMatch)
            <div class="border-t border-gray-100">
                <button type="button"
                    onclick="openScoreDialog({{ $match->id }}, @js($t1_name), @js($t2_name), false, null)"
                    class="w-full px-4 py-2 text-xs font-semibold text-amber-700 hover:bg-amber-50 transition-colors text-left">
                    + Vnesi rezultat
                </button>
            </div>

        @elseif ($match->result_status === 'pending' && $userIsOpponent)
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
            <div class="px-4 py-1.5 bg-gray-50 border-t border-gray-100 flex items-center gap-1.5 text-xs text-gray-400">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 2m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Čakanje na potrditev
            </div>

        @elseif ($match->result_status === 'pending')
            <div class="px-4 py-1.5 bg-gray-50 border-t border-gray-100 flex items-center gap-1.5 text-xs text-gray-400">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 2m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                V obravnavi
            </div>

        @elseif (in_array($match->result_status, ['disputed', 'admin_review']))
            <div class="px-4 py-1.5 bg-red-50 border-t border-red-100 flex items-center gap-1.5 text-xs text-red-500">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 2L2 20h20L12 2z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4"/>
                    <circle cx="12" cy="17" r="0.5" fill="currentColor"/>
                </svg>
                Sporno — čaka odločitev
            </div>

        @endif
    @endif

    @if (auth()->check() && auth()->user()->is_admin)
        @php
            $prefill = json_encode([
                't1s1' => $match->t1_first_set,  't2s1' => $match->t2_first_set,
                't1s2' => $match->t1_second_set, 't2s2' => $match->t2_second_set,
                't1s3' => $match->t1_third_set,  't2s3' => $match->t2_third_set,
            ]);
        @endphp
        <div class="border-t border-gray-100">
            <button type="button"
                onclick="openScoreDialog({{ $match->id }}, @js($t1_name), @js($t2_name), true, {{ $prefill }})"
                class="w-full px-4 py-1.5 text-xs font-semibold text-gray-400 hover:bg-gray-50 hover:text-gray-600 transition-colors text-left">
                ✎ Vnesi rezultat
            </button>
        </div>
    @endif
@endauth

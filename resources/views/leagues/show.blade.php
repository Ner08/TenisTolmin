<x-layout>
    @php
        $titleTab    = 'Liga ali turnir - ' . $league->name . ' - Tenis Tolmin';
        $hasBrackets = $brackets->isNotEmpty();
        $hasGroups   = $brackets_group->isNotEmpty();
        $firstTab    = $hasBrackets ? 'b_0' : ($hasGroups ? 'g_0' : 'none');
    @endphp

    @title($titleTab)
    <style>body { background-color: #f9fafb; }</style>

    {{-- Title bar (fixed) --}}
    @if ($isMobile)
        <x-sm-league-title :data="['name' => $league->name, 'start_date' => $league->start_date, 'end_date' => $league->end_date]" />
    @else
        <x-league-title :data="['name' => $league->name, 'start_date' => $league->start_date, 'end_date' => $league->end_date]" />
    @endif
    {{-- Spacer for fixed title bar — height set dynamically by positionTabBar() --}}
    <div id="league-title-spacer" style="height:2.5rem"></div>

    @if ($hasBrackets || $hasGroups)

        {{-- Fixed tab navigation --}}
        <div id="league-tab-bar" class="fixed left-0 right-0 z-30 bg-gray-900 border-b border-gray-800" style="top:6rem">
            <div class="max-w-screen-2xl mx-auto flex items-stretch">

            {{-- MOBILE: custom dropdown + toggle (single row) --}}
            <div class="flex sm:hidden flex-1 items-center gap-2 px-3 py-2">

                {{-- Dropdown trigger --}}
                <div class="relative flex-1 min-w-0">
                    <button onclick="toggleMobileTabDropdown()" id="mobile-tab-btn"
                        class="w-full flex items-center justify-between bg-gray-800 hover:bg-gray-700 rounded-lg px-3 py-2 text-sm font-semibold text-white transition-colors">
                        <span id="mobile-tab-label" class="truncate mr-2">Izberite skupino</span>
                        <svg id="mobile-tab-chevron" class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform duration-150" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    {{-- Dropdown list --}}
                    <div id="mobile-tab-dropdown" class="hidden absolute left-0 right-0 top-full mt-1 bg-gray-800 border border-gray-700 rounded-xl shadow-2xl z-50 overflow-hidden">
                        @if ($hasBrackets)
                            <p class="text-xs font-bold uppercase tracking-widest text-gray-500 px-4 pt-3 pb-1">Izločitveni</p>
                            @foreach ($brackets as $i => $bracket)
                                <button onclick="selectMobileTab('b_{{ $i }}', '{{ addslashes($bracket->name) }}')"
                                    class="mobile-tab-opt w-full text-left px-4 py-2.5 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors" data-id="b_{{ $i }}">
                                    {{ $bracket->name }}
                                </button>
                            @endforeach
                        @endif
                        @if ($hasGroups)
                            <p class="text-xs font-bold uppercase tracking-widest text-gray-500 px-4 pt-3 pb-1 {{ $hasBrackets ? 'border-t border-gray-700 mt-1' : '' }}">Skupinski</p>
                            @foreach ($brackets_group as $i => $group)
                                <button onclick="selectMobileTab('g_{{ $i }}', '{{ addslashes($group->name) }}')"
                                    class="mobile-tab-opt w-full text-left px-4 py-2.5 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors" data-id="g_{{ $i }}">
                                    {{ $group->name }}
                                </button>
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- View toggle — right side --}}
                <div class="flex items-center bg-gray-800 rounded-lg p-0.5 gap-0.5 flex-shrink-0">
                    <button id="vtab_content_m" onclick="showSubTabAll('content')"
                        class="px-2.5 py-1.5 text-xs font-semibold rounded-md transition-colors duration-150 bg-gray-700 text-white">
                        Rezultati
                    </button>
                    <button id="vtab_chat_m" onclick="showSubTabAll('chat')"
                        class="px-2.5 py-1.5 text-xs font-semibold rounded-md transition-colors duration-150 text-gray-400 hover:text-white">
                        Klepet
                    </button>
                </div>
            </div>

            {{-- DESKTOP: scrollable tab buttons --}}
            <div class="hidden sm:flex flex-1 min-w-0 items-center overflow-x-auto px-4 py-2 gap-1" style="scrollbar-width:none;-ms-overflow-style:none;">

                @if ($hasBrackets)
                    <span class="text-xs font-bold uppercase tracking-widest text-gray-600 px-2 flex-shrink-0 select-none">Izločitveni</span>
                    @foreach ($brackets as $i => $bracket)
                        <button onclick="showLeagueTab('b_{{ $i }}')" id="tab_b_{{ $i }}"
                            class="league-tab px-4 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap transition-colors duration-150 flex-shrink-0 text-gray-400 hover:text-white hover:bg-gray-800">
                            {{ $bracket->name }}
                        </button>
                    @endforeach
                @endif

                @if ($hasBrackets && $hasGroups)
                    <div class="w-px bg-gray-700 mx-2 self-stretch flex-shrink-0"></div>
                @endif

                @if ($hasGroups)
                    <span class="text-xs font-bold uppercase tracking-widest text-gray-600 px-2 flex-shrink-0 select-none">Skupinski</span>
                    @foreach ($brackets_group as $i => $group)
                        @php $groupPlayers = $group->teams->where('is_fake', false); @endphp
                        <div class="relative flex-shrink-0 group/tip">
                            <button onclick="showLeagueTab('g_{{ $i }}')" id="tab_g_{{ $i }}"
                                class="league-tab px-4 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap transition-colors duration-150 text-gray-400 hover:text-white hover:bg-gray-800">
                                {{ $group->name }}
                            </button>
                            @if ($groupPlayers->isNotEmpty())
                                <div class="absolute top-full left-0 mt-2 z-50 bg-white border border-gray-200 rounded-xl shadow-xl p-3 min-w-max hidden group-hover/tip:block">
                                    <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">{{ $group->name }}</p>
                                    @foreach ($groupPlayers as $team)
                                        <div class="flex items-center gap-2 py-1">
                                            <div class="w-1.5 h-1.5 rounded-full bg-amber-500 flex-shrink-0"></div>
                                            <span class="text-sm text-gray-800 font-medium">
                                                {{ $team->player1->p_name }}
                                                @if ($team->player2) & {{ $team->player2->p_name }} @endif
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif

            </div>

            {{-- DESKTOP: view toggle --}}
            <div class="hidden sm:flex flex-shrink-0 items-center px-3 border-l border-gray-800">
                <div class="flex items-center bg-gray-800 rounded-lg p-0.5 gap-0.5">
                    <button id="vtab_content" onclick="showSubTabAll('content')"
                        class="px-3 py-1.5 text-xs font-semibold rounded-md transition-colors duration-150 bg-gray-700 text-white">
                        Rezultati
                    </button>
                    <button id="vtab_chat" onclick="showSubTabAll('chat')"
                        class="px-3 py-1.5 text-xs font-semibold rounded-md transition-colors duration-150 text-gray-400 hover:text-white">
                        Klepet
                    </button>
                </div>
            </div>

            </div>
        </div>

        {{-- Spacer sized dynamically to match fixed tab bar height --}}
        <div id="league-tab-spacer" class="h-11"></div>

        <div>

        {{-- Bracket stage panels --}}
        @foreach ($brackets as $i => $bracket)
            <div id="panel_b_{{ $i }}" class="league-panel" style="display:none">
                @include('partials._panel_with_chat', [
                    'panelId'  => 'b_' . $i,
                    'bracket'  => $bracket,
                    'isMobile' => $isMobile,
                    'type'     => 'bracket',
                ])
            </div>
        @endforeach

        {{-- Group stage panels --}}
        @foreach ($brackets_group as $i => $group)
            <div id="panel_g_{{ $i }}" class="league-panel" style="display:none">
                @include('partials._panel_with_chat', [
                    'panelId'  => 'g_' . $i,
                    'bracket'  => $group,
                    'isMobile' => $isMobile,
                    'type'     => 'group',
                ])
            </div>
        @endforeach

        </div>

    @else
        <div class="m-6">
            <div class="bg-amber-50 border border-amber-200 text-amber-800 text-sm font-medium px-5 py-4 rounded-xl inline-block">
                Liga še ni nastavljena — preverite kmalu. 🎾
            </div>
        </div>
    @endif

</x-layout>

<script>
    var currentLeagueTab = null;
    var currentSubTab = 'content';
    var currentPanelH = 'auto';

    function showLeagueTab(id) {
        document.querySelectorAll('.league-panel').forEach(function (p) { p.style.display = 'none'; });
        document.querySelectorAll('.league-tab').forEach(function (b) {
            b.classList.remove('bg-amber-500', 'text-gray-900');
            b.classList.add('text-gray-400');
        });
        var panel = document.getElementById('panel_' + id);
        var tab   = document.getElementById('tab_' + id);
        if (panel) {
            panel.style.display = 'block';
            // Set subpanel heights explicitly — don't rely on h-full CSS inheritance
            var sc = document.getElementById('subpanel_content_' + id);
            var sh = document.getElementById('subpanel_chat_' + id);
            if (sc) sc.style.height = currentPanelH;
            if (sh) sh.style.height = currentPanelH;
        }
        if (tab) { tab.classList.add('bg-amber-500', 'text-gray-900'); tab.classList.remove('text-gray-400'); }
        currentLeagueTab = id;
        showSubTabAll('content');
    }

    function showSubTabAll(sub) {
        currentSubTab = sub;
        if (currentLeagueTab) {
            var c = document.getElementById('subpanel_content_' + currentLeagueTab);
            var h = document.getElementById('subpanel_chat_'    + currentLeagueTab);
            if (c) c.style.display = sub === 'content' ? '' : 'none';
            if (h) h.style.display = sub === 'chat'    ? '' : 'none';
        }
        ['content', 'chat'].forEach(function (s) {
            ['vtab_' + s, 'vtab_' + s + '_m'].forEach(function(btnId) {
                var btn = document.getElementById(btnId);
                if (!btn) return;
                if (s === sub) {
                    btn.classList.add('bg-gray-700', 'text-white');
                    btn.classList.remove('text-gray-400');
                } else {
                    btn.classList.remove('bg-gray-700', 'text-white');
                    btn.classList.add('text-gray-400');
                }
            });
        });
    }

    function toggleMobileTabDropdown() {
        var dd      = document.getElementById('mobile-tab-dropdown');
        var chevron = document.getElementById('mobile-tab-chevron');
        var open    = !dd.classList.contains('hidden');
        dd.classList.toggle('hidden', open);
        chevron.style.transform = open ? '' : 'rotate(180deg)';
    }

    function selectMobileTab(id, name) {
        document.getElementById('mobile-tab-label').textContent = name;
        document.getElementById('mobile-tab-dropdown').classList.add('hidden');
        document.getElementById('mobile-tab-chevron').style.transform = '';
        // Highlight selected option
        document.querySelectorAll('.mobile-tab-opt').forEach(function(btn) {
            btn.classList.toggle('text-amber-400', btn.dataset.id === id);
            btn.classList.toggle('text-gray-300', btn.dataset.id !== id);
        });
        showLeagueTab(id);
    }

    // Close dropdown on outside click
    document.addEventListener('click', function(e) {
        var dd  = document.getElementById('mobile-tab-dropdown');
        var btn = document.getElementById('mobile-tab-btn');
        if (dd && btn && !dd.contains(e.target) && !btn.contains(e.target)) {
            dd.classList.add('hidden');
            document.getElementById('mobile-tab-chevron').style.transform = '';
        }
    });

    function positionTabBar() {
        var title        = document.getElementById('league-title-bar');
        var tabBar       = document.getElementById('league-tab-bar');
        var titleSpacer  = document.getElementById('league-title-spacer');
        var tabSpacer    = document.getElementById('league-tab-spacer');
        if (!title || !tabBar) return;
        var titleRect = title.getBoundingClientRect();
        var top       = titleRect.bottom;  // exact visual bottom of the title bar
        var tabH      = tabBar.offsetHeight;
        tabBar.style.top = top + 'px';
        if (titleSpacer) titleSpacer.style.height = title.offsetHeight + 'px';
        if (tabSpacer)   tabSpacer.style.height   = tabH + 'px';

        currentPanelH = 'calc(100vh - ' + (top + tabH) + 'px)';
        // Re-apply heights if a tab is already open
        if (currentLeagueTab) {
            var sc = document.getElementById('subpanel_content_' + currentLeagueTab);
            var sh = document.getElementById('subpanel_chat_' + currentLeagueTab);
            if (sc) sc.style.height = currentPanelH;
            if (sh) sh.style.height = currentPanelH;
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        positionTabBar();
        window.addEventListener('resize', positionTabBar);
        window.addEventListener('load', positionTabBar);

        var returnPanel = sessionStorage.getItem('leagueReturnPanel');
        var returnSub   = sessionStorage.getItem('leagueReturnSub');
        sessionStorage.removeItem('leagueReturnPanel');
        sessionStorage.removeItem('leagueReturnSub');

        if (returnPanel && document.getElementById('panel_' + returnPanel)) {
            showLeagueTab(returnPanel);
            if (returnSub === 'chat') showSubTabAll('chat');
        } else {
            showLeagueTab('{{ $firstTab }}');
        }

        // Save current tab before navigating away (e.g. clicking notification bell)
        document.addEventListener('click', function(e) {
            var link = e.target.closest('a[href]');
            if (link && currentLeagueTab && !link.href.includes(window.location.pathname)) {
                sessionStorage.setItem('leagueReturnPanel', currentLeagueTab);
                sessionStorage.setItem('leagueReturnSub', currentSubTab || 'content');
            }
        });

        // Set initial mobile dropdown label
        var firstOpt = document.querySelector('.mobile-tab-opt[data-id="{{ $firstTab }}"]');
        if (firstOpt) {
            document.getElementById('mobile-tab-label').textContent = firstOpt.textContent.trim();
            firstOpt.classList.add('text-amber-400');
            firstOpt.classList.remove('text-gray-300');
        }
    });
</script>

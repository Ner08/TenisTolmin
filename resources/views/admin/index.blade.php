<x-layout :message="$message ?? null" :flash="$flash ?? null" :model="$model ?? null">
    @title('Admin plošča - Tenis Tolmin')
    <x-confirm-action />

    {{-- Fixed title bar --}}
    <div class="bg-gray-900 border-b border-gray-800 fixed top-14 left-0 right-0 z-40">
        <div class="max-w-screen-2xl mx-auto px-4 py-3 flex items-center gap-3">
            <div class="w-1 h-6 bg-amber-500 rounded-full flex-shrink-0"></div>
            <h1 class="text-lg font-bold text-white tracking-tight">Administracijska plošča</h1>
        </div>
    </div>

    {{-- Fixed tab bar --}}
    <div class="fixed top-[6.75rem] left-0 right-0 z-30 bg-gray-900 border-b border-gray-800">
        <div class="max-w-screen-2xl mx-auto">
        <div class="flex items-center overflow-x-auto px-4 py-2 gap-1" style="scrollbar-width:none;-ms-overflow-style:none;">

            <button onclick="showAdminTab('lige')" id="atab_lige"
                class="admin-tab inline-flex items-center gap-2 px-4 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap transition-colors duration-150 flex-shrink-0 text-gray-400 hover:text-white hover:bg-gray-800">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
                Lige
            </button>

            <button onclick="showAdminTab('igralci')" id="atab_igralci"
                class="admin-tab inline-flex items-center gap-2 px-4 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap transition-colors duration-150 flex-shrink-0 text-gray-400 hover:text-white hover:bg-gray-800">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Igralci
            </button>

            <button onclick="showAdminTab('novice')" id="atab_novice"
                class="admin-tab inline-flex items-center gap-2 px-4 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap transition-colors duration-150 flex-shrink-0 text-gray-400 hover:text-white hover:bg-gray-800">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                Novice
            </button>

            <button onclick="showAdminTab('dogodki')" id="atab_dogodki"
                class="admin-tab inline-flex items-center gap-2 px-4 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap transition-colors duration-150 flex-shrink-0 text-gray-400 hover:text-white hover:bg-gray-800">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Dogodki
            </button>

            <button onclick="showAdminTab('galerija')" id="atab_galerija"
                class="admin-tab inline-flex items-center gap-2 px-4 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap transition-colors duration-150 flex-shrink-0 text-gray-400 hover:text-white hover:bg-gray-800">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Galerija
            </button>

            <button onclick="showAdminTab('clanarina')" id="atab_clanarina"
                class="admin-tab inline-flex items-center gap-2 px-4 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap transition-colors duration-150 flex-shrink-0 text-gray-400 hover:text-white hover:bg-gray-800">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                Članarina
            </button>

            <button onclick="showAdminTab('uporabniki')" id="atab_uporabniki"
                class="admin-tab inline-flex items-center gap-2 px-4 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap transition-colors duration-150 flex-shrink-0 text-gray-400 hover:text-white hover:bg-gray-800">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Uporabniki
                @if ($pending_users->count() > 0)
                    <span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-white bg-red-500 rounded-full">
                        {{ $pending_users->count() }}
                    </span>
                @endif
            </button>

        </div>
        </div>
    </div>

    {{-- Spacer to clear fixed title + tab bars --}}
    <div class="h-[6.75rem]"></div>

    {{-- Section panels --}}
    <div class="pb-10">
        <x-admin.leagues :leagues="$leagues" />
        <x-admin.players :players="$players" />
        <x-admin.news :news="$news" />
        <x-admin.events :events="$events" />
        <x-admin.gallery :gallery="$gallery" />
        <x-admin.membership :membership="$membership" />
        <x-admin.users :pending-users="$pending_users" :all-users="$all_users" :disputed-matchups="$disputed_matchups" :unlinked-players="$unlinked_players" />
    </div>

</x-layout>

<script>
    var adminTabs = ['lige', 'igralci', 'novice', 'dogodki', 'galerija', 'clanarina', 'uporabniki'];

    function showAdminTab(id) {
        adminTabs.forEach(function (t) {
            var panel = document.getElementById('admin_' + t);
            var tab   = document.getElementById('atab_' + t);
            if (panel) panel.style.display = 'none';
            if (tab) {
                tab.classList.remove('bg-amber-500', 'text-gray-900');
                tab.classList.add('text-gray-400');
            }
        });
        var panel = document.getElementById('admin_' + id);
        var tab   = document.getElementById('atab_' + id);
        if (panel) panel.style.display = 'block';
        if (tab) {
            tab.classList.add('bg-amber-500', 'text-gray-900');
            tab.classList.remove('text-gray-400');
        }
        try { sessionStorage.setItem('adminTab', id); } catch(e) {}
    }

    function togglePointsInput() {
        var pointsInput = document.getElementById('points');
        var isGroupStageCheckbox = document.getElementById('is_fake');
        pointsInput.disabled = isGroupStageCheckbox.checked;
        if (isGroupStageCheckbox.checked) pointsInput.value = '0';
    }

    document.addEventListener('DOMContentLoaded', function () {
        var saved = null;
        try { saved = sessionStorage.getItem('adminTab'); } catch(e) {}
        showAdminTab(saved && adminTabs.indexOf(saved) !== -1 ? saved : 'lige');
    });
</script>

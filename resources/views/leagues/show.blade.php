<x-layout>
    @php
        $title = 'Liga ali turnir - ' . $league->name;
        $titleTab = $title . ' - Tenis Tolmin';
    @endphp

    @title($titleTab)
    <div>
        @if ($isMobile)
            <x-sm-league-title :data="['name' => $league->name, 'start_date' => $league->start_date, 'end_date' => $league->end_date]" />
            @if ($brackets->isNotEmpty())
                <x-league-group-title title="Izločitveni del" divId="leagueMobileComponent" />
            @endif
            <div id="leagueMobileComponent">
                <x-sm-screen-leagues :brackets="$brackets" />
            </div>
            @if ($brackets_group->isNotEmpty())
                <x-league-group-title title="Skupinski del" divId="groupMobileComponent" />
            @endif
            <div id="groupMobileComponent">
                @include('partials._sm_league_group_stage', ['brackets' => $brackets_group])
            </div>
            @if ($brackets->isEmpty() && $brackets_group->isEmpty())
                <div class="m-6">
                    <div class="text-xl font-bold text-gray-700 bg-gray-300 p-4 rounded-lg inline-block">
                        Liga še ni nastavljena, mogoče pa se prikaže kmalu :)
                    </div>
                </div>
            @endif
        @else
            <x-league-title :data="['name' => $league->name, 'start_date' => $league->start_date, 'end_date' => $league->end_date]" />
            @if ($brackets->isNotEmpty())
                <x-league-group-title title="Izločitveni del" divId="leagueComponent" />
            @endif
            <div id="leagueComponent">
                @include('partials._league_bracket_stage', ['brackets' => $brackets])
            </div>
            @if ($brackets_group->isNotEmpty())
                <x-league-group-title title="Skupinski del" divId="groupComponent" />
            @endif
            <div id="groupComponent">
                @include('partials._league_group_stage', ['brackets' => $brackets_group])
            </div>
            @if ($brackets->isEmpty() && $brackets_group->isEmpty())
                <div class="m-6">
                    <div class="text-xl font-bold text-gray-700 bg-gray-300 p-4 rounded-lg inline-block">
                        Liga še ni nastavljena, mogoče pa se prikaže kmalu :)
                    </div>
                </div>
            @endif
        @endif
    </div>
    {{-- <div class="h-3 bg-zinc-900"></div> --}}
</x-layout>

<script>
    window.onload = function() {
        // Loop through each component ID stored in localStorage
        Object.keys(localStorage).forEach(function(key) {
            // Get the visibility state from localStorage
            var displayState = localStorage.getItem(key);
            // Check if the element exists in the DOM
            var component = document.getElementById(key);
            if (component) {
                // Set the visibility of the component based on stored state
                component.style.display = displayState;
            }
        });
    };
</script>

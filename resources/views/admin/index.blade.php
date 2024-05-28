<x-layout :message="$message ?? null" :flash="$flash ?? null" :model="$model ?? null">
    @title('Admin plošča - Tenis Tolmin')

    <!-- Include Delete Confirmation Component -->
    <x-delete-confirmation />

    <x-admin-title title="Adminstracijska plošča" />

    <div class="bg-gray-200">
        <!-- Leagues Section -->
        <div id="lige">
            <x-title-admin title="Lige in turnirji" divId="admin_lige" />
        </div>
        <x-admin.leagues :leagues="$leagues" />

        <!-- Players Section -->
        <div id="igralci">
            <x-title-admin title="Igralci" divId="admin_igralci" />
        </div>
        <x-admin.players :players="$players" />

        <!-- News Section -->
        <div id="novice">
            <x-title-admin title="Novice" divId="admin_novice" />
        </div>
        <x-admin.news :news="$news" />

        <!-- Events Section -->
        <div id="dogodki">
            <x-title-admin title="Dogodki" divId="admin_dogodki" />
        </div>
        <x-admin.events :events="$events" />

        <!-- Gallery Section -->
        <div id="galerija">
            <x-title-admin title="Galerija" divId="admin_galerija" />
        </div>
        <x-admin.gallery :gallery="$gallery" />

        <!-- Membeship Section -->
        <div id="clanarina">
            <x-title-admin title="Članarina" divId="admin_clanarina" />
        </div>
        <x-admin.membership :membership="$membership" />

        {{-- <div class="h-3 bg-zinc-900"></div> --}}
</x-layout>

<script>
    function togglePointsInput() {
        var pointsInput = document.getElementById('points');
        var isGroupStageCheckbox = document.getElementById('is_fake');

        pointsInput.disabled = isGroupStageCheckbox.checked;
        if (isGroupStageCheckbox.checked) {
            pointsInput.value = '0';
        }
    }
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

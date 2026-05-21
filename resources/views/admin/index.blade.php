<x-layout :message="$message ?? null" :flash="$flash ?? null" :model="$model ?? null">
    @title('Admin plošča - Tenis Tolmin')

    <x-delete-confirmation />
    <x-admin-title title="Administracijska plošča" />

    <div class="bg-gray-50 min-h-screen">
        <div id="lige">
            <x-title-admin title="Lige in turnirji" divId="admin_lige" />
        </div>
        <x-admin.leagues :leagues="$leagues" />

        <div id="igralci">
            <x-title-admin title="Igralci" divId="admin_igralci" />
        </div>
        <x-admin.players :players="$players" />

        <div id="novice">
            <x-title-admin title="Novice" divId="admin_novice" />
        </div>
        <x-admin.news :news="$news" />

        <div id="dogodki">
            <x-title-admin title="Dogodki" divId="admin_dogodki" />
        </div>
        <x-admin.events :events="$events" />

        <div id="galerija">
            <x-title-admin title="Galerija" divId="admin_galerija" />
        </div>
        <x-admin.gallery :gallery="$gallery" />

        <div id="clanarina">
            <x-title-admin title="Članarina" divId="admin_clanarina" />
        </div>
        <x-admin.membership :membership="$membership" />
    </div>

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
        Object.keys(localStorage).forEach(function(key) {
            var displayState = localStorage.getItem(key);
            var component = document.getElementById(key);
            if (component) {
                component.style.display = displayState;
            }
        });
    };
</script>

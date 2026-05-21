<x-layout :message="$message ?? null" :flash="$flash ?? null" :model="$model ?? null">
    @title('Urejanje igralca - ' . $player->p_name . ' - Tenis Tolmin')
    <x-admin-title-simple title="Uredi igralca" />

    <div class="container mx-auto py-6 px-4 max-w-lg">
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <form action="{{ route('players_edit', $player->id) }}" method="POST" class="p-6 space-y-5">
                @method('PUT')
                @csrf

                <div>
                    <label for="p_name" class="block text-sm font-medium text-gray-700 mb-1.5">Ime</label>
                    <input type="text" name="p_name" id="p_name" placeholder="Vnesi ime igralca"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                        value="{{ $player->p_name }}" required>
                    @error('p_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="points" class="block text-sm font-medium text-gray-700 mb-1.5">Točke</label>
                    <input type="number" name="points" id="points" min="0"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent disabled:bg-gray-50 disabled:text-gray-400"
                        value="{{ $player->points }}" @if ($player->is_fake) disabled @endif required>
                    @error('points')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-center gap-3 cursor-pointer p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                    <input type="checkbox" name="is_fake" id="is_fake"
                        class="w-4 h-4 rounded border-gray-300 text-amber-500 focus:ring-amber-500"
                        onchange="togglePointsInput()"
                        value="1" @if ($player->is_fake) checked @endif>
                    <div>
                        <span class="text-sm font-medium text-gray-700">Ni na ATP lestvici</span>
                        <p class="text-xs text-gray-400">Igralec ne bo prikazan na javni lestvici</p>
                    </div>
                    @error('is_fake')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </label>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="px-6 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold rounded-lg transition-colors duration-150">
                        Shrani spremembe
                    </button>
                    <a href="{{ route('admin') }}"
                        class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg transition-colors duration-150">
                        Prekliči
                    </a>
                </div>
            </form>
        </div>
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
</script>

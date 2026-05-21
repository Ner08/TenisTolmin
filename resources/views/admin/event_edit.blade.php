<x-layout :message="$message ?? null" :flash="$flash ?? null" :model="$model ?? null">
    @title('Urejanje dogodka - ' . $event->e_title . ' - Tenis Tolmin')
    <x-admin-title-simple title="Uredi dogodek" />

    <div class="container mx-auto py-6 px-4 max-w-2xl">
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <form action="{{ route('events_edit', $event->id) }}" method="POST" class="p-6 space-y-5">
                @method('PUT')
                @csrf

                <div>
                    <label for="e_title" class="block text-sm font-medium text-gray-700 mb-1.5">Naslov</label>
                    <input type="text" name="e_title" id="e_title" placeholder="Vnesite naslov dogodka"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                        value="{{ $event->e_title }}" required>
                    @error('e_title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="e_description" class="block text-sm font-medium text-gray-700 mb-1.5">Opis</label>
                    <textarea name="e_description" id="e_description" placeholder="Vnesite opis dogodka"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm h-36 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent resize-none"
                        required>{{ $event->e_description }}</textarea>
                    @error('e_description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1.5">Lokacija</label>
                    <input type="text" name="location" id="location" placeholder="Vnesite lokacijo dogodka"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                        value="{{ $event->location }}" required>
                    @error('location')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="fromDate" class="block text-sm font-medium text-gray-700 mb-1.5">Datum in čas začetka</label>
                        <input type="datetime-local" name="fromDate" id="fromDate"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                            value="{{ $event->fromDate ? \Carbon\Carbon::parse($event->fromDate)->format('Y-m-d\TH:i') : '' }}" required>
                        @error('start_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="toDate" class="block text-sm font-medium text-gray-700 mb-1.5">Datum in čas zaključka <span class="text-gray-400">(neobvezno)</span></label>
                        <input type="datetime-local" name="toDate" id="toDate"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                            value="{{ $event->toDate ? \Carbon\Carbon::parse($event->toDate)->format('Y-m-d\TH:i') : '' }}">
                        @error('end_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

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

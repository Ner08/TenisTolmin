<x-layout :message="$message ?? null" :flash="$flash ?? null" :model="$model ?? null">
    <div class="container mx-auto mt-3 px-4">
        <!-- Add new events form -->
        <div class="bg-zinc-900 text-white py-2 px-4 rounded-t-lg">
            <h2 class="text-xl font-bold">Uredi dogodek</h2>
        </div>
        <form action="{{ route('events_edit', $event->id) }}" method="POST" class="mb-5 bg-gray-100 rounded-lg p-6">
            @method('PUT')
            @csrf
            <div class="mb-4">
                <label for="e_title" class="block text-gray-700 font-semibold">Naslov:</label>
                <input type="text" name="e_title" id="e_title" placeholder="Vnesite naslov dogodka"
                    class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                    value="{{ $event->e_title }}" required>
                @error('e_title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="e_description" class="block text-gray-700 font-semibold">Vsebina:</label>
                <textarea name="e_description" id="e_description" placeholder="Vnesite opis dogodka"
                    class="form-textarea rounded-lg w-full h-48 focus:outline-none  border-gray-300 py-3 px-4" required>{{ $event->e_description }}</textarea>
                @error('e_description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="location" class="block text-gray-700 font-semibold">Lokacija:</label>
                <input type="text" name="location" id="location" placeholder="Vnesite lokacijo dogodka"
                    class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                    value="{{ $event->location }}" required>
                @error('location')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="start_date" class="block text-gray-700 font-semibold">Datum in čas začetka:</label>
                <input type="datetime-local" name="fromDate" id="fromDate"
                       class="form-input rounded-lg w-full focus:outline-none border-gray-300 py-3 px-4"
                       value="{{ $event->fromDate ? \Carbon\Carbon::parse($event->fromDate)->format('Y-m-d\TH:i') : '' }}" required>
                @error('start_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="end_date" class="block text-gray-700 font-semibold">Datum in čas zaključka (neobvezno):</label>
                <input type="datetime-local" name="toDate" id="toDate"
                       class="form-input rounded-lg w-full focus:outline-none border-gray-300 py-3 px-4"
                       value="{{ $event->toDate ? \Carbon\Carbon::parse($event->toDate)->format('Y-m-d\TH:i') : '' }}">
                @error('end_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="bg-zinc-500 text-white px-8 py-3 rounded-lg hover:bg-zinc-600 focus:outline-none transition duration-300">
                Shrani
            </button>
        </form>
    </div>
</x-layout>

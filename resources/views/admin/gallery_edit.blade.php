<x-layout :message="$message ?? null" :flash="$flash ?? null" :model="$model ?? null">
    @title('Urejanje slike - ' . $gallery->g_title . ' - Tenis Tolmin')
    <x-admin-title-simple title="Uredi sliko" />

    <div class="container mx-auto py-6 px-4 max-w-2xl">
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <form action="{{ route('gallery_edit', $gallery->id) }}" method="POST" class="p-6 space-y-5"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div>
                    <label for="g_title" class="block text-sm font-medium text-gray-700 mb-1.5">Naslov</label>
                    <input type="text" name="g_title" id="g_title" placeholder="Vnesite naslov slike"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                        value="{{ $gallery->g_title }}" required>
                    @error('g_title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-2.5">
                    <input type="checkbox" name="home_page" id="home_page"
                        class="w-4 h-4 rounded border-gray-300 text-amber-500 focus:ring-amber-500"
                        value="1" {{ $gallery->home_page ? 'checked' : '' }}>
                    <label for="home_page" class="text-sm text-gray-700">Prikaži na domači strani</label>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Slika</label>
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $gallery->g_image) }}" alt="{{ $gallery->g_title }}"
                             loading="lazy"
                             class="h-32 w-auto rounded-lg border border-gray-200 object-cover">
                        <p class="text-xs text-gray-400 mt-1">Trenutna slika — naložite novo za zamenjavo</p>
                    </div>
                    <input type="file" name="g_image" id="g_image" accept="image/*"
                        class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                    @error('g_image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
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

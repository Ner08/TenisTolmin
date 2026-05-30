<div class="container mx-auto mt-3 px-4" id="admin_galerija" style="display: none">
    <div class="bg-gray-900 text-white px-5 py-3 rounded-t-xl">
        <h2 class="text-sm font-semibold">Dodaj sliko v galerijo</h2>
    </div>
    <form action="{{ route('gallery_store') }}" method="POST" class="mb-6 bg-white border border-gray-200 border-t-0 rounded-b-xl p-5"
        enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="g_title" class="block text-xs font-semibold text-gray-700 mb-1.5">Naslov</label>
            <input type="text" name="g_title" id="g_title" placeholder="Vnesite naslov slike"
                class="border border-gray-200 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-amber-500 py-2.5 px-3.5 text-sm"
                value="{{ old('g_title') }}" required>
            @error('g_title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4 flex items-center gap-2.5">
            <input type="checkbox" name="home_page" id="home_page"
                class="w-4 h-4 rounded border-gray-300 text-amber-500 focus:ring-amber-500" value="1">
            <label for="home_page" class="text-sm text-gray-700">Prikaži na domači strani</label>
            @error('home_page')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <p class="text-xs text-gray-500 mb-4 -mt-2">Na domači strani se pokažejo 3 najnovejše slike označene s to možnostjo.</p>
        <div class="mb-5">
            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Slika</label>
            <label class="flex items-center gap-3 border border-gray-200 rounded-lg px-3.5 py-2.5 cursor-pointer hover:border-amber-400 transition-colors">
                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="text-sm text-gray-500">Izberi sliko</span>
                <input type="file" name="g_image" id="g_image" class="hidden">
            </label>
            @error('g_image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit"
            class="bg-gray-900 text-white text-sm px-6 py-2.5 rounded-lg hover:bg-gray-700 transition-colors">
            Dodaj sliko
        </button>
    </form>

    <form action="" method="GET">
        <div class="flex mb-5">
            <input type="text" name="search_gallery" id="search_gallery" placeholder="Iskanje slik..."
                class="border border-gray-200 rounded-l-lg py-2.5 px-3.5 text-sm w-full sm:w-72 focus:outline-none focus:ring-2 focus:ring-amber-500"
                value="{{ isset($search_gallery) ? $search_gallery : '' }}">
            <button type="submit"
                class="bg-gray-900 text-white text-sm px-5 rounded-r-lg hover:bg-gray-700 transition-colors flex-shrink-0">
                Išči
            </button>
        </div>
    </form>

    <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @if ($gallery->isEmpty())
            <p class="text-sm text-gray-500 col-span-3 py-4">Nismo našli nobene slike.</p>
        @else
            @foreach ($gallery as $item)
                <li class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                    <div class="w-full h-52 overflow-hidden">
                        <img class="object-cover w-full h-full"
                            src="{{ asset('storage/' . $item->g_image) }}" alt="{{ $item->g_title }}">
                    </div>
                    <div class="px-4 py-3">
                        <div class="flex items-center justify-between mb-0.5">
                            <h2 class="text-sm font-semibold text-gray-900">{{ $item->g_title }}</h2>
                            @if ($item->home_page)
                                <span class="text-xs font-medium bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">Domača</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center justify-end gap-2 px-4 py-3 border-t border-gray-100 bg-gray-50">
                        <a href="{{ route('gallery_edit_view', $item->id) }}"
                            class="text-xs font-medium text-gray-700 bg-white border border-gray-200 px-3 py-1.5 rounded-lg hover:border-gray-300 transition-colors">
                            Uredi
                        </a>
                        <form id="deleteGallerysForm{{ $item->id }}"
                            action="{{ route('gallery_destroy', ['gallery' => $item->id]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                onclick="showDeleteConfirmation('deleteGallerysForm', {{ $item->id }})"
                                class="text-xs font-medium text-red-600 bg-white border border-red-200 px-3 py-1.5 rounded-lg hover:bg-red-50 transition-colors">
                                Izbriši
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
    <div class="mt-4">{{ $gallery->links() }}</div>
</div>

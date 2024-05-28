<div class="container mx-auto mt-3 px-4" id="admin_galerija" style="display: none">
    <!-- Add new gallery form -->
    <div class="bg-zinc-900 text-white py-2 px-4 rounded-t-lg">
        <h2 class="text-xl font-bold">Dodaj Sliko v Galerijo</h2>
    </div>
    <form action="{{ route('gallery_store') }}" method="POST" class="mb-5 bg-gray-100 rounded-lg p-6"
        enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="g_title" class="block text-gray-700 font-semibold">Naslov:</label>
            <input type="text" name="g_title" id="g_title" placeholder="Vnesite naslov"
                class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                value="{{ old('g_title') }}" required>
            @error('g_title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <input type="checkbox" name="home_page" id="home_page"
                class="mr-2 bg-gray-300 rounded-sm h-5 w-5" value="1">
            <label for="is_standin" class="text-gray-700 font-semibold mr-4">Na domači strani</label>
            @error('home_page')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="mt-4 text-gray-600"><b>Informacija:</b> Na domači strani se pokažejo 3 najnovejše
                slike označene z "Na domači strani"</p>
        </div>
        <div class="mb-4">
            <label for="file" class="block text-gray-700 font-semibold">Datoteka:</label>
            <input type="file" name="g_image" id="g_image"
                class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3"
                value="{{ old('g_image') }}">
            @error('g_image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit"
            class="bg-zinc-500 text-white px-8 py-3 rounded-lg hover:bg-zinc-600 focus:outline-none transition duration-300">Dodaj
        </button>
    </form>

    <form action="" method="GET" class="flex flex-col items-start">
        <div class="flex mb-4" id="news">
            <input type="text" name="search_gallery" id="search_gallery" placeholder="Iskanje"
                class="form-input rounded-lg py-3 px-4 w-full h-12 sm:w-64 mb-2 sm:mb-0 focus:outline-none "
                value="{{ isset($search_gallery) ? $search_gallery : '' }}">
            <button type="submit"
                class="bg-zinc-600 text-white px-6 h-12 ml-2 rounded-lg hover:bg-zinc-700 focus:outline-none focus:bg-zinc-7s00">Iskanje
            </button>
        </div>
    </form>
    <!-- Display list of images with edit and delete buttons -->
    <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @if ($gallery->isEmpty())
            <h2 class="p-4 text-gray-900">Nismo našli nobene slike.</h2>
        @else
            @foreach ($gallery as $item)
                <li class="flex flex-col bg-gray-100 rounded-lg text-gray-900 shadow-md">
                    <div class="w-full h-64 overflow-hidden rounded-t-lg">
                        <img class="object-cover w-full h-full"
                            src="{{ asset('storage/' . $item->g_image) }}" alt="{{ $item->g_title }}">
                    </div>
                    <div class="flex justify-between items-center my-2 mx-5">
                        <h2 class="text-lg font-bold mt-1 mb-2">{{ $item->g_title }}</h2>
                        <div class="flex">
                            @if ($item->home_page)
                                <div class="mr-4">
                                    <img src="{{ asset('images/home.png') }}" alt="Home"
                                        class="w-5 h-5">
                                </div>
                            @endif
                            <a href="{{ route('gallery_edit', $item->id) }}"
                                class="text-blue-500 hover:underline mr-4">Uredi</a>
                            <!-- Delete Form with Confirmation Dialog -->
                            <form id="deleteGallerysForm{{ $item->id }}"
                                action="{{ route('gallery_destroy', ['gallery' => $item->id]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    onclick="showDeleteConfirmation('deleteGallerysForm', {{ $item->id }})"
                                    class="text-red-500 hover:underline">Izbriši</button>
                            </form>
                        </div>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
    <div class="p-4">{{ $gallery->links() }}</div>
</div>

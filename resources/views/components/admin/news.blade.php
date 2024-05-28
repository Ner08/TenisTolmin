<div class="container mx-auto mt-3 mb-8 px-4" id="admin_novice" style="display: none">
    <!-- Add new news form -->
    <div class="bg-zinc-900 text-white py-2 px-4 rounded-t-lg">
        <h2 class="text-xl font-bold">Dodaj novice</h2>
    </div>
    <form action="{{ route('news_store') }}" method="POST" class="mb-5 bg-gray-100 rounded-lg p-6"
        enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-semibold">Naslov:</label>
            <input type="text" name="title" id="title" placeholder="Vnesite naslov"
                class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                value="{{ old('title') }}" required>
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="content" class="block text-gray-700 font-semibold">Vsebina:</label>
            <textarea name="content" id="content" placeholder="Vnesite vsebino"
                class="form-textarea rounded-lg w-full h-48 focus:outline-none  border-gray-300 py-3 px-4" required>{{ old('content') }}</textarea>
            @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="file" class="block text-gray-700 font-semibold">Datoteka:</label>
            <input type="file" name="image" id="image"
                class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3"
                value="{{ old('image') }}">
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit"
            class="bg-zinc-500 text-white px-8 py-3 rounded-lg hover:bg-zinc-600 focus:outline-none transition duration-300">Dodaj
        </button>
    </form>


    <form action="" method="GET" class="flex flex-col items-start">
        <div class="flex mb-4" id="news">
            <input type="text" name="search_news" id="search_news" placeholder="Iskanje"
                class="form-input rounded-lg py-3 px-4 w-full h-12 sm:w-64 mb-2 sm:mb-0 focus:outline-none "
                value="{{ isset($search_news) ? $search_news : '' }}">
            <button type="submit"
                class="bg-zinc-600 text-white px-6 h-12 ml-2 rounded-lg hover:bg-zinc-700 focus:outline-none focus:bg-zinc-7s00">Iskanje
            </button>
        </div>
    </form>
    <!-- Display list of news with edit and delete buttons -->
    <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @if ($news->isEmpty())
            <h2 class="p-4 text-gray-900">Nismo našli nobene novice.</h2>
        @else
            @foreach ($news as $item)
                <li class="bg-white rounded-lg shadow-md p-6 overflow-hidden">
                    <h3 class="text-xl font-bold mb-2">{{ $item->title }}</h3>
                    <p class="text-gray-700 line-clamp-3">{{ $item->content }}</p>
                    <p class="text-gray-500 mt-2"> {{ $item->created_at->format('d.m.Y') }}</p>
                    <div class="flex justify-end mt-4">
                        <a href="{{ route('news_edit_view', $item->id) }}"
                            class="text-blue-500 hover:underline mr-4">Uredi</a>
                        <!-- Delete Form with Confirmation Dialog -->
                        <form id="deleteNewsForm{{ $item->id }}"
                            action="{{ route('news_destroy', ['news' => $item->id]) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="button"
                                onclick="showDeleteConfirmation('deleteNewsForm', {{ $item->id }})"
                                class="text-red-500 hover:underline">Izbriši</button>
                        </form>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
    <div class="p-4">{{ $news->links() }}</div>
</div>

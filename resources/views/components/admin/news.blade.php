<div class="container mx-auto mt-3 mb-8 px-4" id="admin_novice" style="display: none">
    <div class="bg-gray-900 text-white px-5 py-3 rounded-t-xl">
        <h2 class="text-sm font-semibold">Dodaj novice</h2>
    </div>
    <form action="{{ route('news_store') }}" method="POST" class="mb-6 bg-white border border-gray-200 border-t-0 rounded-b-xl p-5"
        enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="title" class="block text-xs font-semibold text-gray-700 mb-1.5">Naslov</label>
            <input type="text" name="title" id="title" placeholder="Vnesite naslov"
                class="border border-gray-200 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-amber-500 py-2.5 px-3.5 text-sm"
                value="{{ old('title') }}" required>
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="content" class="block text-xs font-semibold text-gray-700 mb-1.5">Vsebina</label>
            <textarea name="content" id="content" placeholder="Vnesite vsebino"
                class="border border-gray-200 rounded-lg w-full h-40 focus:outline-none focus:ring-2 focus:ring-amber-500 py-2.5 px-3.5 text-sm" required>{{ old('content') }}</textarea>
            @error('content')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-5">
            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Slika (neobvezno)</label>
            <label class="flex items-center gap-3 border border-gray-200 rounded-lg px-3.5 py-2.5 cursor-pointer hover:border-amber-400 transition-colors">
                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="text-sm text-gray-500">Izberi sliko</span>
                <input type="file" name="image" id="image" class="hidden">
            </label>
            @error('image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit"
            class="bg-gray-900 text-white text-sm px-6 py-2.5 rounded-lg hover:bg-gray-700 transition-colors">
            Dodaj novico
        </button>
    </form>

    <form action="" method="GET">
        <div class="flex mb-5">
            <input type="text" name="search_news" id="search_news" placeholder="Iskanje novic..."
                class="border border-gray-200 rounded-l-lg py-2.5 px-3.5 text-sm w-full sm:w-72 focus:outline-none focus:ring-2 focus:ring-amber-500"
                value="{{ isset($search_news) ? $search_news : '' }}">
            <button type="submit"
                class="bg-gray-900 text-white text-sm px-5 rounded-r-lg hover:bg-gray-700 transition-colors flex-shrink-0">
                Išči
            </button>
        </div>
    </form>

    <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @if ($news->isEmpty())
            <p class="text-sm text-gray-500 col-span-3 py-4">Nismo našli nobene novice.</p>
        @else
            @foreach ($news as $item)
                <li class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                    <div class="p-5">
                        <h3 class="text-sm font-semibold text-gray-900 mb-1.5">{{ $item->title }}</h3>
                        <p class="text-xs text-gray-600 line-clamp-3 leading-relaxed">{{ $item->content }}</p>
                        <p class="text-xs text-gray-400 mt-3">{{ $item->created_at->format('d.m.Y') }}</p>
                    </div>
                    <div class="flex items-center justify-end gap-2 px-5 py-3 border-t border-gray-100 bg-gray-50">
                        <a href="{{ route('news_edit_view', $item->id) }}"
                            class="text-xs font-medium text-gray-700 bg-white border border-gray-200 px-3 py-1.5 rounded-lg hover:border-gray-300 transition-colors">
                            Uredi
                        </a>
                        <form id="deleteNewsForm{{ $item->id }}"
                            action="{{ route('news_destroy', ['news' => $item->id]) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="button"
                                onclick="showDeleteConfirmation('deleteNewsForm', {{ $item->id }})"
                                class="text-xs font-medium text-red-600 bg-white border border-red-200 px-3 py-1.5 rounded-lg hover:bg-red-50 transition-colors">
                                Izbriši
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
    <div class="mt-4">{{ $news->links() }}</div>
</div>

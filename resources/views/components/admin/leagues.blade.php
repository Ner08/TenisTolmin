<div class="container mx-auto pt-4 px-4" id="admin_lige" style="display: none">
    <div class="bg-gray-900 text-white px-5 py-3 rounded-t-xl">
        <h2 class="text-sm font-semibold">Dodaj ligo ali turnir</h2>
    </div>
    <form action="{{ route('leagues.store') }}" method="POST" class="mb-6 bg-white border border-gray-200 border-t-0 rounded-b-xl p-5">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-xs font-semibold text-gray-700 mb-1.5">Ime lige ali turnirja</label>
            <input type="text" name="name" id="name" placeholder="Vnesite ime"
                class="border border-gray-200 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-amber-500 py-2.5 px-3.5 text-sm"
                value="{{ old('name') }}" required>
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="description" class="block text-xs font-semibold text-gray-700 mb-1.5">Opis</label>
            <textarea name="description" id="description" placeholder="Vnesite opis"
                class="border border-gray-200 rounded-lg w-full h-36 focus:outline-none focus:ring-2 focus:ring-amber-500 py-2.5 px-3.5 text-sm" required>{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4 flex items-center gap-2.5">
            <input type="checkbox" name="l_home_page" id="l_home_page"
                class="w-4 h-4 rounded border-gray-300 text-amber-500 focus:ring-amber-500" value="1">
            <label for="l_home_page" class="text-sm text-gray-700">Prikaži na domači strani</label>
            @error('l_home_page')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <p class="text-xs text-gray-500 mb-4 -mt-2">Na domači strani se pokažejo 3 najnovejše lige označene s to možnostjo.</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
            <div>
                <label for="start_date" class="block text-xs font-semibold text-gray-700 mb-1.5">Datum začetka</label>
                <input type="date" name="start_date" id="start_date"
                    class="border border-gray-200 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-amber-500 py-2.5 px-3.5 text-sm"
                    value="{{ old('start_date') }}" required>
                @error('start_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="end_date" class="block text-xs font-semibold text-gray-700 mb-1.5">Datum zaključka <span class="font-normal text-gray-400">(neobvezno)</span></label>
                <input type="date" name="end_date" id="end_date"
                    class="border border-gray-200 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-amber-500 py-2.5 px-3.5 text-sm"
                    value="{{ old('end_date') }}">
                @error('end_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <button type="submit"
            class="bg-gray-900 text-white text-sm px-6 py-2.5 rounded-lg hover:bg-gray-700 transition-colors">
            Dodaj ligo
        </button>
    </form>

    <form action="" method="GET">
        <div class="flex mb-5">
            <input type="text" name="search_leagues" id="search_leagues" placeholder="Iskanje lig..."
                class="border border-gray-200 rounded-l-lg py-2.5 px-3.5 text-sm w-full sm:w-72 focus:outline-none focus:ring-2 focus:ring-amber-500"
                value="{{ isset($search_leagues) ? $search_leagues : '' }}">
            <button type="submit"
                class="bg-gray-900 text-white text-sm px-5 rounded-r-lg hover:bg-gray-700 transition-colors flex-shrink-0">
                Išči
            </button>
        </div>
    </form>

    <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @if ($leagues->isEmpty())
            <p class="text-sm text-gray-500 col-span-3 py-4">Nismo našli nobene lige.</p>
        @else
            @foreach ($leagues as $item)
                <li class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-3 mb-2">
                            <h3 class="text-sm font-semibold text-gray-900">{{ $item->name }}</h3>
                            @if ($item->l_home_page)
                                <span class="flex-shrink-0 text-xs font-medium bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">Domača</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-600 line-clamp-2 leading-relaxed mb-3">{{ $item->description }}</p>
                        <div class="flex items-center gap-1 text-xs text-gray-500">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($item->start_date)->format('d.m.Y') }}</span>
                            @if ($item->end_date)
                                <span class="text-gray-400">→</span>
                                <span>{{ \Carbon\Carbon::parse($item->end_date)->format('d.m.Y') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center justify-end gap-2 px-5 py-3 border-t border-gray-100 bg-gray-50">
                        <a href="{{ route('bracket_setup', $item->id) }}"
                            class="text-xs font-medium text-gray-700 bg-white border border-gray-200 px-3 py-1.5 rounded-lg hover:border-gray-300 transition-colors">
                            Uredi
                        </a>
                        <form id="deleteForm{{ $item->id }}"
                            action="{{ route('league.destroy', ['league' => $item->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                onclick="showDeleteConfirmation('deleteForm', {{ $item->id }})"
                                class="text-xs font-medium text-red-600 bg-white border border-red-200 px-3 py-1.5 rounded-lg hover:bg-red-50 transition-colors">
                                Izbriši
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
    <div class="mt-4">{{ $leagues->links() }}</div>
</div>

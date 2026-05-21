<div class="container px-4 mx-auto py-10">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-1">Galerija</h2>
        <p class="text-gray-500 text-sm">Igranje, druženje in nepozabni trenutki našega kluba.</p>
    </div>

    @if ($gallery->isEmpty())
        <x-empty model1="Slike" />
    @endif

    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        @foreach ($gallery as $item)
            <div class="group relative aspect-square overflow-hidden rounded-xl bg-gray-200 cursor-pointer shadow-sm hover:shadow-lg transition-shadow duration-300"
                 onclick="showFullImage('{{ asset('storage/' . $item->g_image) }}')">
                <img src="{{ asset('storage/' . $item->g_image) }}"
                     alt="{{ $item->g_title }}"
                     loading="lazy"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors duration-300"></div>
                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <svg class="w-7 h-7 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                    </svg>
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex justify-center mt-6">
        <a href="{{ route('gallery') }}"
           class="bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold py-2.5 px-6 rounded-lg transition-colors duration-200">
            Vsa galerija
        </a>
    </div>
</div>

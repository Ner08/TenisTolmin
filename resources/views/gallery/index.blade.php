<x-layout>
    @title('Galerija - Tenis Tolmin')
    <x-title title="Galerija" />
    <section class="py-8 px-4">
        <div class="container mx-auto">
            @if ($gallery->isEmpty())
                <x-empty model1="Galerija" />
            @endif
            <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-3 md:gap-4">
                @foreach ($gallery as $item)
                    <div class="group relative aspect-square overflow-hidden rounded-xl bg-gray-200 cursor-pointer shadow-sm hover:shadow-lg transition-shadow duration-300"
                         onclick="showFullImage('{{ asset('storage/' . $item->g_image) }}')">
                        <img src="{{ asset('storage/' . $item->g_image) }}"
                             alt="{{ $item->g_title }}"
                             loading="lazy"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/35 transition-colors duration-300"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-3 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                            <p class="text-white text-xs font-medium drop-shadow-lg truncate">{{ $item->g_title }}</p>
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <svg class="w-8 h-8 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                            </svg>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">{{ $gallery->links() }}</div>
        </div>
    </section>
</x-layout>

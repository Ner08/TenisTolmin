<x-layout>
    @title($newsItem->title . ' - Tenis Tolmin')

    <section class="py-10 px-4 bg-gray-50 min-h-screen">
        <div class="container mx-auto max-w-2xl">

            {{-- Top meta row --}}
            <div class="flex items-center justify-between mb-6">
                <a href="{{ route('news') }}"
                   class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Novice
                </a>
                <span class="text-xs text-gray-400 font-medium">{{ $newsItem['created_at']->format('d. m. Y') }}</span>
            </div>

            {{-- Title --}}
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-snug mb-3">
                {{ $newsItem['title'] }}
            </h1>

            {{-- Amber divider --}}
            <div class="w-12 h-1 bg-amber-500 rounded-full mb-7"></div>

            {{-- Image --}}
            @if (isset($newsItem['image']))
                <div class="rounded-2xl overflow-hidden border border-gray-200 shadow-sm mb-7 cursor-zoom-in"
                     onclick="showFullImage('{{ asset('storage/' . $newsItem['image']) }}')">
                    <img src="{{ asset('storage/' . $newsItem['image']) }}"
                         alt="{{ $newsItem['title'] }}"
                         class="w-full object-cover max-h-96 hover:scale-105 transition-transform duration-500">
                </div>
            @endif

            {{-- Content --}}
            <p class="text-gray-700 text-sm leading-8 whitespace-pre-line">{{ $newsItem['content'] }}</p>

        </div>
    </section>
</x-layout>

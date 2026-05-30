<x-layout>
    @title($newsItem->title . ' - Tenis Tolmin')

    <x-title :title="$newsItem->title" back-route="news" back-label="Novice" />
    <style>body { background-color: #f9fafb; }</style>

    <section class="pt-4 pb-10 md:py-10 xl:py-14 px-4">
        <div class="container mx-auto max-w-2xl xl:max-w-3xl 2xl:max-w-4xl">

            {{-- Date --}}
            <div class="flex justify-end mb-6">
                <span class="text-xs text-gray-400 font-medium">{{ $newsItem['created_at']->format('d. m. Y') }}</span>
            </div>

            {{-- Title --}}
            <h1 class="text-2xl md:text-3xl xl:text-4xl font-bold text-gray-900 leading-snug mb-3">
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
                         class="w-full object-cover max-h-96 xl:max-h-[32rem] hover:scale-105 transition-transform duration-500">
                </div>
            @endif

            {{-- Content --}}
            <p class="text-gray-700 text-sm xl:text-base leading-8 xl:leading-9 whitespace-pre-line">{{ $newsItem['content'] }}</p>

        </div>
    </section>

    @include('partials._comments', [
        'comments'        => $comments,
        'storeRoute'      => route('news.comments.store', $newsItem->id),
        'deleteRouteName' => 'news.comments.destroy',
        'commentModel'    => 'comment',
    ])
</x-layout>

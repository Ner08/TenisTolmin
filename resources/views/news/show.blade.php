<x-layout :login="$login" :admin="$admin">
    @php
        $title = 'Novice • ' . $newsItem->title;
    @endphp
    <x-title :title="$title" />

    {{-- News Details --}}
    <section class="m-3">
        <div class="container mx-auto">
            <div class="bg-gray-900 rounded-lg shadow-md overflow-hidden text-white">
                @if (isset($newsItem['image']))
                    <img src="{{ $newsItem['image'] }}" alt="{{ $newsItem['title'] }}" class="w-full h-64 object-cover">
                @endif
                <div class="p-6">
                    <h2 class="text-3xl font-semibold mb-2">{{ $newsItem['title'] }}</h2>
                    <p class="text-gray-200">{{ $newsItem['content'] }}</p>
                    <p class="text-gray-500 mt-4">Objavljeno: {{ $newsItem['created_at']->format('d.m.Y') }}</p>
                </div>
            </div>
            @include('partials._comments')
        </div>
    </section>

</x-layout>

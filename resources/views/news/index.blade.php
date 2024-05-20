<x-layout>
    {{-- News --}}
    <x-title title="Vse novice" />
    <section class="py-8 px-4">
        <div class="container mx-auto">
            {{-- If no news show empty component --}}
            @if ($newsItems->isEmpty())
                <x-empty model1="Novice" />
            @endif
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4">
                <!-- News items -->
                @foreach ($newsItems as $item)
                    @include('partials._news_item')
                @endforeach
            </div>
            <div class="mt-8">{{ $newsItems->links() }}</div>
        </div>
    </section>
</x-layout>

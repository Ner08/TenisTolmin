<x-layout>
    @title('Novice - Tenis Tolmin')
    <x-title title="Vse novice" />
    <section class="pt-4 pb-8 md:py-8 xl:py-12 px-4">
        <div class="container mx-auto max-w-6xl xl:max-w-7xl 2xl:max-w-screen-2xl">
            @if ($newsItems->isEmpty())
                <x-empty model1="Novice" />
            @endif
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4">
                @foreach ($newsItems as $item)
                    @include('partials._news_item')
                @endforeach
            </div>
            <div class="mt-8">{{ $newsItems->links() }}</div>
        </div>
    </section>
</x-layout>

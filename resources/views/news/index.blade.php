<x-layout>
    {{-- News --}}
    <x-title title="Vse novice" />
    <section class="py-8 px-4">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- News items -->
                @foreach ($newsItems as $item)
                    @include('partials._news_item')
                @endforeach
            </div>
            <div class="mt-8">{{ $newsItems->links() }}</div>
        </div>
    </section>
</x-layout>

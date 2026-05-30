<div class="bg-gray-50 border-t border-gray-100">
    <div class="container px-4 mx-auto py-10 xl:py-14 max-w-6xl xl:max-w-7xl 2xl:max-w-screen-2xl">
        <div class="mb-8" data-animate>
            <h2 class="text-2xl xl:text-3xl font-bold text-gray-900 mb-1">Novice</h2>
            <p class="text-gray-500 text-sm xl:text-base">Najnovejše informacije o dogodkih, dosežkih in novostih v naši teniški skupnosti.</p>
        </div>

        @if ($news->isEmpty())
            <x-empty model1="Novice" />
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($news as $item)
                @include('partials._news_item', $item)
            @endforeach
        </div>

        <div class="flex justify-center mt-8">
            <a href="{{ route('news') }}"
               class="bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold py-2.5 px-6 rounded-lg transition-colors duration-200">
                Vse novice
            </a>
        </div>
    </div>
</div>

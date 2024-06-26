<div class="container px-4 mx-auto py-8">
    <h1 class="text-3xl font-bold mb-3">Novice</h1>
    <h4 class="text-lg text-gray-600 mb-8"> V našem razdelku novic redno objavljamo najnovejše informacije o dogodkih,
        dosežkih in novostih v naši teniški skupnosti. Bodite vedno na tekočem z našimi novicami!</h4>
    {{-- If no news show empty component --}}
    @if ($news->isEmpty())
        <x-empty model1="Novice" />
    @endif
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- News items -->
        @foreach ($news as $item)
            @include('partials._news_item', $item)
        @endforeach
    </div>

    <div class="flex justify-center mt-8">
        <a href="{{ route('news') }}"
            class="bg-gray-900 hover:bg-gray-800 text-white text-lg font-bold py-2 px-6 rounded-lg transition duration-300 ease-in-out transform hover:-translate-y-1">
            Več novic
        </a>
    </div>
</div>

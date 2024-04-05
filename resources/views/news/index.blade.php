<x-layout :login="$login">

    {{-- News --}}
    <section class="py-8 px-4">
        <div class="container mx-auto">
            <div class="flex items-center justify-start mb-8"> <!-- Modified justify-center -->
                <div class="bg-gray-900 rounded-md text-center py-1 pb-2 px-3 shadow-lg text-white text-3xl font-bold">
                    Novice
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- News items -->
                @foreach ($newsItems as $newsItem)
                     @include('partials._news_item')
                @endforeach
            </div>
        </div>
        <div class="flex justify-center mt-8">
            <a href="{{route('news')}}" class="bg-gray-900 hover:bg-gray-800 text-white text-lg font-bold py-2 px-6 rounded-lg transition duration-300 ease-in-out transform hover:-translate-y-1">
                Več
            </a>
        </div>
    </section>

</x-layout>

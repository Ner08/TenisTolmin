<div class="container px-4 mx-auto py-8">
    <h1 class="text-3xl font-bold mb-8">Novice</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- News items -->
        @foreach ($news as $newsItem)
           @include('partials._news_item', $newsItem)
        @endforeach
    </div>

    <div class="flex justify-center mt-8">
        <a href="{{route('news')}}" class="bg-gray-900 hover:bg-gray-800 text-white text-lg font-bold py-2 px-6 rounded-lg transition duration-300 ease-in-out transform hover:-translate-y-1">
            Več Novic
        </a>
    </div>
</div>

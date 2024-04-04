<div>
    <a href="{{ route('news_detail', $newsItem['id']) }}">
        <div class="block bg-gray-100 hover:bg-gray-200 rounded-lg shadow-md cursor-pointer transition duration-300 ease-in-out transform hover:-translate-y-1">
            @if (isset($newsItem['image']))
                <div class="relative overflow-hidden rounded-t-lg">
                    <img src="{{ $newsItem['image'] }}" alt="{{ $newsItem['title'] }}"
                        class="w-full h-64 object-cover">
                    <div class="absolute inset-0 bg-gray-900 opacity-25"></div>
                </div>
                <div class="p-6 flex flex-col justify-between">
                    <div class="overflow-hidden">
                        <h2 class="text-xl font-semibold mb-2">{{ $newsItem['title'] }}</h2>
                        <p class="text-gray-700 line-clamp-3">{!! $newsItem['content'] !!}</p>
                    </div>
                    <p class="text-gray-600 mt-2 text-right">{{ $newsItem['created_at']->format('d.m.Y') }}</p>
                </div>
            @else
                <div class="p-6 flex flex-col justify-between">
                    <div class="overflow-hidden">
                        <h2 class="text-xl font-semibold mb-2">{{ $newsItem['title'] }}</h2>
                        <p class="text-gray-700">{{ Str::limit($newsItem['content'], 650) }}</p>
                    </div>
                    <p class="text-gray-600 mt-2 text-right">{{ $newsItem['created_at']->format('d.m.Y') }}</p>
                </div>
            @endif
        </div>
    </a>
</div>

{{-- WITH HIGHLIGHTED DATES --}}
{{-- <div>
    <a href="{{ route('news_detail', $newsItem['id']) }}">
        <div class="block bg-gray-100 hover:bg-gray-200 rounded-lg shadow-md cursor-pointer transition duration-300 ease-in-out transform hover:-translate-y-1">
            @if (isset($newsItem['image']))
                <div class="relative overflow-hidden rounded-t-lg">
                    <img src="{{ $newsItem['image'] }}" alt="{{ $newsItem['title'] }}"
                        class="w-full h-64 object-cover">
                    <div class="absolute inset-0 bg-gray-900 opacity-25"></div>
                </div>
                <div class="p-6 flex flex-col justify-between">
                    <div class="overflow-hidden">
                        <h2 class="text-xl font-semibold mb-2">{{ $newsItem['title'] }}</h2>
                        <p class="text-gray-700 line-clamp-3">{!! $newsItem['content'] !!}</p>
                    </div>
                    <div class="flex justify-end items-center mt-2">
                        <div class="bg-gray-900 rounded-full text-sm px-2 py-1 text-gray-200">
                            <p>{{ $newsItem['created_at']->format('d.m.Y') }}</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="p-6 flex flex-col justify-between">
                    <div class="overflow-hidden">
                        <h2 class="text-xl font-semibold mb-2">{{ $newsItem['title'] }}</h2>
                        <p class="text-gray-700">{{ Str::limit($newsItem['content'], 650) }}</p>
                    </div>
                    <div class="flex justify-end items-center mt-2">
                        <div class="bg-gray-900 rounded-full text-sm px-2 py-1 text-gray-200">
                            <p>{{ $newsItem['created_at']->format('d.m.Y') }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </a>
</div>
 --}}

<div>
    <a href="{{ route('news_detail', $item['id']) }}" class="group block h-full">
        <div class="h-full bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden flex flex-col">
            @if (isset($item['image']))
                <div class="relative overflow-hidden bg-gray-100 aspect-[16/7] flex-shrink-0">
                    <img src="{{ asset('storage/' . $item['image']) }}"
                         alt="{{ $item['title'] }}"
                         loading="lazy"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                </div>
            @endif
            <div class="p-5 xl:p-7 flex flex-col flex-grow">
                <h2 class="text-base xl:text-lg font-semibold text-gray-900 mb-2 leading-snug group-hover:text-amber-600 transition-colors duration-150">{{ $item['title'] }}</h2>
                <p class="text-sm xl:text-base text-gray-500 line-clamp-3 flex-grow">{{ Str::limit(strip_tags($item['content']), 180) }}</p>
                <p class="text-xs xl:text-sm text-gray-400 mt-3 font-medium">{{ $item['created_at']->format('d. m. Y') }}</p>
            </div>
        </div>
    </a>
</div>

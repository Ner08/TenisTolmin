<div class="container px-4 mx-auto pt-4 pb-10 md:py-10 xl:py-14 max-w-6xl xl:max-w-7xl 2xl:max-w-screen-2xl">
    @if ($home)
        <div class="mb-8" data-animate>
            <h2 class="text-2xl xl:text-3xl font-bold text-gray-900 mb-1">Dogodki</h2>
            <p class="text-gray-500 text-sm xl:text-base">Turnirji, pikniki, delovne akcije in skupinska druženja.</p>
        </div>
    @endif

    @if ($events->isEmpty())
        <x-empty model1="Dogodki" />
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($events as $event)
            <a href="{{ route('events_detail', $event['id']) }}" class="group block">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden flex">
                    <div class="bg-gray-900 text-white w-16 xl:w-20 flex-shrink-0 flex flex-col items-center justify-center py-4 xl:py-5">
                        <span class="text-2xl xl:text-3xl font-bold leading-none">{{ date('d', strtotime($event['fromDate'])) }}</span>
                        <span class="text-xs xl:text-sm uppercase tracking-wide text-gray-400 mt-1">{{ date('M', strtotime($event['fromDate'])) }}</span>
                    </div>
                    <div class="p-4 xl:p-5 min-w-0">
                        <h3 class="text-sm xl:text-base font-semibold text-gray-900 mb-1 truncate group-hover:text-amber-600 transition-colors duration-150">{{ $event['e_title'] }}</h3>
                        <p class="text-xs xl:text-sm text-gray-500">{{ date('H:i', strtotime($event['fromDate'])) }}
                            @if ($event['location'])
                                &middot; {{ $event['location'] }}
                            @endif
                        </p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    @if ($home)
        <div class="flex justify-center mt-8">
            <a href="{{ route('events') }}"
               class="bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold py-2.5 px-6 rounded-lg transition-colors duration-200">
                Vsi dogodki
            </a>
        </div>
    @else
        <div class="mt-8">{{ $events->links() }}</div>
    @endif
</div>

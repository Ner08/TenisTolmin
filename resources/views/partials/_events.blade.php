<div class="container px-2 mx-auto py-8">
    @if ($home)
        <h1 class="text-3xl font-bold mb-3">Dogodki</h1>
        <h4 class="text-lg text-gray-600 mb-8"> V našem koledarju teniških dogodkov se združujemo ne samo zaradi
            tekmovanj, ampak tudi zaradi druženja in zabave. Od piknikov do delovnih akcij, naši dogodki ponujajo
            priložnost za srečanje, povezovanje in uživanje ob skupnih interesih izven igrišča.</h4>
    @endif
    {{-- If no events show empty component --}}
    @if ($events->isEmpty())
        <x-empty model1="Dogodki" />
    @endif
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Event items -->
        @foreach ($events as $event)
            <div>
                <a href="{{ route('events_detail', $event['id']) }}">
                    <div
                        class="bg-gray-100 rounded-lg shadow-md overflow-hidden transition duration-300 ease-in-out transform hover:-translate-y-1 flex">
                        <div class="bg-gray-900 text-white w-16 flex justify-center items-center">
                            <img src="{{ asset('images/calandar.svg') }}" alt="Calendar Icon"
                                class="h-6 w-6 text-white" />
                        </div>
                        <div class="p-6">
                            <h2 class="text-xl font-semibold mb-4 text-gray-800">{{ $event['e_title'] }}</h2>
                            <div class="flex items-center">
                                <div class="bg-gray-900 text-white px-3 py-1 rounded-full mr-2">
                                    <span class="font-bold">{{ date('d.m.Y', strtotime($event['fromDate'])) }}</span>
                                    <span class="mx-1 text-gray-400">|</span>
                                    <span class="font-bold">{{ date('H:i', strtotime($event['fromDate'])) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    @if ($home)
        <div class="flex justify-center mt-12">
            <a href="{{ route('events') }}"
                class="bg-gray-900 hover:bg-gray-800 text-white text-lg font-bold py-2 px-6 rounded-lg transition duration-300 ease-in-out transform hover:-translate-y-1">
                Več dogodkov
            </a>
        </div>
    @else
        <div class="mt-8">{{ $events->links() }}</div>
    @endif
</div>

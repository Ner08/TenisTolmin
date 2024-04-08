<div class="container mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold mb-8">Lige in Turnirji</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($leagues as $league)
            <a href="{{ route('league', $league->id) }}" class="bg-gray-100 hover:bg-gray-200 cursor-pointer rounded-lg shadow-md overflow-hidden transition duration-300 ease-in-out transform hover:-translate-y-1">
                <div class="flex flex-col h-full">
                    <div class="p-6 pb-3 flex-grow">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800">{{ $league->name }}</h3>
                        <p class="text-gray-600 mb-6">{{ $league->description }}</p>
                    </div>
                    <div class="py-3 px-6 flex justify-between items-center text-gray-300 bg-gray-900">
                        <div>
                            <p class="flex items-center">
                                <img src="/images/from.svg" class="w-4 h-4 mr-2" alt="From Icon">
                                <span class="text-sm font-medium">
                                    {{ \Carbon\Carbon::parse($league->start_date)->format('d.m.Y') }}</span>
                            </p>
                        </div>
                        @if ($league->end_date)
                            <div class="ml-auto">
                                <p class="flex items-center">
                                    <img src="/images/to.svg" class="w-4 h-4 mr-2" alt="To Icon">
                                    <span class="text-sm font-medium">
                                        {{ \Carbon\Carbon::parse($league->end_date)->format('d.m.Y') }}</span>
                                </p>
                            </div>
                        @else
                            <div class="ml-auto">
                                <p class="flex items-center">
                                    <img src="/images/to.svg" class="w-4 h-4 mr-2" alt="To Icon">
                                    <span class="text-sm font-medium">Ni določen</span>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    <div class="flex justify-center mt-12 gap-2">
        <a href="{{ route('leagues') }}"
            class="bg-gray-900 hover:bg-gray-800 text-white text-lg font-bold py-2 px-6 rounded-lg transition duration-300 ease-in-out transform hover:-translate-y-1">
            Več Lig in Turnirjev
        </a>
        <a href="{{ route('scoreboard') }}"
            class="bg-gray-900 hover:bg-gray-800 text-white text-lg font-bold py-2 px-6 rounded-lg transition duration-300 ease-in-out transform hover:-translate-y-1">
            Tminska ATP lestvica
        </a>
    </div>
</div>

<x-layout :login="$login">
    <x-title title="Tminska ATP lestvica"/>
    <div class="bg-gray-100 p-6 rounded-lg shadow-md">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                // Sort players by points in descending order
                usort($players, function($a, $b) {
                    return $b['points'] <=> $a['points'];
                });
                $maxPoints = max(array_column($players, 'points'));
            @endphp
            @foreach ($players as $key => $player)
                <div class="bg-white rounded-md shadow-md overflow-hidden flex">
                    <div @class([
                        'bg-yellow-300' => ($key + 1) === 1,
                        'bg-slate-400' => ($key + 1) === 2,
                        'bg-amber-800' => ($key + 1) === 3,
                        'bg-gray-200' => ($key + 1) !== 1 && ($key + 1) !== 2 && ($key + 1) !== 3,
                        'text-center',
                        'w-16',
                        'flex',
                        'justify-center',
                        'items-center'
                    ])>
                        <span class="text-2xl font-semibold">{{ $key + 1 }}</span>
                    </div>
                    <div class="flex-grow p-6">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-lg font-semibold">{{ $player['name'] }}</span>
                            <span class="bg-gray-200 text-sm text-center px-3 py-1 rounded-full">{{ $player['points'] }} točk</span>
                        </div>
                        <div class="bg-gray-200 h-2 rounded-full mb-4">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: {{ ($player['points'] / $maxPoints) * 100 }}%;"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layout>

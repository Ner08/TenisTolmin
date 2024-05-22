<x-layout>
    @title('Tminska ATP lestvica - Tenis Tolmin')
    <x-title title="Tminska ATP lestvica" />
    @php
         $maxPoints = $maxPoints > 0 ? $maxPoints : 100;
    @endphp
    @if ($players->isEmpty())
        <x-empty model1="Rezultati" />
    @else
        <div class="bg-gray-100 p-6 rounded-lg ">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($players as $key => $player)
                    @php
                        $ranking = $player->ranking();
                    @endphp
                    <div class="bg-white rounded-md shadow-md overflow-hidden flex">
                        <div @class([
                            'bg-[#ffc60a]' => $ranking === 1,
                            'bg-[#C0C0C0]' => $ranking === 2,
                            'bg-[#B9732D]' => $ranking === 3,
                            'bg-gray-200' => $ranking !== 1 && $ranking !== 2 && $ranking !== 3,
                            'text-center',
                            'w-16',
                            'flex',
                            'justify-center',
                            'items-center',
                        ])>
                            <span class="text-2xl font-semibold">{{ $ranking }}</span>
                        </div>
                        <div class="flex-grow p-6">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-lg font-semibold">{{ $player->p_name }}</span>
                                <span
                                    class="bg-gray-200 text-sm text-center px-3 py-1 rounded-full">{{ $player->points }}
                                    točk</span>
                            </div>
                            <div class="bg-gray-200 h-2 rounded-full mb-4">
                                <div class="bg-blue-500 h-2 rounded-full"
                                    style="width: {{ ($player->points / $maxPoints) * 100 }}%;"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</x-layout>

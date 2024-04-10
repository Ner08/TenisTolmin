@foreach ($brackets as $bracket)
    @php
        $lastRound = $bracket->matchUps->max('round');
        $roundTitles = [
            1 => ['1.Kolo'],
            2 => ['1.Kolo', '2.Kolo'],
            3 => ['1.Kolo', '2.Kolo', '3.Kolo'],
            4 => ['1.Kolo', '2.Kolo', '3.Kolo', '4.Kolo'],
            5 => ['1.Kolo', '2.Kolo', '3.Kolo', '4.Kolo', '5.Kolo'],
            6 => ['1.Kolo', '2.Kolo', '3.Kolo', '4.Kolo', '5.Kolo', '6.Kolo'],
            7 => ['1.Kolo', '2.Kolo', '3.Kolo', '4.Kolo', '5.Kolo', '6.Kolo', '7.Kolo'],
            8 => ['1.Kolo', '2.Kolo', '3.Kolo', '4.Kolo', '5.Kolo', '6.Kolo', '7.Kolo', '8.Kolo'],
            9 => ['1.Kolo', '2.Kolo', '3.Kolo', '4.Kolo', '5.Kolo', '6.Kolo', '7.Kolo', '7.Kolo', '9.Kolo'],
        ];
    @endphp

    <div class="p-4 pl-12 bg-gray-300">
        <h2 class="text-gray-900 font-bold text-2xl">{{ $bracket->name }}</h2>
    </div>

    {{-- Table of points in group --}}

    <div class="overflow-x-auto border-gray-100 border-8 ">
        <table class="w-full bg-white shadow-md  overflow-hidden divide-y divide-gray-200 pb-4">
            <thead class="bg-gray-50 ">
                <tr>
                    <th scope="col"
                        class="px-2 sm:px-3 py-1 sm:py-3 text-center text-sm sm:text-base font-semibold text-gray-700 uppercase tracking-wider">
                        Ime
                    </th>
                    <th scope="col"
                        class="px-2 sm:px-3 py-1 sm:py-3 text-center text-sm sm:text-base font-semibold text-gray-700 uppercase tracking-wider">
                        Št. Tekem
                    </th>
                    <th scope="col"
                        class="px-2 sm:px-3 py-1 sm:py-3 text-center text-sm sm:text-base font-semibold text-gray-700 uppercase tracking-wider">
                        D/I Seti
                    </th>
                    <th scope="col"
                        class="px-2 sm:px-3 py-1 sm:py-3 text-center text-sm sm:text-base font-semibold text-gray-700 uppercase tracking-wider">
                        D/I Gemi
                    </th>
                    <th scope="col"
                        class="px-2 sm:px-3 py-1 sm:py-3 text-center text-sm sm:text-base font-semibold text-gray-700 uppercase tracking-wider">
                        točke
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @php
                    $players = [1,2,3,4,5];
                @endphp
                @foreach($players as $player)
                <tr class="hover:bg-gray-100">
                    <td class="px-2 sm:px-3 py-2 sm:py-4 whitespace-nowrap text-center">
                        {{-- {{ $player->name }} --}} Nejc Robič
                    </td>
                    <td class="px-2 sm:px-3 py-2 sm:py-4 whitespace-nowrap text-center">
                        {{-- {{ $player->matches_played }} --}} 5
                    </td>
                    <td class="px-2 sm:px-3 py-2 sm:py-4 whitespace-nowrap text-center">
                        {{-- {{ $player->delta_sets }} --}} 12
                    </td>
                    <td class="px-2 sm:px-3 py-2 sm:py-4 whitespace-nowrap text-center">
                        {{-- {{ $player->delta_games }} --}} -23
                    </td>
                    <td class="px-2 sm:px-3 py-2 sm:py-4 whitespace-nowrap text-center">
                        {{-- {{ $player->points }} --}} 29
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    @foreach ($bracket->matchUps->sortBy('round')->groupBy('round') as $key => $match)
        <div class="p-2 pl-12 w-full bg-gray-200">
            <h2 class="text-gray-900 font-bold text-lg">{{ $roundTitles[$lastRound][$key - 1] }}</h2>
        </div>
        <div class="grid grid-cols-1 gap-1 my-5">
            @foreach ($bracket->matchUps->where('round', $key) as $match)
                <div class="bg-gray-100 rounded-md overflow-hidden shadow-md mx-4">
                    <div class="bg-gray-200 p-4 grid grid-cols-2 gap-4">
                        @php
                            $team1 = App\Models\Team::find($match->team1_id);
                            $team2 = App\Models\Team::find($match->team2_id);
                            $p1_name = $team1 ? $team1->name ?? $team1->p1_name : '';
                            $p2_name = $team2 ? $team2->name ?? $team2->p1_name : '';
                            $p1_score = $team1 ? $team1->team_score ?? $team1->p1_score : '';
                            $p2_score = $team2 ? $team2->team_score ?? $team2->p1_score : '';
                            $p1_sets_won = $match->t1_sets_won;
                            $p2_sets_won = $match->t2_sets_won;
                        @endphp
                        <div class="text-center border-r border-gray-400 pr-4 flex flex-col justify-center items-center">
                            <p class="font-semibold mb-2">{{ $p1_name }} <span class="text-blue-500">({{ $p1_score }})</span></p>
                            @if (isset($match->t1_sets_won))
                                <div class="flex items-center justify-center">
                                    <div @class([
                                        'text-white' => isset($match->winner),
                                        'px-4',
                                        'py-2',
                                        'rounded-full',
                                        'bg-green-600' => isset($match->winner) && $match->winner,
                                        'bg-red-600' => isset($match->winner) && !$match->winner,
                                        'font-semibold',
                                        'text-gray-100' => isset($match->winner),
                                    ])>
                                        <p>{{ $match->t1_sets_won }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="text-center pl-4 flex flex-col justify-center items-center">
                            <p class="font-semibold mb-2">{{ $p2_name }} <span class="text-blue-500">({{ $p2_score }})</span></p>
                            @if (isset($match->t2_sets_won))
                                <div class="flex items-center justify-center">
                                    <div @class([
                                        'text-white' => isset($match->winner),
                                        'px-4',
                                        'py-2',
                                        'rounded-full',
                                        'bg-green-600' => isset($match->winner) && !$match->winner,
                                        'bg-red-600' => isset($match->winner) && $match->winner,
                                        'font-semibold',
                                        'text-gray-100' => isset($match->winner),
                                    ])>
                                        <p>{{ $match->t2_sets_won }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @if (isset($match->endResult))
                        <div
                            class="flex justify-center bg-gray-600 text-gray-200 rounded-b-md font-semibold items-center pb-1">
                            <p>{{ $match->endResult }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endforeach
@endforeach

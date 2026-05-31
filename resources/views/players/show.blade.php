<x-layout>
    @title($player->p_name . ' - Tenis Tolmin')

    <x-title :title="$player->p_name" back-route="scoreboard" back-label="Lestvica" />

    <section class="pt-4 pb-10 md:py-10 px-4">
        <div class="max-w-screen-2xl mx-auto space-y-4">

            {{-- Header card --}}
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                <div class="bg-gray-900 px-6 py-5 flex items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ $player->p_name }}</h1>
                        <p class="text-gray-400 text-sm mt-0.5">{{ $player->points }} točk</p>
                    </div>
                    <div @class([
                        'flex flex-col items-center justify-center w-16 h-16 rounded-full flex-shrink-0',
                        'bg-amber-400' => $player->ranking() === 1,
                        'bg-gray-300'  => $player->ranking() === 2,
                        'bg-amber-700' => $player->ranking() === 3,
                        'bg-gray-700'  => $player->ranking() > 3,
                    ])>
                        @if ($player->ranking() === 1)
                            <svg class="w-4 h-4 text-amber-800 mb-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endif
                        <span class="text-xl font-bold {{ $player->ranking() <= 3 ? 'text-gray-900' : 'text-white' }}">#{{ $player->ranking() }}</span>
                    </div>
                </div>

                {{-- Tabs --}}
                <div class="flex border-b border-gray-100">
                    <button id="tab-singles" onclick="switchPlayerTab('singles')"
                        class="player-tab flex-1 py-3 text-sm font-semibold transition-colors">
                        Posamično
                    </button>
                    <button id="tab-doubles" onclick="switchPlayerTab('doubles')"
                        class="player-tab flex-1 py-3 text-sm font-semibold transition-colors">
                        Dvojice
                    </button>
                </div>

                {{-- Singles panel --}}
                <div id="panel-singles">
                    @include('players._stats_panel', [
                        'stats'   => $singles,
                        'history' => $singlesHistory,
                        'tabId'   => 'singles',
                    ])
                </div>

                {{-- Doubles panel --}}
                <div id="panel-doubles" class="hidden">
                    @include('players._stats_panel', [
                        'stats'   => $doubles,
                        'history' => $doublesHistory,
                        'tabId'   => 'doubles',
                    ])
                </div>
            </div>

        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.color = '#6b7280';

    function buildCharts(tabId, wins, losses, leagueLabels, leagueWins, leagueLosses, rollingForm) {
        var donutEl = document.getElementById('chartDonut_' + tabId);
        var leagueEl = document.getElementById('chartLeague_' + tabId);
        var formEl = document.getElementById('chartForm_' + tabId);

        if (donutEl) new Chart(donutEl, {
            type: 'doughnut',
            data: { labels: ['Zmage','Porazi'], datasets: [{ data: [wins, losses], backgroundColor: ['#22c55e','#f87171'], borderWidth: 0, hoverOffset: 4 }] },
            options: { cutout: '72%', plugins: { legend: { display: false }, tooltip: { callbacks: { label: ctx => ' ' + ctx.label + ': ' + ctx.raw }}}, animation: { animateScale: true }}
        });

        if (leagueEl) new Chart(leagueEl, {
            type: 'bar',
            data: { labels: leagueLabels, datasets: [
                { label: 'Zmage',  data: leagueWins,   backgroundColor: '#22c55e', borderRadius: 4, barPercentage: 0.6 },
                { label: 'Porazi', data: leagueLosses, backgroundColor: '#f87171', borderRadius: 4, barPercentage: 0.6 },
            ]},
            options: { responsive: true, maintainAspectRatio: false,
                plugins: { legend: { position: 'top', labels: { boxWidth: 12, padding: 10 }}},
                scales: { x: { grid: { display: false }, ticks: { maxRotation: 30 }}, y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f3f4f6' }}}
            }
        });

        if (formEl && rollingForm.length > 1) new Chart(formEl, {
            type: 'line',
            data: { labels: rollingForm.map((_,i) => 'T'+(i+1)), datasets: [{
                label: 'Uspešnost %', data: rollingForm,
                borderColor: '#f59e0b', backgroundColor: 'rgba(245,158,11,0.08)',
                borderWidth: 2, pointRadius: 3, pointBackgroundColor: '#f59e0b', fill: true, tension: 0.3,
            }]},
            options: { responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false }},
                scales: { x: { grid: { display: false }}, y: { min: 0, max: 100, ticks: { callback: v => v+'%' }, grid: { color: '#f3f4f6' }}}
            }
        });
    }

    @php
        $sData = $singles;
        $dData = $doubles;
    @endphp

    buildCharts('singles',
        {{ $sData['wins'] }}, {{ $sData['losses'] }},
        @json(array_keys($sData['leagueStats'])),
        @json(array_column(array_values($sData['leagueStats']), 'wins')),
        @json(array_column(array_values($sData['leagueStats']), 'losses')),
        @json($sData['rollingForm'])
    );

    buildCharts('doubles',
        {{ $dData['wins'] }}, {{ $dData['losses'] }},
        @json(array_keys($dData['leagueStats'])),
        @json(array_column(array_values($dData['leagueStats']), 'wins')),
        @json(array_column(array_values($dData['leagueStats']), 'losses')),
        @json($dData['rollingForm'])
    );

    function switchPlayerTab(tab) {
        ['singles','doubles'].forEach(function(t) {
            var btn   = document.getElementById('tab-' + t);
            var panel = document.getElementById('panel-' + t);
            var active = t === tab;
            panel.classList.toggle('hidden', !active);
            btn.classList.toggle('text-amber-600',   active);
            btn.classList.toggle('border-b-2',       active);
            btn.classList.toggle('border-amber-500', active);
            btn.classList.toggle('text-gray-500',    !active);
        });
    }
    switchPlayerTab('singles');
    </script>
</x-layout>

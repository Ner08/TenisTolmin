<x-layout :login="$login" :admin="$admin">
    <x-admin-title-simple :title="'Liga / Turnir • ' . $bracket->league->name" />
    <x-title :title="'Skupina • ' . $bracket->name" />
        @php
            $lastRound = $bracket->matchUps->max('round') ?? 10;
            $roundTitles = [
                1 => ['Finale'],
                2 => ['Polfinale', 'Finale'],
                3 => ['Četrtfinale', 'Polfinale', 'Finale'],
                4 => ['Osminafinala', 'Četrtfinale', 'Polfinale', 'Finale'],
                5 => ['1.Krog', 'Osminafinala', 'Četrtfinale', 'Polfinale', 'Finale'],
                6 => ['1.Krog', '2.Krog', 'Osminafinala', 'Četrtfinale', 'Polfinale', 'Finale'],
                7 => ['1.Krog', '2.Krog', '3.Krog', 'Osminafinala', 'Četrtfinale', 'Polfinale', 'Finale'],
                8 => [
                    '1.Krog',
                    '2.Krog',
                    '3.Krog',
                    '4.Krog',
                    '5.Krog',
                    'Osminafinala',
                    'Četrtfinale',
                    'Polfinale',
                    'Finale',
                ],
                9 => [
                    '1.Krog',
                    '2.Krog',
                    '3.Krog',
                    '4.Krog',
                    '5.Krog',
                    '6.Krog',
                    'Osminafinala',
                    'Četrtfinale',
                    'Polfinale',
                    'Finale',
                ],
                10 => ['Tekme še niso določene.'],
            ];

            // Calculate the width of each column
            $colWidth = 12 / $lastRound; // Divide 12 (the number of columns in Bootstrap grid system) by the total number of rounds
        @endphp

        @if ($bracket->is_group_stage)
            @include('partials._admin_league_group_stage', ['bracket' => $bracket])
        @else
            @include('partials._admin_league', ['bracket' => $bracket])
        @endif
</x-layout>

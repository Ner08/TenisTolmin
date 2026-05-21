<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'e_title' => 'Klubski turnir – poletje 2024',
                'e_description' => 'Letni klubski turnir za vse člane. Prijave so odprte do 25. junija. Turnir bo potekal v knock-out sistemu z skupinsko fazo.',
                'fromDate' => '2024-06-29 09:00:00',
                'toDate' => '2024-06-30 18:00:00',
                'location' => 'TC Tolmin, igrišča 1–3',
                'e_home_page' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'e_title' => 'Skupinska vadba – začetniki',
                'e_description' => 'Skupinska vadba za začetnike. Priporočamo udobno sportno opremo in lastni lopar.',
                'fromDate' => '2024-06-05 18:00:00',
                'toDate' => '2024-06-05 19:30:00',
                'location' => 'TC Tolmin, igrišče 4',
                'e_home_page' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'e_title' => 'Zaključek sezone 2024 – piknik',
                'e_description' => 'Vabimo vse člane na zaključni piknik ob koncu sezone. Zagotovljeno je pijača in hrana, poskrbite za dobro voljo!',
                'fromDate' => '2024-09-14 15:00:00',
                'toDate' => '2024-09-14 20:00:00',
                'location' => 'Park ob Soči, Tolmin',
                'e_home_page' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'e_title' => 'Zimska liga – uvodna sestanek',
                'e_description' => 'Sestanek za vse prijavljene v zimsko ligo. Razdelili bomo razpored tekem in razložili pravila.',
                'fromDate' => '2024-10-01 19:00:00',
                'toDate' => null,
                'location' => 'Klubska prostorija, TC Tolmin',
                'e_home_page' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'e_title' => 'Otroški teniški dan',
                'e_description' => 'Brezplačen dan tenisa za otroke med 6 in 14 letom. Zagotovljeni lopati in žogice za začetnike.',
                'fromDate' => '2024-07-13 10:00:00',
                'toDate' => '2024-07-13 13:00:00',
                'location' => 'TC Tolmin, vsa igrišča',
                'e_home_page' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('events')->insert($events);
    }
}

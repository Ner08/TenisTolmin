<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $news = [
            [
                'title' => 'Začetek poletne sezone 2024',
                'content' => 'Spoštovani člani, z veseljem vas obveščamo, da se poletna sezona 2024 uradno začne 1. junija. Igrišča bodo odprta vsak dan od 8:00 do 21:00. Vabljeni k igranju in uživanju v lepem vremenu!',
                'image' => null,
                'created_at' => '2024-05-20 10:00:00',
                'updated_at' => '2024-05-20 10:00:00',
            ],
            [
                'title' => 'Rezultati klubskega turnirja – april 2024',
                'content' => 'Zaključil se je klubski turnir za april 2024. Čestitamo vsem udeležencem! V moški kategoriji je zmagal Luka Peršič, v ženski pa Nina Zorman. Zahvaljujemo se vsem za fair play in odlično vzdušje.',
                'image' => null,
                'created_at' => '2024-04-28 14:00:00',
                'updated_at' => '2024-04-28 14:00:00',
            ],
            [
                'title' => 'Novo: jutranje vadbe vsako sredo',
                'content' => 'Od maja dalje organiziramo jutranje skupinske vadbe vsako sredo ob 7:30. Vadbe so primerne za vse ravni znanja. Prijave sprejemamo po elektronski pošti ali osebno pri recepciji.',
                'image' => null,
                'created_at' => '2024-04-15 09:00:00',
                'updated_at' => '2024-04-15 09:00:00',
            ],
            [
                'title' => 'Obnova igrišča št. 2',
                'content' => 'Obveščamo vas, da bo igrišče št. 2 zaprto med 10. in 17. aprilom zaradi obnove podlage. Zahvaljujemo se za razumevanje. Ostala igrišča ostajajo odprta.',
                'image' => null,
                'created_at' => '2024-04-08 11:00:00',
                'updated_at' => '2024-04-08 11:00:00',
            ],
        ];

        foreach ($news as $item) {
            $newsId = DB::table('news')->insertGetId($item);

            DB::table('news_comments')->insert([
                'news_id' => $newsId,
                'user_id' => 2,
                'comment_id' => null,
                'content' => 'Odlična novica, veselimo se!',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

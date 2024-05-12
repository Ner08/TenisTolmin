<x-layout>

    <style>
        /* Custom CSS to add margin on the x-axis */
        .container-padding {
            padding: 30px 0 10px 10px;
            /* Add padding to the left and right sides */
        }
    </style>

    <section class="container mx-auto py-8 flex flex-wrap container-padding">
        <div class="w-full lg:w-1/2 lg:pr-4 mb-8">
            <h1 class="text-3xl font-bold mb-4">Članstvo</h1>

            <!-- Left side content -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-2">Članstvo v klubu</h2>
                <p class="mb-4">Članstvo v klubu se pridobi s prijavo (prošnjo za včlanitev) in plačilom članarine.</p>
                <p>Za članstvo, plačilo članarine ter pridobitev paketa za rezervacijo igrišč se obrnite na <b>go. Janjo
                        Lesjak</b></p>
                <p class="mt-2">Kontakt: <b>j.lesjak555@gmail.com</b></p>
            </div>

            <!-- Left side content -->
            <div class="mb-8 bg-yellow-200 rounded-2xl p-3">
                <h2 class="text-xl font-semibold mb-2">Članarina 2022</h2>
                <ul class="list-disc list-inside mb-4">
                    <li>Za odrasle <b>70,00 EUR</b></li>
                    <li>Za starejše od 65 let <b>50,00 EUR</b></li>
                    <li>Za otroke, dijake in študente (ob preložitvi potrdila o vpisu) <b>35,00 EUR</b></li>
                    <li>Za družine <b>160,00 EUR</b></li>
                </ul>
                <p class="mb-4">Podatki za plačilo:</p>
                <p>Transakcijski računi št.: <b>SI56 0475 3000 0388 292</b> (Nova KBM d.d.)</p>
                <p>Sklic: <b>SI00 2022</b></p>
                <p>Namen plačila: <b>Članarina 2022</b></p>
                <p>Prejemnik: <b>TENIŠKI KLUB TOLMIN, Dijaška ulica 12 c, 5220 Tolmin</b></p>
            </div>

            <!-- Left side content -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-2">Statut</h2>
                <p class="mb-4">Statut je temeljni pravni akt društva, s katerim se mora seznaniti vsak član, saj
                    ureja razmerja med člani, upravljanje kluba, premoženjske zadeve, pa tudi spremembe ter prenehanje
                    društva oziroma kluba.</p>
                <a href=""
                    class="bg-gray-900 hover:bg-gray-700 text-white text-l font-bold py-2 px-5 rounded text-center"><b>Statut</b></a>
                {{-- TODO link ne deluje --}}
            </div>
        </div>

        <div class="w-full lg:w-1/2 lg:pl-4 mb-8">
            <!-- Right side content -->
            <div class="mb-8 p-4 bg-blue-200 rounded-2xl">
                <h2 class="text-xl font-semibold mb-2">Pravila uporabe igrišč</h2>
                <p>Pravila uporabe igrišče so tehnično navodilo članom in drugim uporabnikom, kako ravnati in se
                    obnašati na igriščih.</p>
                <p>Društvo ni lastnik igrišč, ampak le njihov uporabnik in vzdrževalec. Za pravilno rabo društvo
                    odgovarja lastniku, Zavodu za šport Občine Tolmin.</p>
                <p>Poznavanje pravil je nujno, saj njihovo upoštevanje omogoča dolgotrajno rabo igrišč v korist vseh.
                </p>
                <ul class="list-disc list-inside mb-4">
                    <li>Igralec je pred pričetkom igranja dolžan poškropiti celotno površino igrišča, od robnika do
                        robnika.</li>
                    <li>Igralec zaključi z igro 5 minut pred koncem termina in do konca termina uredi igrišče (poravna
                        vse luknje ali kakršnekoli poškodbe, ki so nastale med igranjem) tako, da ga poravna z vlečko,
                        po potrebi pa tudi z ravnilom.</li>
                    <li>Po dežju je igranje na igriščih prepovedano, dokler se igrišče ne izsuši do ustrezne trdnosti
                        podlage.</li>
                </ul>
                <p><b>Pomembno!</b></p>
                <p>Skladno s Pravilnikom ima vsak član 3 bonuse, ko lahko igra tudi z zunanjim soigralcem (vpisuje se
                    kot »Zunanji Gost Bonus«).</p>
                <p>Preko tega mora nečlan plačati polovico igralnega termina po tarifi za zunanje goste.</p>
                <p class="mb-6">Teniški klub Tolmin bo v sezoni 2022 spremljal uporabljene bonuse za igranje z nečlani
                    in jih skladno s Pravilnikom po zaključeni sezoni tudi obračunal.</p>
                <a href=""
                    class="bg-gray-900 hover:bg-gray-700 text-white text-l font-bold py-2 px-5 rounded text-center"><b>Vsa
                        pravila</b></a> {{-- TODO link ne deluje --}}
            </div>



            <!-- Right side content -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-2">Urnik in rezervacije igrišč</h2>
                <!-- Right side content -->
                <p>.</p>

                <a href="https://tk-tolmin.sportifiq.com/" target="blank"
                    class="bg-gray-900 hover:bg-gray-700 text-white text-l font-bold py-2 px-5 rounded text-center">Spletna
                    stran za rezervacijo igrišč</a>
            </div>
        </div>
    </section>

</x-layout>

<x-layout :message="$message ?? null">
    @title('Članstvo - Tenis Tolmin')
    <style>
        /* Custom CSS to add margin on the x-axis */
        .container-padding {
            padding: 20px 20px 0px 20px;
            /* Add padding to the left and right sides */
        }

        .container-padding2 {
            padding: 0px 20px 10px 20px;
            /* Add padding to the left and right sides */
        }
    </style>
    <x-title title="Članstvo" />

    <section class="container mx-auto py-8 flex flex-wrap container-padding">
        <div class="w-full lg:w-1/2 lg:pr-4">
            <!-- Left side content -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2">Članstvo v klubu</h2>
                <p class="mb-4">Članstvo v klubu se pridobi s prijavo (prošnjo za včlanitev) in plačilom članarine.</p>
                <p>Za članstvo, plačilo članarine ter pridobitev paketa za rezervacijo igrišč se obrnite na <b>go. Janjo
                        Lesjak,</b> Ali pa izpolnite obrazec pod rubriko "včlanite se v teniški klub"


                    .</p>
                <p class="mt-2">Kontakt: <b>j.lesjak555@gmail.com</b></p>
            </div>

            <!-- Left side content -->
            <div class="bg-yellow-700 rounded-t-xl p-3 text-gray-100 shadow-md">
                <h2 class="text-xl font-bold text-center">Članarina {{ $membership->year }}</h2>
            </div>
            <div class="mb-6 bg-yellow-200 rounded-b-xl shadow-md p-4">
                <ul class="list-disc list-inside mb-4">
                    <li>Za odrasle <b class="text-yellow-900">{{ number_format($membership->price_adults, 2) }} EUR</b>
                    </li>
                    <li>Za starejše od 65 let <b
                            class="text-yellow-900">{{ number_format($membership->price_seniors, 2) }} EUR</b></li>
                    <li>Za dijake in študente (ob preložitvi potrdila o vpisu) <b
                            class="text-yellow-900">{{ number_format($membership->price_students, 2) }} EUR</b></li>
                    <li>Za otroke <b class="text-yellow-900">{{ number_format($membership->price_kids, 2) }} EUR</b>
                    </li>
                    <li>Za družine <b class="text-yellow-900">{{ number_format($membership->price_family, 2) }} EUR</b>
                    </li>
                </ul>
                <ul class="list-decimal list-inside mb-4">
                    <li>Vpisnina se zaračuna samo ob prvem vpisu v klub.</li>
                    <li>Družina obsega članstvo za dve odrasli osebi in otroke do dopolnjenega 26 leta starosti, če se
                        redno ali izredno šolajo in niso v rednem delovnem razmerju.</li>
                </ul>
                <p class="mb-1">Podatki za plačilo:</p>
                <p>Transakcijski računi št.: <b class="text-yellow-900">{{ $membership->trr }}</b></p>
                <p>Sklic: <b class="text-yellow-900">{{ $membership->sklic }}</b></p>
                <p>Namen plačila: <b class="text-yellow-900">{{ $membership->namen }}</b></p>
                <p>Prejemnik: <b class="text-yellow-900">{{ $membership->prejemnik }}</b></p>
            </div>

            {{-- <!-- Left side content -->
            <div class="mb-8">
                <a href=""
                    class="bg-gray-900 hover:bg-gray-700 text-white text-l font-bold py-2 px-5 rounded text-center"><b>Statut</b></a>

            </div> --}}
        </div>

        <div class="w-full lg:w-1/2 lg:pl-4 mb-2">
            <!-- Right side content -->
            <div class="bg-zinc-500 rounded-t-xl p-3 text-gray-100 shadow-md">
                <h2 class="text-xl font-bold text-center">Včlanite se v teniški klub</h2>
            </div>

            <form action="{{ route('membership_send_email') }}" method="POST"
                class="bg-gray-200 p-6 rounded-b-xl shadow-md mb-6">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Ime in preimek*</label>
                    <input type="text" id="name" name="name"
                        class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-500 focus:ring focus:ring-gray-200 focus:ring-opacity-50"
                        required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Elektronski naslov*</label>
                    <input type="email" id="email" name="email"
                        class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-500 focus:ring focus:ring-gray-200 focus:ring-opacity-50"
                        required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="telephone" class="block text-sm font-medium text-gray-700">Telefonska številka</label>
                    <input type="tel" id="telephone" name="telephone"
                        class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-500 focus:ring focus:ring-gray-200 focus:ring-opacity-50">
                    @error('telephone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Tip članarine*</label>
                    <div class="mt-1 space-y-2">
                        <div>
                            <input type="radio" id="adult" name="type" value="Odrasel" class="form-radio">
                            <label for="adult" class="ml-2">Odrasel</label>
                        </div>
                        <div>
                            <input type="radio" id="senior" name="type" value="Starejši od 65 let"
                                class="form-radio">
                            <label for="senior" class="ml-2">Starejši od 65 let</label>
                        </div>
                        <div>
                            <input type="radio" id="student" name="type" value="Dijak ali študent"
                                class="form-radio">
                            <label for="student" class="ml-2">Dijak ali študent</label>
                        </div>
                        <div>
                            <input type="radio" id="child" name="type" value="Otrok" class="form-radio">
                            <label for="child" class="ml-2">Otrok</label>
                        </div>
                        <div>
                            <input type="radio" id="family" name="type" value="Družina" class="form-radio">
                            <label for="family" class="ml-2">Družina</label>
                        </div>
                    </div>
                    @error('type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <p> <b>Informacija:</b> Po poslani prošnji vas bomo kontaktirali z nadaljnimi napotki.</p>
                </div>

                <div class="">
                    <button type="submit"
                        class="w-full px-4 py-2 bg-gray-600 text-white font-semibold rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Pošlji</button>
                </div>
            </form>
        </div>
    </section>

    <section class="container mx-auto py-8 container-padding2">

        <div class="bg-blue-900 rounded-t-xl p-2 text-gray-100 shadow-md">
            <h2 class="text-xl font-bold text-center">Pravila uporabe igrišč</h2>
        </div>
        <div class="mb-6 p-4 pb-6 bg-blue-200 rounded-b-xl shadow-md">
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
            <p><b class="text-blue-900">Pomembno!</b></p>
            <p>Skladno s Pravilnikom ima vsak član 3 bonuse, ko lahko igra tudi z zunanjim soigralcem (vpisuje se
                kot »Zunanji Gost Bonus«).</p>
            <p>Preko tega mora nečlan plačati polovico igralnega termina po tarifi za zunanje goste.</p>
            <p class="mb-6">Teniški klub Tolmin bo spremljal uporabljene bonuse za igranje z nečlani
                in jih skladno s Pravilnikom po zaključeni sezoni tudi obračunal.</p>
            <a href=""
                class="bg-blue-900 hover:bg-blue-950 text-white text-l font-bold py-2 px-5 rounded text-center"><b>Vsa
                    pravila</b></a>
        </div>

        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-2">Urnik in rezervacije igrišč</h2>
            <p class="mb-6"></p>
            <a href="https://tk-tolmin.sportifiq.com/" target="blank"
                class="bg-gray-900 hover:bg-gray-800 text-white text-l font-bold py-2 px-5 rounded text-center">Spletna
                stran za rezervacijo igrišč</a>
        </div>
    </section>
</x-layout>

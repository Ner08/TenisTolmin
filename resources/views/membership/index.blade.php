<x-layout :message="$message ?? null">
    @title('Članstvo - Tenis Tolmin')
    <x-title title="Članstvo" />

    <section class="py-10 px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- Left column --}}
                <div class="space-y-6">
                    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">Članstvo v klubu</h2>
                        <p class="text-gray-600 text-sm leading-relaxed mb-3">
                            Članstvo v klubu se pridobi s prijavo (prošnjo za včlanitev) in plačilom članarine.
                        </p>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Za članstvo, plačilo članarine ter pridobitev paketa za rezervacijo igrišč nas kontaktirajte
                            na elektronskem naslovu ali pa izpolnite obrazec poleg.
                        </p>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-sm text-gray-500">Kontakt: <a href="mailto:info@tenis-tolmin.si" class="text-amber-600 font-medium hover:underline">info@tenis-tolmin.si</a></p>
                        </div>
                    </div>

                    {{-- Membership pricing --}}
                    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                        <div class="bg-gray-900 px-5 py-3.5">
                            <h2 class="text-base font-semibold text-white">Članarina {{ $membership->year }}</h2>
                        </div>
                        <div class="p-5 space-y-2.5">
                            @foreach ([
                                ['Odrasli', $membership->price_adults],
                                ['Starejši od 65 let', $membership->price_seniors],
                                ['Dijaki in študenti', $membership->price_students],
                                ['Otroci', $membership->price_kids],
                                ['Družina', $membership->price_family],
                            ] as [$label, $price])
                                <div class="flex justify-between items-center py-2 border-b border-gray-50 last:border-0">
                                    <span class="text-sm text-gray-700">{{ $label }}</span>
                                    <span class="text-sm font-semibold text-amber-700">{{ number_format($price, 2) }} EUR</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="px-5 pb-5 space-y-1.5 text-sm text-gray-600">
                            <div class="pt-3 border-t border-gray-100 space-y-3">
                                <p>Transakcijski račun: <span class="font-medium text-gray-900">{{ $membership->trr }}</span></p>
                                <p>Sklic: <span class="font-medium text-gray-900">{{ $membership->sklic }}</span></p>
                                <p>Namen plačila: <span class="font-medium text-gray-900">{{ $membership->namen }}</span></p>
                                <p>Prejemnik: <span class="font-medium text-gray-900">{{ $membership->prejemnik }}</span></p>
                            </div>
                            <div class="pt-3 border-t border-gray-100 text-xs text-gray-400 space-y-1">
                                <p>Vpisnina se zaračuna samo ob prvem vpisu v klub.</p>
                                <p>Družina obsega dve odrasli osebi in otroke do 26. leta starosti, ki se šolajo in niso v delovnem razmerju.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right column - signup form --}}
                <div>
                    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                        <div class="bg-gray-900 px-5 py-3.5">
                            <h2 class="text-base font-semibold text-white">Včlanite se v teniški klub</h2>
                        </div>
                        <form action="{{ route('membership_send_email') }}" method="POST" class="p-5 space-y-4">
                            @csrf
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Ime in priimek *</label>
                                <input type="text" id="name" name="name"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                    required>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Elektronski naslov *</label>
                                <input type="email" id="email" name="email"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                    required>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1.5">Telefonska številka</label>
                                <input type="tel" id="telephone" name="telephone"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                @error('telephone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tip članarine *</label>
                                <div class="space-y-2">
                                    @foreach ([
                                        ['adult', 'Odrasel', 'Odrasel'],
                                        ['senior', 'Starejši od 65 let', 'Starejši od 65 let'],
                                        ['student', 'Dijak ali študent', 'Dijak ali študent'],
                                        ['child', 'Otrok', 'Otrok'],
                                        ['family', 'Družina', 'Družina'],
                                    ] as [$id, $label, $value])
                                        <label class="flex items-center gap-2.5 cursor-pointer group">
                                            <input type="radio" id="{{ $id }}" name="type" value="{{ $value }}"
                                                class="w-4 h-4 text-amber-500 border-gray-300 focus:ring-amber-500">
                                            <span class="text-sm text-gray-700">{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('type')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="bg-amber-50 border border-amber-100 rounded-lg px-4 py-3">
                                <p class="text-sm text-amber-800">Po poslani prošnji vas bomo kontaktirali z nadaljnimi napotki.</p>
                            </div>
                            <button type="submit"
                                class="w-full py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold rounded-lg transition-colors duration-150">
                                Pošlji prošnjo
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Court rules section --}}
    <section class="py-10 px-4 bg-gray-50 border-t border-gray-100">
        <div class="container mx-auto max-w-6xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                    <div class="bg-gray-900 px-5 py-3.5">
                        <h2 class="text-base font-semibold text-white">Pravila uporabe igrišč</h2>
                    </div>
                    <div class="p-5 text-sm text-gray-600 space-y-3">
                        <p>Pravila uporabe igrišč so tehnično navodilo članom in drugim uporabnikom, kako ravnati na igriščih.</p>
                        <p>Društvo ni lastnik igrišč, ampak le njihov uporabnik in vzdrževalec. Odgovarja lastniku, Zavodu za šport Občine Tolmin.</p>
                        <ul class="space-y-2 text-sm">
                            <li class="flex gap-2">
                                <span class="text-amber-500 mt-0.5 flex-shrink-0">•</span>
                                <span>Pred pričetkom igranja je dolžan poškropiti celotno površino igrišča.</span>
                            </li>
                            <li class="flex gap-2">
                                <span class="text-amber-500 mt-0.5 flex-shrink-0">•</span>
                                <span>Igro zaključi 5 minut pred koncem termina in uredi igrišče z vlečko.</span>
                            </li>
                            <li class="flex gap-2">
                                <span class="text-amber-500 mt-0.5 flex-shrink-0">•</span>
                                <span>Po dežju je igranje prepovedano, dokler se igrišče ne izsuši.</span>
                            </li>
                        </ul>
                        <div class="pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-500">Vsak član ima 3 bonuse za igranje z zunanjim soigralcem. Nečlan mora nato plačati polovico tarife za zunanje goste.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Urnik in rezervacije igrišč</h2>
                    <p class="text-sm text-gray-600 mb-5">Za rezervacijo teniškega igrišča se prijavite v sistem Sportifiq. Pogoj za rezervacijo je plačana članarina.</p>
                    <a href="https://tk-tolmin.sportifiq.com/" target="_blank"
                        class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold py-2.5 px-5 rounded-lg transition-colors duration-150">
                        Rezervacija igrišč
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>

            </div>
        </div>
    </section>

</x-layout>

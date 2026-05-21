<div class="container mx-auto py-10 px-4">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-1">Članstvo in rezervacije</h2>
        <p class="text-gray-500 text-sm">Postanite član in uživajte v ekskluzivnih ugodnostih ter dostop do ligaškega tekmovanja.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-base font-semibold text-gray-900 mb-2">Včlanite se</h3>
            <p class="text-gray-500 text-sm leading-relaxed mb-5">
                Postanite član, dostopajte do igrišč in se pridružite ligam. Pogoj za rezervacijo igrišč je plačana članarina.
            </p>
            <a href="{{ route('membership') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-gray-900 hover:text-amber-600 transition-colors">
                Več informacij
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <div class="bg-gray-900 rounded-xl p-6 shadow-sm">
            <h3 class="text-base font-semibold text-white mb-2">Rezervacije igrišč</h3>
            <p class="text-gray-400 text-sm leading-relaxed mb-5">
                Rezervirajte teniško igrišče prek sistema Sportifiq.
            </p>
            <a href="https://tk-tolmin.sportifiq.com/" target="_blank"
                class="inline-flex items-center gap-2 text-sm font-semibold text-amber-400 hover:text-amber-300 transition-colors">
                Odpri rezervacijski sistem
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
            </a>
        </div>
    </div>
</div>

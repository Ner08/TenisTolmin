<x-layout-login>
    @title('Pozabljeno geslo - Tenis Tolmin')

    <div class="min-h-[calc(100vh-56px)] flex items-center justify-center bg-gray-950 px-4 py-12">
        <div class="w-full max-w-sm">
            <div class="text-center mb-8">
                <img class="mx-auto h-14 w-auto mb-4" src="{{ asset('images/logo10.png') }}" alt="logo">
                <h2 class="text-2xl font-bold text-white">Pozabljeno geslo</h2>
                <p class="text-gray-400 text-sm mt-1">Teniški klub Tolmin</p>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl p-7 text-center space-y-4">
                <div class="w-12 h-12 rounded-full bg-amber-500/10 flex items-center justify-center mx-auto">
                    <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
                <p class="text-gray-300 text-sm leading-relaxed">
                    Kontaktirajte administratorja kluba. Administrator vam bo nastavil začasno geslo, ki ga boste po prijavi spremenili v
                    <strong class="text-white">Nastavitvah računa</strong>.
                </p>
                <a href="{{ route('contact') }}"
                   class="inline-block w-full py-2.5 px-4 bg-amber-500 hover:bg-amber-400 text-gray-900 font-semibold rounded-lg transition-colors text-sm">
                    Kontaktirajte nas
                </a>
            </div>

            <p class="text-center text-sm text-gray-500 mt-5">
                <a href="{{ route('login_view') }}" class="text-amber-400 hover:text-amber-300 font-medium">← Nazaj na prijavo</a>
            </p>
        </div>
    </div>
</x-layout-login>

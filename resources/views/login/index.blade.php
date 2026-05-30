<x-layout-login>
    @title('Prijava - Tenis Tolmin')

    <div class="min-h-[calc(100vh-56px)] flex items-center justify-center bg-gray-950 px-4 py-12">
        <div class="w-full max-w-sm">
            <div class="text-center mb-8">
                <img class="mx-auto h-14 w-auto mb-4" src="{{ asset('images/logo10.png') }}" alt="logo">
                <h2 class="text-2xl font-bold text-white">Prijavite se</h2>
                <p class="text-gray-400 text-sm mt-1">Teniški klub Tolmin</p>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl p-7">
                <form class="space-y-4" action="{{ route('authenticate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="remember" value="true">

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-1.5">Uporabniško ime / E-mail</label>
                        <input id="email" name="email" type="text" autocomplete="email" required
                            class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-colors"
                            placeholder="ime@primer.si">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-1.5">Geslo</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-colors"
                            placeholder="••••••••">
                    </div>

                    @error('email')
                        <div class="flex items-center gap-2 text-red-400 text-sm bg-red-950/50 border border-red-900 rounded-lg px-3 py-2">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror

                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input id="remember" name="remember" type="checkbox"
                                class="w-4 h-4 rounded border-gray-600 bg-gray-800 text-amber-500 focus:ring-amber-500"
                                {{ old('remember') ? 'checked' : '' }}>
                            <span class="text-sm text-gray-400">Zapomni si me</span>
                        </label>
                        <a href="{{ route('forgot-password') }}" class="text-sm text-gray-500 hover:text-amber-400 transition-colors">
                            Pozabljeno geslo?
                        </a>
                    </div>

                    <button type="submit"
                        class="w-full py-2.5 px-4 bg-amber-500 hover:bg-amber-400 text-gray-900 font-semibold rounded-lg transition-colors duration-150 mt-2">
                        Prijava
                    </button>
                </form>
            </div>

            <p class="text-center text-sm text-gray-500 mt-5">
                Nimate računa?
                <a href="{{ route('register') }}" class="text-amber-400 hover:text-amber-300 font-medium">Registracija</a>
            </p>
        </div>
    </div>

</x-layout-login>

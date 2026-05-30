<x-layout>
    @title('Nastavitve - Tenis Tolmin')

    <div class="bg-gray-50 py-10 px-4">
        <div class="max-w-lg mx-auto space-y-6">

            <h1 class="text-2xl font-bold text-gray-900">Nastavitve računa</h1>

            {{-- Profile --}}
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-900">Osebni podatki</h2>
                </div>
                <form action="{{ route('settings.profile') }}" method="POST" class="px-6 py-5 space-y-4">
                    @csrf
                    @if (session('profile_success'))
                        <div class="flex items-center gap-2 text-green-700 bg-green-50 border border-green-200 rounded-lg px-3 py-2 text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ session('profile_success') }}
                        </div>
                    @endif

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Ime in priimek</label>
                        <input type="text" name="name" required
                            value="{{ old('name', auth()->user()->name) }}"
                            class="w-full border border-gray-200 rounded-lg py-2.5 px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 @error('name') border-red-400 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">E-mail</label>
                        <input type="email" name="email" required
                            value="{{ old('email', auth()->user()->email) }}"
                            class="w-full border border-gray-200 rounded-lg py-2.5 px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 @error('email') border-red-400 @enderror">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                        Shrani spremembe
                    </button>
                </form>
            </div>

            {{-- Password --}}
            <div id="password" class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-900">Sprememba gesla</h2>
                </div>
                <form action="{{ route('settings.password') }}" method="POST" class="px-6 py-5 space-y-4">
                    @csrf
                    @if (session('password_success'))
                        <div class="flex items-center gap-2 text-green-700 bg-green-50 border border-green-200 rounded-lg px-3 py-2 text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ session('password_success') }}
                        </div>
                    @endif

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Trenutno geslo</label>
                        <input type="password" name="current_password" required autocomplete="current-password"
                            class="w-full border border-gray-200 rounded-lg py-2.5 px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 @error('current_password') border-red-400 @enderror">
                        @error('current_password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Novo geslo</label>
                        <input type="password" name="password" required autocomplete="new-password"
                            class="w-full border border-gray-200 rounded-lg py-2.5 px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 @error('password') border-red-400 @enderror">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Potrdi novo geslo</label>
                        <input type="password" name="password_confirmation" required autocomplete="new-password"
                            class="w-full border border-gray-200 rounded-lg py-2.5 px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>

                    <button type="submit"
                        class="bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                        Spremeni geslo
                    </button>
                </form>
            </div>

            {{-- Linked player --}}
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-900">Povezan igralec</h2>
                </div>
                <div class="px-6 py-5">
                    @if (auth()->user()->player)
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-amber-500/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->player->p_name }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">Vaš račun je povezan s tem igralcem v ligi.</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-3 text-gray-400">
                            <div class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Ni povezanega igralca</p>
                                <p class="text-xs text-gray-400 mt-0.5">Kontaktirajte administratorja za povezavo z igralcem.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-layout>

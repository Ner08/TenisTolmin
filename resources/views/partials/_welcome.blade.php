<section class="relative overflow-hidden bg-gray-900">
    {{-- Amber right block --}}
    <div x-data="{ loaded: false }" class="absolute top-0 right-0 bottom-0 w-1/2 bg-amber-500 hidden lg:flex items-center justify-center overflow-hidden">
        {{-- Shimmer sweep while loading --}}
        <div x-show="!loaded" class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute inset-0 -translate-x-full animate-[shimmer_1.5s_infinite]"
                 style="background:linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.25) 50%, transparent 100%)"></div>
        </div>
        <img src="{{ asset('images/tenis_player.svg') }}" alt="Tennis player"
             class="h-full w-auto object-contain mix-blend-multiply contrast-150 transition-opacity duration-700"
             :class="loaded ? 'opacity-100' : 'opacity-0'"
             @load="loaded = true">
    </div>

    <div class="relative container mx-auto px-4 py-16 md:py-20 max-w-5xl">
        <div class="lg:w-1/2 lg:pr-16">

            <span class="inline-block text-amber-500 text-xs font-bold uppercase tracking-widest mb-5">
                Teniški klub Tolmin
            </span>

            <h1 class="text-4xl md:text-5xl font-extrabold mb-6 leading-tight tracking-tight text-white">
                Pozdravljeni v<br class="hidden md:block"> TK Tolmin
            </h1>

            <div class="space-y-4 text-gray-400 text-base leading-relaxed mb-8">
                <p>
                    Teniški klub Tolmin je športno društvo, ki skrbi za teniško kulturo v našem idiličnem mestu.
                    Ustanovljeno je bilo leta 1981, neformalni začetki igranja tenisa pa segajo še dlje nazaj.
                </p>
                <p>
                    Društvo ima preko 80 članov vseh starosti, ki jih druži skupna strast do tenisa.
                    Odprto je za vse, pod enakimi pogoji in ob spoštovanju skupnih pravil.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('membership') }}"
                   class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-gray-900 font-bold px-5 py-2.5 rounded-lg transition-colors duration-200 text-sm">
                    Postani član
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
                <a href="{{ route('events') }}"
                   class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white font-semibold px-5 py-2.5 rounded-lg transition-colors duration-200 text-sm border border-white/20">
                    Dogodki
                </a>
            </div>

        </div>
    </div>
</section>

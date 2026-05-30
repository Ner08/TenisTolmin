<section class="relative overflow-hidden bg-gray-900">
    {{-- Amber right block --}}
    <div class="absolute top-0 right-0 bottom-0 w-1/2 bg-amber-500 hidden lg:flex items-center overflow-hidden">

        {{-- Clay dust particles --}}
        <div class="absolute bottom-0 left-0 w-full pointer-events-none select-none js-particles" aria-hidden="true"
             style="height: 55%;
                    background-image: url('{{ asset('images/particles.png') }}');
                    background-size: cover;
                    background-position: bottom center;
                    background-repeat: no-repeat;
                    opacity: 0;
                    mix-blend-mode: multiply;
                    transition: opacity 0.5s ease;">
        </div>

        {{-- Text --}}
        <div class="relative z-10 pl-10 xl:pl-16 2xl:pl-24 text-gray-900" data-animate style="transition-delay:150ms">
            <p class="text-xs xl:text-sm font-bold uppercase tracking-widest mb-4 opacity-60">Ustanovljeno 1981</p>
            <div class="space-y-0 mb-5">
                <p class="text-4xl xl:text-5xl 2xl:text-6xl font-black leading-tight">Igraj.</p>
                <p class="text-4xl xl:text-5xl 2xl:text-6xl font-black leading-tight">Tekmuj.</p>
                <p class="text-4xl xl:text-5xl 2xl:text-6xl font-black leading-tight">Napreduj.</p>
            </div>
            <div class="w-10 h-0.5 bg-gray-900 opacity-30 mb-5"></div>
            <div class="space-y-2">
                <div class="flex items-baseline gap-2">
                    <span class="text-xl xl:text-2xl 2xl:text-3xl font-extrabold">80+</span>
                    <span class="text-xs xl:text-sm font-medium opacity-60">aktivnih članov</span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-xl xl:text-2xl 2xl:text-3xl font-extrabold">45</span>
                    <span class="text-xs xl:text-sm font-medium opacity-60">let tradicije</span>
                </div>
            </div>
        </div>

    </div>

    <div class="relative container mx-auto px-4 py-8 md:py-20 xl:py-28 2xl:py-36 max-w-5xl xl:max-w-6xl 2xl:max-w-7xl">
        <div class="lg:w-1/2 lg:pr-16 xl:pr-20 2xl:pr-28" data-animate>

            <span class="inline-block text-amber-500 text-xs xl:text-sm font-bold uppercase tracking-widest mb-5">
                Teniški klub Tolmin
            </span>

            <h1 class="text-4xl md:text-5xl xl:text-6xl 2xl:text-7xl font-extrabold mb-6 leading-tight tracking-tight text-white">
                Pozdravljeni v<br class="hidden md:block"> TK Tolmin
            </h1>

            <div class="space-y-4 text-gray-400 text-base xl:text-lg 2xl:text-xl leading-relaxed mb-8">
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
                   class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-gray-900 font-bold px-5 xl:px-6 py-2.5 xl:py-3 rounded-lg transition-colors duration-200 text-sm xl:text-base">
                    Postani član
                    <svg class="w-4 h-4 xl:w-5 xl:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
                <a href="{{ route('events') }}"
                   class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white font-semibold px-5 xl:px-6 py-2.5 xl:py-3 rounded-lg transition-colors duration-200 text-sm xl:text-base border border-white/20">
                    Dogodki
                </a>
            </div>

        </div>
    </div>
</section>

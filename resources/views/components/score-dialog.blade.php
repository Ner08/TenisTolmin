<div id="scoreDialog" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeScoreDialog()"></div>
    <div class="relative flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 w-full max-w-sm">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-0.5">Vnos rezultata</p>
                    <h3 id="scoreDialogTitle" class="text-sm font-semibold text-gray-900 truncate"></h3>
                </div>
                <button onclick="closeScoreDialog()"
                    class="ml-4 flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="px-6 py-5">
                <div class="grid gap-x-3 gap-y-3 items-center" style="grid-template-columns: 3rem 1fr 1.25rem 1fr">
                    {{-- Team name headers --}}
                    <span></span>
                    <span id="scoreDialogT1" class="text-xs font-semibold text-gray-500 text-center truncate"></span>
                    <span></span>
                    <span id="scoreDialogT2" class="text-xs font-semibold text-gray-500 text-center truncate"></span>

                    {{-- Set rows --}}
                    @foreach ([['1. set', 'sdlg_t1s1', 'sdlg_t2s1', true], ['2. set', 'sdlg_t1s2', 'sdlg_t2s2', true], ['3. set', 'sdlg_t1s3', 'sdlg_t2s3', false]] as [$label, $f1, $f2, $req])
                        <span class="text-xs font-medium text-gray-400">{{ $label }}</span>
                        <input id="{{ $f1 }}" type="number" min="0" max="99" placeholder="0"
                            {{ $req ? 'required' : '' }}
                            class="border border-gray-200 rounded-lg px-2 py-2.5 text-sm font-semibold text-center w-full focus:outline-none focus:ring-2 focus:ring-amber-400 transition-colors">
                        <span class="text-center text-gray-400 font-bold">:</span>
                        <input id="{{ $f2 }}" type="number" min="0" max="99" placeholder="0"
                            {{ $req ? 'required' : '' }}
                            class="border border-gray-200 rounded-lg px-2 py-2.5 text-sm font-semibold text-center w-full focus:outline-none focus:ring-2 focus:ring-amber-400 transition-colors">
                    @endforeach
                </div>
            </div>

            <div class="px-6 pb-6 flex gap-3">
                <button onclick="submitScoreFromDialog()"
                    class="flex-1 bg-amber-600 text-white text-sm font-semibold px-4 py-2.5 rounded-xl hover:bg-amber-700 transition-colors">
                    Oddaj rezultat
                </button>
                <button onclick="closeScoreDialog()"
                    class="text-sm text-gray-600 px-4 py-2.5 rounded-xl hover:bg-gray-100 transition-colors">
                    Prekliči
                </button>
            </div>
        </div>
    </div>
</div>

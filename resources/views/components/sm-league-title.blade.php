<div id="league-title-bar" class="bg-gray-900 border-b border-gray-800 fixed top-14 left-0 right-0 z-40">
    <div class="max-w-screen-2xl mx-auto px-4 py-2.5 flex items-center gap-3">
        <a href="{{ route('leagues') }}"
           class="flex items-center gap-1.5 text-gray-400 hover:text-white transition-colors text-sm flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="hidden sm:inline">Lige</span>
        </a>
        <span class="text-gray-700 hidden sm:block">/</span>
        <h1 class="text-sm font-bold text-white flex-1 truncate min-w-0">{{ $data['name'] }}</h1>
        <div class="hidden sm:flex items-center gap-2 text-sm text-gray-400 flex-shrink-0">
            <span>{{ \Carbon\Carbon::parse($data['start_date'])->format('d.m.Y') }}</span>
            <span class="text-gray-600">&rarr;</span>
            <span>{{ $data['end_date'] ? \Carbon\Carbon::parse($data['end_date'])->format('d.m.Y') : 'Ni določen' }}</span>
        </div>
    </div>
</div>

<div class="bg-gray-900 border-b border-gray-800 sticky top-14 z-40">
    <div class="max-w-screen-2xl mx-auto px-4 py-3 flex items-center gap-3">
        <a href="{{ route('admin') }}"
           class="flex items-center gap-1.5 text-gray-400 hover:text-white transition-colors text-sm flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Admin
        </a>
        <span class="text-gray-700">/</span>
        <h1 class="text-lg font-bold text-white tracking-tight truncate">{{ $title }}</h1>
    </div>
</div>

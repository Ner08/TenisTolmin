<div class="bg-gray-800 cursor-pointer hover:bg-gray-750 transition-colors duration-150 group"
     onclick="toggleComponent('{{ $divId }}')">
    <div class="px-6 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-1 h-5 bg-amber-500 rounded-full"></div>
            <h2 class="text-sm font-semibold text-gray-200">{{ $title }}</h2>
        </div>
        <svg class="w-4 h-4 text-gray-500 group-hover:text-gray-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>
</div>

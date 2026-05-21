<div class="fixed inset-0 z-50 flex items-center justify-center px-4">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100 max-w-md w-full p-6">
        <div class="flex items-start gap-4 mb-5">
            <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-gray-800 font-medium pt-1.5">{{ session('message') }}</p>
        </div>
        @if (session()->has('route') && session()->has('model') && session()->has('flash'))
            <div class="flex gap-3 justify-end">
                <a href="#" onclick="refreshPage()"
                   class="px-5 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-150">Ne</a>
                <a href="{{ route(session('route'), [session('model') => session('flash')]) }}"
                   class="px-5 py-2 text-sm font-medium text-white bg-gray-900 hover:bg-gray-800 rounded-lg transition-colors duration-150">Da</a>
            </div>
        @else
            <div class="flex justify-end">
                <button type="button" onclick="refreshPage()"
                    class="px-5 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-150">Zapri</button>
            </div>
        @endif
    </div>
</div>

<script>
    function refreshPage() {
        location.reload();
    }
</script>

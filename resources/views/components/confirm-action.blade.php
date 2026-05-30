<div id="confirmActionDialog" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    <div class="relative flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 max-w-sm w-full p-6">
            <div class="flex items-start gap-4 mb-6">
                <div id="confirmActionIcon" class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                    </svg>
                </div>
                <div class="pt-1">
                    <h3 id="confirmActionTitle" class="text-base font-semibold text-gray-900">Ste prepričani?</h3>
                    <p id="confirmActionMessage" class="text-sm text-gray-500 mt-1"></p>
                </div>
            </div>
            <div class="flex gap-3 justify-end">
                <button onclick="hideConfirmAction()"
                    class="px-5 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-150">
                    Prekliči
                </button>
                <form id="confirmActionForm" action="" method="POST" class="inline">
                    @csrf
                    <button id="confirmActionBtn" type="submit"
                        class="px-5 py-2 text-sm font-medium text-white bg-amber-500 hover:bg-amber-600 rounded-lg transition-colors duration-150">
                        Potrdi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

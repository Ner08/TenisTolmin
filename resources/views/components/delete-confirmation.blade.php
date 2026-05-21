<!-- Delete Confirmation Dialog -->
<div id="deleteConfirmationDialog" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    <div class="relative flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 max-w-sm w-full p-6">
            <div class="flex items-start gap-4 mb-6">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <div class="pt-1">
                    <h3 class="text-base font-semibold text-gray-900">Ste prepričani?</h3>
                    <p class="text-sm text-gray-500 mt-1">Tega dejanja ni mogoče razveljaviti.</p>
                </div>
            </div>
            <div class="flex gap-3 justify-end">
                <button onclick="hideDeleteConfirmation()"
                    class="px-5 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-150">
                    Prekliči
                </button>
                <form id="confirmDeleteForm" action="" method="POST" class="inline">
                    @method('DELETE')
                    @csrf
                    <button type="submit"
                        class="px-5 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors duration-150">
                        Izbriši
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

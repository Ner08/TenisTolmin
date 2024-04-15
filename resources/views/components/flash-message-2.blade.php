<div x-data="{show: true}" x-init="setTimeout(()=> show = false, 3000)" x-show="show"
    class="fixed bottom-1 right-2 transform bg-gray-800 text-white p-8 py-4 rounded-lg shadow-2xl border-2 border-white">
    <p>{{ session('message') }}</p>
</div>

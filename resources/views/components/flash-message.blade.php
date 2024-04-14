<div
    class="fixed top-1/2 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white p-8 py-4 rounded-lg shadow-2xl border-2 border-white flash-message">
    <p>{{ session('message') }}</p>
    @if (session()->has('route') && session()->has('model') && session()->has('flash'))
        <div class="flex justify-center mt-4">
            <a href="{{ route( session('route'), [session('model') => session('flash')]) }}"
                class="bg-zinc-500 text-white px-5 py-2 rounded-lg hover:bg-zinc-600 focus:outline-none focus:bg-blue-600 transition duration-300 mr-4">Da</a>
            <a href="#" onclick="refreshPage()"
                class="bg-zinc-500 text-white px-5 py-2 rounded-lg hover:bg-zinc-600 focus:outline-none transition duration-300">Ne</a>
        </div>
    @else
        <button type="button"
            class="bg-zinc-500 text-white px-5 py-2 rounded-lg hover:bg-zinc-600 focus:outline-none transition duration-300">Zapri</button>
    @endif
</div>

<script>
    function refreshPage() {
        location.reload(); // Reload the current page
    }
</script>

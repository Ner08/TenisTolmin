<x-layout :login="$login">
    <x-title title="Vse Lige in Turnirji"/>
    {{-- Leagues --}}
    <section class="py-8 px-4">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Leagues items -->
                @foreach ($leagues as $league)
                    @include('partials._league_item')
                @endforeach
            </div>
        </div>
        <div class="flex justify-center mt-8">
            <a href="{{ route('leagues') }}"
                class="bg-gray-900 hover:bg-gray-800 text-white text-lg font-bold py-2 px-6 rounded-lg transition duration-300 ease-in-out transform hover:-translate-y-1">
                Več
            </a>
        </div>
    </section>
</x-layout>

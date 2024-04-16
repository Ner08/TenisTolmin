<x-layout :login="$login" :admin="$admin">

    <x-title title="Vse lige in turnirji"/>

    {{-- Leagues --}}

    <section class="py-8 px-4">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Leagues items -->
                @foreach ($leagues as $league)
                    @include('partials._league_item')
                @endforeach
            </div>
            <div class="mt-8">{{ $leagues->links() }}</div>
        </div>
    </section>

</x-layout>

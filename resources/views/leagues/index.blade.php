<x-layout>
    @title('Lige in turnirji - Tenis Tolmin')
    <x-title title="Vse lige in turnirji" />

    <section class="py-8 px-4">
        <div class="container mx-auto">
            @if ($leagues->isEmpty())
                <x-empty model1="Lige in turnirji" />
            @endif
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($leagues as $league)
                    @include('partials._league_item')
                @endforeach
            </div>
            <div class="mt-8">{{ $leagues->links() }}</div>
        </div>
    </section>

</x-layout>

<x-layout>

    @php
        $title = 'Dogodek - ' . $event->e_title;
        $titleTab = $title . ' - Tenis Tolmin';
    @endphp

    @title($titleTab)

    <x-title :title="$title"/>

    <div class="mx-auto">
        @include('partials._event')
    </div>

</x-layout>

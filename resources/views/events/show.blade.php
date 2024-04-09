<x-layout :login="$login">
    @php
        $title = 'Dogodek • ' . $event->title;
    @endphp
    <x-title :title="$title"/>
    <div class="mx-auto">
        @include('partials._event')
    </div>
</x-layout>

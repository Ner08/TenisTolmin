<x-layout :login="$login" :admin="$admin">
    @php
        $title = 'Dogodek • ' . $event->e_title;
    @endphp
    <x-title :title="$title"/>
    <div class="mx-auto">
        @include('partials._event')
    </div>
</x-layout>

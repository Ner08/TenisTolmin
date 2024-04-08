<x-layout :login="$login">
    <x-title title="Vsi Dogodki"/>
    @include('partials._events', ['home' => false])
</x-layout>

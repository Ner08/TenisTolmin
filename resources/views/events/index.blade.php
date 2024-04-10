<x-layout :login="$login" :admin="$admin">
    <x-title title="Vsi dogodki"/>
    @include('partials._events', ['home' => false])
</x-layout>

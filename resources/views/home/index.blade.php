<x-layout :login="$login" :admin="$admin">

{{-- Welcome --}}
@include('partials._welcome')

{{-- News --}}
@include('partials._news')

{{-- Leagues --}}
@include('partials._leagues')

{{-- Events --}}
@include('partials._events', ['home' => true])

{{-- Membership, Rules and Reservations --}}
@include('partials._memberships_info')

{{-- Contact information --}}
@include('partials._contact')

</x-layout>


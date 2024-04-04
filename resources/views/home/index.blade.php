<x-layout :login="$login">

{{-- Welcome --}}
@include('partials._welcome')

{{-- News --}}
@include('partials._news')

{{-- Leagues --}}
@include('partials._leagues')

{{-- Events --}}
{{-- @include('partials._events') --}}

{{-- Membership, Rules and Reservations --}}
@include('partials._memberships_info')

{{-- Contact information --}}
@include('partials._contact')

</x-layout>


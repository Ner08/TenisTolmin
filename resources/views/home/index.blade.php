<x-layout :message="$message ?? null">

{{-- Welcome --}}
@include('partials._welcome')

{{-- Gallery --}}
<x-carousel-gallery :gallery="$gallery"/>

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


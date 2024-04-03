@extends('layouts.master')

@section('title', 'Home')

@section('content')

{{-- Welcome --}}
@include('partials._welcome')

{{-- News --}}
@include('partials._news')

{{-- Leagues --}}
@include('partials._leagues')

</div>

{{-- Membership, Rules and Reservations --}}
@include('partials._memberships_info')

{{-- Contact information --}}
@include('partials._contact')

@endsection


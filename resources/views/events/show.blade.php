<x-layout>

    @php
        $title = 'Dogodek - ' . $event->e_title;
        $titleTab = $title . ' - Tenis Tolmin';
    @endphp

    @title($titleTab)
    <style>body { background-color: #f9fafb; }</style>

    <x-title :title="$title" back-route="events" back-label="Dogodki" />

    <div class="mx-auto">
        @include('partials._event')
    </div>

    @include('partials._comments', [
        'comments'        => $comments,
        'storeRoute'      => route('events.comments.store', $event->id),
        'deleteRouteName' => 'events.comments.destroy',
        'commentModel'    => 'comment',
    ])

</x-layout>

<x-layout>
    @title('Obvestila - Teniški klub Tolmin')

    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-bold text-gray-900">Obvestila</h1>
            @if ($notifications->where('read_at', null)->count())
                <form method="POST" action="{{ route('notifications.mark-all-read') }}">
                    @csrf
                    <button type="submit" class="text-xs font-medium text-gray-500 hover:text-gray-800 transition-colors">
                        Označi vse kot prebrano
                    </button>
                </form>
            @endif
        </div>

        @if ($notifications->isEmpty())
            <div class="bg-white border border-gray-200 rounded-xl px-6 py-10 text-center text-gray-400 text-sm">
                Nimate nobenih obvestil.
            </div>
        @else
            <ul class="space-y-2">
                @foreach ($notifications as $n)
                    @php
                        $icons = [
                            'result_pending'   => ['path' => 'M12 8v4l3 2m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'text-amber-500'],
                            'result_confirmed' => ['path' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'text-green-500'],
                            'result_disputed'  => ['path' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z', 'color' => 'text-red-500'],
                        ];
                        $icon = $icons[$n->type] ?? ['path' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9', 'color' => 'text-gray-400'];
                    @endphp
                    <li @class([
                        'flex items-start gap-3 px-4 py-3.5 rounded-xl border transition-colors',
                        'bg-amber-50 border-amber-100' => $n->isUnread(),
                        'bg-white border-gray-200'     => !$n->isUnread(),
                    ])>
                        <svg class="w-5 h-5 mt-0.5 flex-shrink-0 {{ $icon['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon['path'] }}"/>
                        </svg>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900">{{ $n->title }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $n->message }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $n->created_at->diffForHumans() }}</p>
                        </div>
                        @if ($n->url)
                            <a href="{{ $n->url }}" class="text-xs font-medium text-amber-600 hover:text-amber-800 flex-shrink-0 mt-0.5">
                                Odpri →
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
            <div class="mt-4">{{ $notifications->links('pagination::tailwind') }}</div>
        @endif
    </div>
</x-layout>

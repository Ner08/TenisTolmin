@php
    $dateFromFormated = \Carbon\Carbon::parse($event['fromDate'])->format('d.m.Y');
    $timeFromFormated = \Carbon\Carbon::parse($event['fromDate'])->format('H:i');

    if (isset($event['toDate']) && $event['toDate']) {
        $dateToFormated = \Carbon\Carbon::parse($event['toDate'])->format('d.m.Y');
        $timeToFormated = \Carbon\Carbon::parse($event['toDate'])->format('H:i');
    }
@endphp

<section class="py-8 px-4">
    <div class="container mx-auto max-w-3xl">
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $event['e_title'] }}</h2>
                <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $event['e_description'] }}</p>
            </div>

            <div class="p-6 bg-gray-50 grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-lg bg-white border border-gray-200 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-0.5">Začetek</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $dateFromFormated }}</p>
                        <p class="text-sm text-gray-500">{{ $timeFromFormated }}</p>
                    </div>
                </div>

                @if (isset($dateToFormated))
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-white border border-gray-200 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-0.5">Konec</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $dateToFormated }}</p>
                            <p class="text-sm text-gray-500">{{ $timeToFormated }}</p>
                        </div>
                    </div>
                @endif

                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-lg bg-white border border-gray-200 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-0.5">Lokacija</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $event['location'] }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

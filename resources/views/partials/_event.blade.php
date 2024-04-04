@php
$dateFromFormated = date('d.m.Y', strtotime($event['fromDate']));
 $dateToFormated = date('d.m.Y', strtotime($event['toDate']));
$timeToFormated = date('h:i:s', strtotime($event['fromDate']));
$timeFromFormated = date('h:i:s', strtotime($event['fromDate']));
@endphp

{{-- Event Details --}}
<section class="py-8 m-3">
    <div class="container mx-auto">
        <div class="bg-gray-900 rounded-lg shadow-md overflow-hidden text-white">
            <div class="p-6">
                <h2 class="text-3xl font-semibold mb-4">{{ $event['title'] }}</h2>
                <p class="text-gray-300 mb-4">{{ $event['description'] }}</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center">
                        <img src="{{ asset('images/calandar.svg') }}" alt="Calendar Icon"
                            class="w-6 h-6 text-gray-300 mr-3" />
                        <div>
                            <p class="text-lg font-semibold text-gray-200">{{ $dateFromFormated }}</p>
                            <p class="text-sm text-gray-400">Datum</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <img src="{{ asset('images/clock.svg') }}" alt="Clock Icon"
                            class="w-6 h-6 text-gray-300 mr-3" />
                        <div>
                            <p class="text-lg font-semibold text-gray-200">{{ $timeToFormated }}</p>
                            <p class="text-sm text-gray-400">Čas</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center mt-4">
                    <img src="{{ asset('images/location.svg') }}" alt="Location Icon"
                        class="w-6 h-6 text-gray-300 mr-3" />
                    <div>
                        <p class="text-lg font-semibold text-gray-200">{{ $event['location'] }}</p>
                        <p class="text-sm text-gray-400">Lokacija</p>
                    </div>
                </div>
            </div>
        </div>
        @include('partials._comments')
    </div>
</section>

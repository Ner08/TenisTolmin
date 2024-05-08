@php
    $dateFromFormated = date('d.m.Y', strtotime($event['fromDate']));
    $timeFromFormated = date('h:i:s', strtotime($event['fromDate']));

    if (isset($event['toDate'])) {
        $dateToFormated = date('d.m.Y', strtotime($event['toDate']));
        $timeToFormated = date('h:i:s', strtotime($event['toDate']));
    }
@endphp

{{-- Event Details --}}
<section class="m-3">
    <div class="container mx-auto">
        <div class="bg-gray-900 rounded-lg shadow-md overflow-hidden text-white">
            <div class="p-6">
                <h2 class="text-3xl font-semibold mb-4">{{ $event['e_title'] }}</h2>
                <p class="text-gray-300 mb-4">{{ $event['e_description'] }}</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-0 mr-2">
                    <div class="p-2">
                        <div>
                            <div class="flex items-center mb-1">
                                <p class="text-lg font-bold text-gray-200 inline-block">Začetek: </p>
                            </div>
                            <div class="flex items-center mb-1">
                                <img src="{{ asset('images/calandar.svg') }}" alt="Calendar Icon"
                                    class="w-6 h-6 text-gray-300 mr-2 inline-block" />
                                <p class="text-lg font-semibold text-gray-200 inline-block">{{ $dateFromFormated }}</p>
                            </div>
                            <div class="flex items-center">
                                <img src="{{ asset('images/clock.svg') }}" alt="Clock Icon"
                                    class="w-6 h-6 text-gray-300 mr-2" />
                                <p class="text-lg font-semibold text-gray-200">{{ $timeFromFormated }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-2">
                        <div>
                            <div class="flex items-center mb-1">
                                <p class="text-lg font-bold text-gray-200 inline-block">Konec: </p>
                            </div>
                            <div class="flex items-center mb-1">
                                <img src="{{ asset('images/calandar.svg') }}" alt="Calendar Icon"
                                    class="w-6 h-6 text-gray-300 mr-2 inline-block" />
                                <p class="text-lg font-semibold text-gray-200 inline-block">{{ $dateToFormated }}</p>
                            </div>
                            <div class="flex items-center">
                                <img src="{{ asset('images/clock.svg') }}" alt="Clock Icon"
                                    class="w-6 h-6 text-gray-300 mr-2" />
                                <p class="text-lg font-semibold text-gray-200">{{ $timeToFormated }}</p>
                            </div>
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

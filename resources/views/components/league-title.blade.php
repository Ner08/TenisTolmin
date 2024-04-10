<div class="flex mx-2- p-3 pl-10 bg-gray-900 border-y-2 border-opacity-30 border-gray-800 justify-between">
    <h1 class="p-2 inline-block text-white font-bold text-2xl">{{ $data['name'] }}</h1>
    <div class="flex items-end mr-4 text-lg">
        <div class="flex items-center pr-5">
            <img src="{{ asset('images/from.svg') }}" alt="From" class="h-4 w-4 mr-1">
            <span class="text-gray-300">{{ \Carbon\Carbon::parse($data['start_date'])->format('d.m.Y') }}</span>
        </div>
        <div class="flex items-center">
            <img src="{{ asset('images/to.svg') }}" alt="To" class="h-4 w-4 mr-1">
            <span class="text-gray-300">{{ \Carbon\Carbon::parse($data['end_date'])->format('d.m.Y') }}</span>
        </div>
    </div>
</div>

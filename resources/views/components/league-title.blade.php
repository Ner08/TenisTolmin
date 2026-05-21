<div class="bg-gray-900 border-b border-gray-800">
    <div class="px-6 py-4 flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-xl font-bold text-white">{{ $data['name'] }}</h1>
        <div class="flex items-center gap-4 text-sm text-gray-400">
            <span>{{ \Carbon\Carbon::parse($data['start_date'])->format('d.m.Y') }}</span>
            <span class="text-gray-600">&rarr;</span>
            <span>{{ $data['end_date'] ? \Carbon\Carbon::parse($data['end_date'])->format('d.m.Y') : 'Ni določen' }}</span>
        </div>
    </div>
</div>

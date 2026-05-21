<div class="container mx-auto mt-3 pb-8 px-4" id="admin_clanarina" style="display: none">
    <div class="bg-gray-900 text-white px-5 py-3 rounded-t-xl">
        <h2 class="text-sm font-semibold">Uredi cenik članarin</h2>
    </div>
    <form action="{{ route('membership_edit', ['membership' => $membership->id]) }}" method="POST" class="bg-white border border-gray-200 border-t-0 rounded-b-xl p-5">
        @method('PUT')
        @csrf
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-6 gap-4 mb-4">
            <div>
                <label for="year" class="block text-xs font-semibold text-gray-700 mb-1.5">Leto cenika</label>
                <input type="number" name="year" id="year" placeholder="npr. 2025"
                    class="border border-gray-200 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-amber-500 py-2.5 px-3.5 text-sm"
                    value="{{ $membership->year ?? '' }}" required>
                @error('year')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="price_adults" class="block text-xs font-semibold text-gray-700 mb-1.5">Odrasli (€)</label>
                <input type="number" name="price_adults" id="price_adults" placeholder="0"
                    class="border border-gray-200 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-amber-500 py-2.5 px-3.5 text-sm"
                    value="{{ $membership->price_adults ?? '' }}" required>
                @error('price_adults')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="price_seniors" class="block text-xs font-semibold text-gray-700 mb-1.5">Seniorji 65+ (€)</label>
                <input type="number" name="price_seniors" id="price_seniors" placeholder="0"
                    class="border border-gray-200 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-amber-500 py-2.5 px-3.5 text-sm"
                    value="{{ $membership->price_seniors ?? '' }}" required>
                @error('price_seniors')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="price_students" class="block text-xs font-semibold text-gray-700 mb-1.5">Dijaki/Študenti (€)</label>
                <input type="number" name="price_students" id="price_students" placeholder="0"
                    class="border border-gray-200 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-amber-500 py-2.5 px-3.5 text-sm"
                    value="{{ $membership->price_students ?? '' }}" required>
                @error('price_students')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="price_kids" class="block text-xs font-semibold text-gray-700 mb-1.5">Otroci (€)</label>
                <input type="number" name="price_kids" id="price_kids" placeholder="0"
                    class="border border-gray-200 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-amber-500 py-2.5 px-3.5 text-sm"
                    value="{{ $membership->price_kids ?? '' }}" required>
                @error('price_kids')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="price_family" class="block text-xs font-semibold text-gray-700 mb-1.5">Družina (€)</label>
                <input type="number" name="price_family" id="price_family" placeholder="0"
                    class="border border-gray-200 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-amber-500 py-2.5 px-3.5 text-sm"
                    value="{{ $membership->price_family ?? '' }}" required>
                @error('price_family')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="border-t border-gray-100 pt-4 mb-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Podatki za plačilo</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="trr" class="block text-xs font-semibold text-gray-700 mb-1.5">Transakcijski račun (TRR)</label>
                    <input type="text" name="trr" id="trr" placeholder="SI56 XXXX XXXX XXXX XXX"
                        class="border border-gray-200 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-amber-500 py-2.5 px-3.5 text-sm"
                        value="{{ $membership->trr ?? '' }}" required>
                    @error('trr')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="sklic" class="block text-xs font-semibold text-gray-700 mb-1.5">Sklic</label>
                    <input type="text" name="sklic" id="sklic" placeholder="Vnesite sklic"
                        class="border border-gray-200 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-amber-500 py-2.5 px-3.5 text-sm"
                        value="{{ $membership->sklic ?? '' }}" required>
                    @error('sklic')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="namen" class="block text-xs font-semibold text-gray-700 mb-1.5">Namen plačila</label>
                    <input type="text" name="namen" id="namen" placeholder="Vnesite namen"
                        class="border border-gray-200 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-amber-500 py-2.5 px-3.5 text-sm"
                        value="{{ $membership->namen ?? '' }}" required>
                    @error('namen')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="prejemnik" class="block text-xs font-semibold text-gray-700 mb-1.5">Prejemnik</label>
                    <input type="text" name="prejemnik" id="prejemnik" placeholder="Vnesite prejemnika"
                        class="border border-gray-200 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-amber-500 py-2.5 px-3.5 text-sm"
                        value="{{ $membership->prejemnik ?? '' }}" required>
                    @error('prejemnik')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <button type="submit"
            class="bg-gray-900 text-white text-sm px-6 py-2.5 rounded-lg hover:bg-gray-700 transition-colors">
            Shrani spremembe
        </button>
    </form>
</div>

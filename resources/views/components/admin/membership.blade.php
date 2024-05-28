<div class="container mx-auto mt-3 pb-8 px-4" id="admin_clanarina" style="display: none">
    <!-- Update membership form -->
    <div class="bg-zinc-900 text-white py-2 px-4 rounded-t-lg">
        <h2 class="text-xl font-bold">Uredi</h2>
    </div>
    <form action="{{ route('membership_edit', ['membership' => $membership->id]) }}" method="POST" class="mb-5 bg-gray-100 rounded-lg p-6">
        @method('PUT')
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-4">
            <div>
                <label for="year" class="block text-gray-700 font-semibold">Leto Cenika</label>
                <input type="number" name="year" id="year" placeholder="Vnesite leto cenika"
                    class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                    value="{{ $membership->year ?? '' }}" required>
                @error('year')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="price_adults" class="block text-gray-700 font-semibold">Cena odrasli:</label>
                <input type="number" name="price_adults" id="price_adults" placeholder="Vnesite ceno za odrasle"
                    class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                    value="{{ $membership->price_adults ?? '' }}" required>
                @error('price_adults')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="price_seniors" class="block text-gray-700 font-semibold">Cena seniorji:</label>
                <input type="number" name="price_seniors" id="price_seniors" placeholder="Vnesite ceno za starejše od 65"
                    class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                    value="{{ $membership->price_seniors ?? '' }}" required>
                @error('price_seniors')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="price_students" class="block text-gray-700 font-semibold">Cena študenti in dijaki:</label>
                <input type="number" name="price_students" id="price_students"
                    placeholder="Vnesite ceno za dijake in študente"
                    class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                    value="{{ $membership->price_students ?? '' }}" required>
                @error('price_students')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="price_kids" class="block text-gray-700 font-semibold">Cena otroci:</label>
                <input type="number" name="price_kids" id="price_kids" placeholder="Vnesite ceno za otroke"
                    class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                    value="{{ $membership->price_kids ?? '' }}" required>
                @error('price_kids')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="price_family" class="block text-gray-700 font-semibold">Cena družina:</label>
                <input type="number" name="price_family" id="price_family" placeholder="Vnesite ceno za družine"
                    class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                    value="{{ $membership->price_family ?? '' }}" required>
                @error('price_family')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="trr" class="block text-gray-700 font-semibold">Št. transakcijskega računa:</label>
                <input type="text" name="trr" id="trr"
                    placeholder="Vnesite število transakcijskega računa (TRR)"
                    class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                    value="{{ $membership->trr ?? '' }}" required>
                @error('trr')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="sklic" class="block text-gray-700 font-semibold">Sklic:</label>
                <input type="text" name="sklic" id="sklic" placeholder="Vnesite sklic"
                    class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                    value="{{ $membership->sklic ?? '' }}" required>
                @error('sklic')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="namen" class="block text-gray-700 font-semibold">Namen plačila:</label>
                <input type="text" name="namen" id="namen" placeholder="Vnesite namen plačila"
                    class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                    value="{{ $membership->namen ?? '' }}" required>
                @error('namen')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="prejemnik" class="block text-gray-700 font-semibold">Prejemnik:</label>
                <input type="text" name="prejemnik" id="prejemnik" placeholder="Vnesite prejemnika plačila"
                    class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                    value="{{ $membership->prejemnik ?? '' }}" required>
                @error('prejemnik')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <button type="submit"
            class="bg-zinc-500 text-white px-8 py-3 rounded-lg hover:bg-zinc-600 focus:outline-none transition duration-300">Shrani
        </button>
    </form>
</div>

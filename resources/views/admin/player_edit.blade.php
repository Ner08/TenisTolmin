<x-layout :login="$login" :admin="$admin" :message="$message ?? null" :flash="$flash ?? null" :model="$model ?? null">
    <div class="container mx-auto pt-4 px-4 mb-8">
        <div class="mb-4">
            <form action="{{ route('players_edit', $player->id) }}" method="POST"
                class="bg-gray-100 rounded-lg overflow-hidden">
                @method('PUT')
                @csrf
                <div class="bg-zinc-900 text-white py-2 px-4 rounded-t-lg">
                    <h2 class="text-xl font-bold">Uredi igralca</h2>
                </div>
                <div class="p-4">
                    <div class="flex flex-col mb-2">
                        <div class="flex flex-col mr-4 mb-2">
                            <label for="p_name" class="mb-2">Ime:</label>
                            <input type="text" name="p_name" id="p_name" placeholder="Vnesi ime igralca"
                                class="form-input rounded-lg py-3 px-4 w-full mb-2  focus:outline-none "
                                value="{{ $player->p_name }}" required>
                            @error('p_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex flex-col mr-4 mb-2 ">
                            <label for="points" class="mb-2">Točke:</label>
                            <input type="number" name="points" id="points" value="0" min="0"
                                class="form-input rounded-lg py-3 px-4 w-full  mb-2  focus:outline-none "
                                value="{{ $player->points }}" required>
                            @error('points')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-end pb-4 ">
                            <input type="checkbox" name="is_standin" id="is_standin"
                                class="mr-2 bg-gray-300 rounded-sm h-5 w-5" onchange="togglePointsInput()"
                                value="{{ $player->is_fake ? 1 : 0 }}">
                            <label for="is_standin" class="text-gray-700 font-semibold mr-4">Ni pravi
                                igralec</label>
                            @error('is_standin')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex flex-col mr-4">
                            <button type="submit"
                                class="bg-zinc-600 text-white mt-8 px-3 py-3 rounded-lg hover:bg-zinc-700 focus:outline-none sm:w-20 focus:bg-zinc-700">Shrani</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

</x-layout>

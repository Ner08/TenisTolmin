<x-layout :login="$login" :admin="$admin" :message="$message ?? null" :flash="$flash ?? null" :model="$model ?? null">
    <div class="container mx-auto mt-3 mb-8 px-4">
        <!-- Add new news form -->
        <div class="bg-zinc-900 text-white py-2 px-4 rounded-t-lg">
            <h2 class="text-xl font-bold">Uredi novico</h2>
        </div>
        <form action="{{ route('news_edit', $news->id) }}" method="POST" class="mb-5 bg-gray-100 rounded-lg p-6"
            enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-semibold">Naslov:</label>
                <input type="text" name="title" id="title" placeholder="Vnesite naslov"
                    class="form-input rounded-lg w-full focus:outline-none  border-gray-300 py-3 px-4"
                    value="{{ $news->title }}" required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="content" class="block text-gray-700 font-semibold">Vsebina:</label>
                <textarea name="content" id="content" placeholder="Vnesite vsebino"
                    class="form-textarea rounded-lg w-full h-48 focus:outline-none  border-gray-300 py-3 px-4" required>{{ $news->content }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-semibold">Datoteka:</label>
                <!-- Display the image -->
                @if($news->image)
                    <img src="{{ asset('storage/' .$news->image) }}" alt="Image" class="max-w-xs max-h-40 h-auto mb-2">

                @endif
                <!-- Input field to update the image -->
                <input type="file" name="image" id="image" class="form-input rounded-lg w-full focus:outline-none border-gray-300 py-3">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                class="bg-zinc-500 text-white px-8 py-3 rounded-lg hover:bg-zinc-600 focus:outline-none transition duration-300">Shrani
            </button>
        </form>
    </div>
</x-layout>

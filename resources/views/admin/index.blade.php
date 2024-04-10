<x-layout :login="$login">
    <x-admin-title title="Adminstracijska plošča" />
    <div class="bg-gray-200">
        <div class="container mx-auto py-4 ">
            <!-- Players Section -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold mb-6 text-gray-900 underline">Igralci</h2>
                <form action="{{-- {{ route('players.store') }} --}}" method="POST" class="flex items-center mb-6">
                    @csrf
                    <div class="flex flex-col mr-4">
                        <label for="name" class="mb-2">Ime:</label>
                        <input type="text" name="name" id="name" placeholder="Vnesi ime igralca"
                            class="form-input rounded-lg py-3 px-4 w-64 mb-2 focus:outline-none focus:border-blue-500"
                            required>
                    </div>
                    <div class="flex flex-col mr-4">
                        <label for="points" class="mb-2">Točke:</label>
                        <input type="number" name="points" id="points" value="0" min="0"
                            class="form-input rounded-lg py-3 px-4 w-24 mb-2 focus:outline-none focus:border-blue-500"
                            required>
                    </div>
                    <div class="flex flex-col mr-4">
                        <button type="submit"
                            class="bg-blue-500 text-white mt-6 px-3 py-3 rounded-lg hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Potrdi
                        </button>
                    </div>

                </form>

                <!-- Display list of players with edit and delete buttons -->
                <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
                    @foreach ($players as $player)
                        <li class="bg-white rounded-lg shadow-md p-3">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-xl font-semibold">{{ $player->name }}</p>
                                    <p class="text-gray-600">Točke: {{ $player->points }}</p>
                                </div>
                                <div class="flex items-center">
                                    <!-- Form to add points -->
                                    <form action="{{-- {{ route('players.add_points', $player->id) }} --}}" method="POST" class="mr-4">
                                        @csrf
                                        <input type="number" name="points" id="points" placeholder="Točke"
                                            class="form-input rounded-lg pl-2 h-8 w-16 focus:outline-none focus:border-blue-500 bg-gray-300"
                                            required>
                                        <button type="submit"
                                            class="bg-green-500 text-white px-2 py-1 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Dodaj</button>
                                    </form>
                                    <!-- Edit and Delete buttons -->
                                    <a href="{{-- {{ route('players.edit', $player->id) }} --}}"
                                        class="text-blue-500 hover:underline mr-4">Uredi</a>
                                    <form action="{{-- {{ route('players.destroy', $player->id) }} --}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 hover:underline bg-transparent border-none">Zbriši</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>



            </div>

            <!-- News Section -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold mb-6">Novice</h2>
                <!-- Add new news form -->
                <form action="{{-- {{ route('news.store') }} --}}" method="POST" class="mb-8">
                    @csrf
                    <textarea name="content" placeholder="Enter News Content"
                        class="form-textarea rounded-lg w-full h-48 focus:outline-none focus:border-blue-500" required></textarea>
                    <button type="submit"
                        class="bg-blue-500 text-white px-8 py-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Add
                        News</button>
                </form>
                <!-- Display list of news with edit and delete buttons -->
                <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($news as $item)
                        <li class="bg-white rounded-lg shadow-md p-6">
                            <p>{{ $item->content }}</p>
                            <div class="flex justify-end mt-4">
                                <a href="{{-- {{ route('news.edit', $item->id) }} --}}" class="text-blue-500 hover:underline mr-4">Edit</a>
                                <form action="{{-- {{ route('news.destroy', $item->id) }} --}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Events Section -->
            <div class="mb-12">
                <h2 class="text-2xl font-semibold mb-6">Events</h2>
                <!-- Add new event form -->
                <form action="{{-- {{ route('events.store') }} --}}" method="POST" class="mb-8">
                    @csrf
                    <input type="text" name="name" placeholder="Enter Event Name"
                        class="form-input rounded-lg py-3 px-4 w-full focus:outline-none focus:border-blue-500"
                        required>
                    <button type="submit"
                        class="bg-blue-500 text-white px-8 py-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Add
                        Event</button>
                </form>
                <!-- Display list of events with edit and delete buttons -->
                <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($events as $event)
                        <li class="bg-white rounded-lg shadow-md p-6">
                            <p>{{ $event->name }}</p>
                            <div class="flex justify-end mt-4">
                                <a href="{{-- {{ route('events.edit', $event->id) }} --}}" class="text-blue-500 hover:underline mr-4">Edit</a>
                                <form action="{{-- {{ route('events.destroy', $event->id) }} --}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Leagues Section -->
            <div>
                <h2 class="text-2xl font-semibold mb-6">Leagues</h2>
                <!-- Add new league form -->
                <form action="{{-- {{ route('leagues.store') }} --}}" method="POST" class="mb-8">
                    @csrf
                    <input type="text" name="name" placeholder="Enter League Name"
                        class="form-input rounded-lg py-3 px-4 w-full focus:outline-none focus:border-blue-500"
                        required>
                    <button type="submit"
                        class="bg-blue-500 text-white px-8 py-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Add
                        League</button>
                </form>
                <!-- Display list of leagues with edit and delete buttons -->
                <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($leagues as $league)
                        <li class="bg-white rounded-lg shadow-md p-6">
                            <p>{{ $league->name }}</p>
                            <div class="flex justify-end mt-4">
                                <a href="{{-- {{ route('leagues.edit', $league->id) }} --}}" class="text-blue-500 hover:underline mr-4">Edit</a>
                                <form action="{{-- {{ route('leagues.destroy', $league->id) }} --}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-layout>

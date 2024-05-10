<x-layout :login="$login" :admin="$admin">
    @php
        $title = 'Novice • ' . $newsItem->title;
    @endphp
    <x-title :title="$title" />

    {{-- News Details --}}
    <section class="m-3 mt-6">
        <div class="container mx-auto">
            <div class="bg-gray-900 rounded-lg shadow-md overflow-hidden text-white flex flex-col-reverse lg:flex-row"> <!-- Updated flexbox classes -->
                <div class="w-full lg:w-4/5 p-6"> <!-- Updated width classes -->
                    <h2 class="text-3xl font-semibold mb-2">{{ $newsItem['title'] }}</h2>
                    <p class="text-gray-200">{{ $newsItem['content'] }}</p>
                    <p class="text-gray-500 mt-4">Objavljeno: {{ $newsItem['created_at']->format('d.m.Y') }}</p>
                </div>
                @if (isset($newsItem['image']))
                    <div class="w-full lg:w-1/2 overflow-hidden relative"> <!-- Updated image container with relative positioning -->
                        <img src="{{ asset('storage/' . $newsItem['image']) }}" alt="{{ $newsItem['title'] }}" class="w-full h-auto md:h-full object-cover cursor-pointer" onclick="showFullImage('{{ asset('storage/' . $newsItem['image']) }}')"> <!-- Updated image with cursor pointer and onclick event -->
                    </div>
                @endif
            </div>
            @include('partials._comments')
        </div>
    </section>
</x-layout>

<!-- JavaScript function to show full image -->
<script>
    function showFullImage(imageUrl) {
        // Create a modal overlay
        const overlay = document.createElement('div');
        overlay.classList.add('fixed', 'top-0', 'left-0', 'w-screen', 'h-screen', 'bg-black', 'bg-opacity-75', 'flex', 'justify-center', 'items-center', 'z-50');

        // Create a container for the image and close button
        const container = document.createElement('div');
        container.classList.add('relative');

        // Create a close button
        const closeButton = document.createElement('button');
        closeButton.innerHTML = 'Zapri';
        closeButton.classList.add('absolute', 'top-2', 'right-2', 'bg-white', 'text-black', 'px-2', 'py-1', 'rounded-md', 'cursor-pointer');
        closeButton.addEventListener('click', function() {
            overlay.remove();
        });

        // Create the full-size image
        const fullImage = document.createElement('img');
        fullImage.src = imageUrl;
        fullImage.alt = 'Full Image';
        fullImage.classList.add('m-auto');

        // Calculate maximum width and height based on viewport dimensions
        const maxViewportWidth = window.innerWidth * 0.9; // Adjust the multiplier as needed
        const maxViewportHeight = window.innerHeight * 0.9; // Adjust the multiplier as needed

        // Set the maximum width and height of the image
        fullImage.style.maxWidth = `${maxViewportWidth}px`;
        fullImage.style.maxHeight = `${maxViewportHeight}px`;

        // Append elements to the container
        container.appendChild(closeButton);
        container.appendChild(fullImage);

        // Append container to the overlay
        overlay.appendChild(container);

        // Append overlay to the body
        document.body.appendChild(overlay);
    }
</script>

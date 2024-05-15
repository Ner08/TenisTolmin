<x-layout>
    {{-- Gallery --}}
    <x-title title="Galerija" />
    <section class="py-8 px-4">
        <div class="container mx-auto">
            {{-- If no images show empty component --}}
            @if ($gallery->isEmpty())
                <x-empty model1="Galerija" />
            @endif
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:lg:grid-cols-4 gap-8">
                <!-- Gallery items -->
                @foreach ($gallery as $item)
                    <div class="flex flex-col items-center justify-center rounded-lg p-4">
                        <img src="{{ asset('storage/' . $item->g_image) }}" alt="{{ $item->g_title }}"
                            class="w-full h-auto rounded-lg cursor-pointer"
                            onclick="showFullImage('{{ asset('storage/' . $item->g_image) }}')">
                        <!-- You can add additional information or styling here if needed -->
                    </div>
                @endforeach
            </div>
            <div class="mt-8">{{ $gallery->links() }}</div>
        </div>
    </section>
</x-layout>

<!-- JavaScript function to show full image -->
<script>
    function showFullImage(imageUrl) {
        // Create a modal overlay
        const overlay = document.createElement('div');
        overlay.classList.add('fixed', 'top-0', 'left-0', 'w-screen', 'h-screen', 'bg-black', 'bg-opacity-75', 'flex',
            'justify-center', 'items-center', 'z-50');

        // Create a container for the image and close button
        const container = document.createElement('div');
        container.classList.add('relative');

        // Create a close button
        const closeButton = document.createElement('button');
        closeButton.innerHTML = 'Zapri';
        closeButton.classList.add('absolute', 'top-2', 'right-2', 'bg-white', 'text-black', 'px-2', 'py-1',
            'rounded-md', 'cursor-pointer');
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

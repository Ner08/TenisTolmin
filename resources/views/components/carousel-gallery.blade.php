<div class="container px-4 mx-auto py-8">
    <h1 class="text-3xl font-bold mb-3">Galerija</h1>
    <h4 class="text-lg text-gray-600 mb-8">Naša teniška galerija ponuja vpogled v dogodke našega teniškega kluba. Slike zajemajo igralne trenutke in sproščena druženja, ki odražajo strast in povezanost naših članov,</h4>
    {{-- If no news show empty component --}}
    @if ($gallery->isEmpty())
        <x-empty model1="Slike" />
    @endif
    <div class="grid grid-cols-3 gap-4">
        @foreach ($gallery as $item)
            <div class="p-1 rounded-md shadow-2xl">
                <div class="image-container h-64 w-full flex-shrink-0">
                    <img src="{{ asset('storage/' . $item->g_image) }}" alt="{{ $item->g_title }}" class="w-full h-full rounded-md shadow cursor-pointer" onclick="showFullImage('{{ asset('storage/' . $item->g_image) }}')" style="object-fit: cover;">
                </div>
            </div>
        @endforeach
    </div>
    <div class="flex justify-center mt-8">
        <a href="{{ route('gallery') }}"
            class="bg-gray-900 hover:bg-gray-800 text-white text-lg font-bold py-2 px-6 rounded-lg transition duration-300 ease-in-out transform hover:-translate-y-1">
            Več slik
        </a>
    </div>
</div>

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

{{-- <div class="carousel relative w-full py-12 pt-6">
    <div class="carousel-inner flex transition-transform duration-500">
        @foreach ($gallery as $item)
            <div class="carousel-item flex-none w-full md:w-1/3 p-2">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('storage/' . $item->g_image) }}" alt="{{ $item->g_title }}"
                        class="w-full h-full object-cover">
                </div>
            </div>
        @endforeach
    </div>

    <button class="carousel-prev absolute left-12 top-1/2 transform -translate-y-1/2 -translate-x-8 bg-gray-800 bg-opacity-50 rounded-full text-white p-3 focus:outline-none transition-transform duration-300 hover:bg-opacity-70">‹</button>
    <button class="carousel-next absolute right-12 top-1/2 transform -translate-y-1/2 translate-x-8 bg-gray-800 bg-opacity-50 rounded-full text-white p-3 focus:outline-none transition-transform duration-300 hover:bg-opacity-70">›</button>
</div>

<script>
    const carousel = document.querySelector('.carousel');
    const inner = carousel.querySelector('.carousel-inner');
    const items = carousel.querySelectorAll('.carousel-item');
    const prevButton = carousel.querySelector('.carousel-prev');
    const nextButton = carousel.querySelector('.carousel-next');
    const itemWidth = items[0].offsetWidth;
    const visibleItemCount = 1;
    const totalItemCount = items.length;
    let currentIndex = 0; // Start from the middle item

    function setTransform() {
        const translateX = -((currentIndex - (visibleItemCount - 1) / 2) * itemWidth);
        inner.style.transform = `translateX(${translateX}px)`;
    }

    function nextSlide() {
        console.log(currentIndex);
        currentIndex++;
        if (currentIndex >= totalItemCount + visibleItemCount) {
            currentIndex = totalItemCount;
        }
        if (currentIndex != totalItemCount) {
            setTransform();
        }
    }

    function prevSlide() {
        console.log(currentIndex);
        currentIndex--;
        if (currentIndex < 0) {
            currentIndex = 0;
        }
        if (currentIndex != 0) {
            setTransform();
        }

    }

    prevButton.addEventListener('click', prevSlide);
    nextButton.addEventListener('click', nextSlide);
</script>

<style>
    .carousel {
        max-width: 100%;
        overflow: hidden;
    }

    .carousel-inner {
        display: flex;
        transition: transform 0.5s ease;
    }

    .carousel-item {
        flex: none;
        flex-grow: 0;
        height: 100%;
    }
</style>
 --}}

<!doctype html>
<html>

<head>
    <title>Teniški klub Tolmin</title>
    <meta charset="utf-8">
    <meta name="author" content="Nejc Robič">
    <meta name="description"
        content="
    Teniški klub Tolmin je priljubljena destinacija za ljubitelje tenisa v Tolminu in okolici. Naša ponudba vključuje številna peščena igrišča, ki omogočajo igro tenisa v naravnem okolju. Poleg rednih teniških aktivnosti organiziramo tudi teniško ligo, kjer se lahko pomerite s tekmovalci različnih nivojev. Ne zamudite naših dogodkov, ki vključujejo druženja ob igri in razburljive turnirje, kjer lahko pokažete svoje spretnosti. Pridružite se nam v Teniškem klubu Tolmin in ustvarite nepozabne teniške trenutke.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body>
    <nav class=" border-gray-200 bg-gray-900 fixed w-full top-0 left-0 z-50">
        <div class="max-w-screen-2xl flex flex-wrap items-center justify-between mx-auto p-3">
            <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('images/logo10.png') }}" alt="logo" class="h-8 w-auto" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap text-white">Teniški klub
                    Tolmin</span>

            </a>
            <button data-collapse-toggle="navbar-default" type="button" id="navbar-toggle"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm rounded-lg md:hidden focus:outline-none focus:ring-2  text-gray-400 hover:bg-gray-700 focus:ring-gray-600"
                aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <span class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul
                    class="font-medium flex flex-col p-4 md:p-0 mt-4 border rounded-lg md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 bg-gray-800 md:bg-gray-900 border-gray-700">
                    <li>
                        <a href="{{ route('news') }}"
                            class="block py-2 px-3 rounded md:border-0 md:p-0 text-white md:hover:text-gray-300 hover:bg-gray-700 hover:text-white md:hover:bg-transparent">Novice</a>
                    </li>
                    <li>
                        <a href="{{ route('leagues') }}"
                            class="block py-2 px-3 rounded md:border-0 md:p-0 text-white md:hover:text-gray-300 hover:bg-gray-700 hover:text-white md:hover:bg-transparent">Lige</a>
                    </li>
                    <li>
                        <a href="{{ route('gallery') }}"
                            class="block py-2 px-3 rounded  md:border-0 md:p-0 text-white md:hover:text-gray-300 hover:bg-gray-700 hover:text-white md:hover:bg-transparent">Galerija
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('events') }}"
                            class="block py-2 px-3 rounded md:border-0 md:p-0 text-white md:hover:text-gray-300 hover:bg-gray-700 hover:text-white md:hover:bg-transparent">Dogodki</a>
                    </li>
                    <li>
                        <a href="{{ route('membership') }}"
                            class="block py-2 px-3 rounded md:border-0 md:p-0 text-white md:hover:text-gray-300 hover:bg-gray-700 hover:text-white md:hover:bg-transparent">Članstvo
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}"
                            class="block py-2 px-3 rounded md:border-0 md:p-0 text-white md:hover:text-gray-300 hover:bg-gray-700 hover:text-white md:hover:bg-transparent">Kontakt</a>
                    </li>
                    @auth
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="block py-2 px-3 rounded md:border-0 md:p-0 text-white md:hover:text-gray-300 hover:bg-gray-700 hover:text-white md:hover:bg-transparent">
                                    Odjava
                                </button>
                            </form>
                        </li>
                    @endauth
                </ul>
        </div>
        </span>
    </nav>

    <div class="mt-12 pt-2 @if (session()->has('flash') && session()->has('message')) blurred @endif">
        {{ $slot }}
    </div>

    {{-- Edit button (Admin only) --}}
    @auth
        @if (auth()->user()->is_admin)
            <div class="fixed bottom-4 right-4">
                <a href="{{ route('admin') }}"
                    class="flex items-center justify-center border-2 border-white w-16 h-16 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded-full shadow-2xls">
                    Admin
                </a>
            </div>
        @endif
    @endauth

    @if (session()->has('flash') && session()->has('message'))
        <x-flash-message :route="$route ?? null" :flash="$flash ?? null" :message="$message ?? null" :model="$model ?? null" />
    @elseif (session()->has('message'))
        <x-flash-message-2 :message="$message" />
    @endif
</body>

<script>
    window.onload = function() {
        // Check if the page was reloaded (type === 1 indicates reload)
        if (performance.navigation.type === 1) {
            // Remove query parameters from the URL
            window.history.replaceState({}, document.title, window.location.pathname);
        } else {
            // If it's not a reload, keep the scroll position
            const scrollPosition = sessionStorage.getItem('scrollPosition');
            if (scrollPosition !== null) {
                window.scrollTo(0, scrollPosition);
                // Delete the scroll position from sessionStorage after scrolling to it
                sessionStorage.removeItem('scrollPosition');
            }
        }
    };

    document.addEventListener('DOMContentLoaded', function() {
        // Add event listener to form submission
        document.addEventListener('submit', function(event) {
            // Store the scroll position before the form is submitted
            sessionStorage.setItem('scrollPosition', window.scrollY);
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const navbarToggle = document.getElementById('navbar-toggle');
        const navbarDefault = document.getElementById('navbar-default');

        navbarToggle.addEventListener('click', function() {
            navbarDefault.classList.toggle('hidden');
        });
    });

    function showDeleteConfirmation(formId, itemId) {
        var deleteForm = document.getElementById(formId + itemId);
        var confirmationForm = document.getElementById('confirmDeleteForm');

        // Show the confirmation dialog
        var deleteConfirmationDialog = document.getElementById('deleteConfirmationDialog');
        deleteConfirmationDialog.classList.remove('hidden');

        confirmationForm.action = deleteForm.action;
    }

    function hideDeleteConfirmation() {
        // Hide the confirmation dialog
        var deleteConfirmationDialog = document.getElementById('deleteConfirmationDialog');
        deleteConfirmationDialog.classList.add('hidden');
    }

    function toggleComponent(componentId) {
        var component = document.getElementById(componentId);
        if (component.style.display === 'none') {
            component.style.display = 'block';
            // Save the state to localStorage
            localStorage.setItem(componentId, 'block');
        } else {
            component.style.display = 'none';
            // Save the state to localStorage
            localStorage.setItem(componentId, 'none');
        }
    }
</script>

</html>

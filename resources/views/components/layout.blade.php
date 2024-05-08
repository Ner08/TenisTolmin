<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body>
    <nav class="bg-white border-gray-200 dark:bg-gray-900 fixed w-full top-0 left-0 z-50">
        <div class="max-w-screen-2xl flex flex-wrap items-center justify-between mx-auto p-3">
            <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('images/logo10.png') }}" alt="logo" class="h-8 w-auto" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Teniški klub
                    Tolmin</span>

            </a>
            <button data-collapse-toggle="navbar-default" type="button" id="navbar-toggle"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
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
                    class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <li>
                        <a href="{{ route('news') }}"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Novice</a>
                    </li>
                    <li>
                        <a href="{{ route('leagues') }}"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Lige</a>
                    </li>
                    <li>
                        <a href="{{ route('events') }}"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Dogodki</a>
                    </li>
                    <li>
                        <a href="{{ route('membership') }}"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Članstvo
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Kontakt</a>
                    </li>
                </ul>
        </div>
        </span>
    </nav>

    <div class="mt-12 pt-2 @if (session()->has('flash') && session()->has('message')) blurred @endif">
        {{ $slot }}
    </div>

    {{-- Edit button (Admin only) --}}
    @if ($admin)
        <div class="fixed bottom-4 right-4">
            <a href="{{ route('admin') }}"
                class="flex items-center justify-center border-2 border-white w-16 h-16 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded-full shadow-2xls">
                Admin
            </a>
        </div>
    @endif

    @if (session()->has('flash') && session()->has('message'))
        <x-flash-message :route="$route ?? null" :flash="$flash ?? null" :message="$message ?? null" :model="$model ?? null" />
    @elseif (session()->has('message'))
        <x-flash-message-2 :message="$message" />
    @endif
</body>

<script>
    window.onload = function() {
        if (performance.navigation.type === 1) {
            // Remove query parameters from the URL
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    };
    document.addEventListener('DOMContentLoaded', function() {
        const navbarToggle = document.getElementById('navbar-toggle');
        const navbarDefault = document.getElementById('navbar-default');

        navbarToggle.addEventListener('click', function() {
            navbarDefault.classList.toggle('hidden');
        });
    });
    @if (isset($scroll))
        document.addEventListener("DOMContentLoaded", function() {
            var scrollTarget = document.querySelector("{{ $scroll }}");
            if (scrollTarget) {
                var scrollTop = scrollTarget.offsetTop - 370;
                window.scrollTo({
                    top: scrollTop,
                    behavior: "smooth"
                });
            }
        });
    @endif
    function showDeleteConfirmation(itemId) {
        // Set the action of the form dynamically based on the item ID
        var deleteForm = document.getElementById('deleteForm' + itemId);
        var confirmationForm = document.getElementById('confirmDeleteForm');
        confirmationForm.action = deleteForm.action;

        // Show the confirmation dialog
        var deleteConfirmationDialog = document.getElementById('deleteConfirmationDialog');
        deleteConfirmationDialog.classList.remove('hidden');
    }

    function hideDeleteConfirmation() {
        // Hide the confirmation dialog
        var deleteConfirmationDialog = document.getElementById('deleteConfirmationDialog');
        deleteConfirmationDialog.classList.add('hidden');
    }
</script>

</html>

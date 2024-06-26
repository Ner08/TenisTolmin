<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body>
    <nav class=" border-gray-200 bg-gray-900">
        <div class="max-w-screen-2xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('images/logo10.png') }}" alt="logo" class="h-8 w-auto" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap text-white">Teniški klub
                    Tolmin</span>

            </a>
            <button data-collapse-toggle="navbar-default" type="button" id="navbar-toggle"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm  rounded-lg md:hidden  focus:outline-none focus:ring-2  text-gray-400 hover:bg-gray-700 focus:ring-gray-600"
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
                    class="font-medium flex flex-col p-4 md:p-0 mt-4 border rounded-lg  md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0  bg-gray-800 md:bg-gray-900 border-gray-700">
                    <li>
                        <a href="{{ route('news') }}"
                            class="block py-2 px-3 rounded  md:border-0  md:p-0 text-white md:hover:text-gray-300 hover:bg-gray-700 hover:text-white md:hover:bg-transparent">Novice</a>
                    </li>
                    <li>
                        <a href="{{ route('leagues') }}"
                            class="block py-2 px-3  rounded  md:border-0 md:p-0 text-white md:hover:text-gray-300 hover:bg-gray-700 hover:text-white md:hover:bg-transparent">Lige</a>
                    </li>
                    <li>
                        <a href="{{ route('events') }}"
                            class="block py-2 px-3  rounded  md:border-0  md:p-0 text-white md:hover:text-gray-300 hover:bg-gray-700 hover:text-white md:hover:bg-transparent">Dogodki</a>
                    </li>
                    <li>
                        <a href="{{ route('gallery') }}"
                            class="block py-2 px-3  rounded  md:border-0  md:p-0 text-white md:hover:text-gray-300 hover:bg-gray-700 hover:text-white md:hover:bg-transparent">Galerija</a>
                    </li>
                    <li>
                        <a href="{{ route('membership') }}"
                            class="block py-2 px-3  rounded  md:border-0  md:p-0 text-white md:hover:text-gray-300 hover:bg-gray-700 hover:text-white md:hover:bg-transparent">Članstvo
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}"
                            class="block py-2 px-3 rounded  md:border-0  md:p-0 text-white md:hover:text-gray-300 hover:bg-gray-700 hover:text-white md:hover:bg-transparent">Kontakt</a>
                    </li>
                </ul>
        </div>
        </span>
    </nav>

    {{ $slot }}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbarToggle = document.getElementById('navbar-toggle');
            const navbarDefault = document.getElementById('navbar-default');

            navbarToggle.addEventListener('click', function() {
                navbarDefault.classList.toggle('hidden');
            });
        });
    </script>
</body>

</html>

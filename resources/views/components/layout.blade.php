<!doctype html>
<html lang="sl">

<head>
    <title>Teniški klub Tolmin</title>
    <meta charset="utf-8">
    <meta name="author" content="Nejc Robič">
    <meta name="description" content="Teniški klub Tolmin je priljubljena destinacija za ljubitelje tenisa v Tolminu in okolici. Organiziramo teniško ligo, turnirje in različne dogodke za vse starosti.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="preload" as="image" href="{{ asset('images/logo10.png') }}">
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-white text-gray-900 antialiased flex flex-col min-h-screen">
    <nav class="bg-gray-900 border-b border-gray-800 fixed w-full top-0 left-0 z-50">
        <div class="max-w-screen-2xl flex flex-wrap items-center justify-between mx-auto px-4 py-3">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/logo10.png') }}" alt="TK Tolmin logo" class="h-8 w-auto" width="32" height="32" fetchpriority="high" />
                <span class="text-xl font-bold text-white tracking-tight">Teniški klub Tolmin</span>
            </a>

            <button id="navbar-toggle" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-gray-400 rounded-lg md:hidden hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-600"
                aria-controls="navbar-default" aria-expanded="false" aria-label="Open main menu">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>

            <span class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul class="flex flex-col md:flex-row md:items-center gap-1 md:gap-0 mt-3 md:mt-0 p-4 md:p-0 rounded-lg md:rounded-none bg-gray-800 md:bg-transparent border border-gray-700 md:border-0">
                    @php
                        $navLinks = [
                            ['route' => 'news',       'label' => 'Novice'],
                            ['route' => 'leagues',    'label' => 'Lige'],
                            ['route' => 'gallery',    'label' => 'Galerija'],
                            ['route' => 'events',     'label' => 'Dogodki'],
                            ['route' => 'membership', 'label' => 'Članstvo'],
                            ['route' => 'contact',    'label' => 'Kontakt'],
                        ];
                    @endphp
                    @foreach ($navLinks as $link)
                        <li>
                            <a href="{{ route($link['route']) }}"
                               class="block px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                                      {{ request()->routeIs($link['route']) || request()->routeIs($link['route'].'*')
                                           ? 'text-amber-400 bg-gray-800 md:bg-transparent md:text-amber-400'
                                           : 'text-gray-300 hover:text-white hover:bg-gray-700 md:hover:bg-transparent md:hover:text-white' }}">
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                    @auth
                        <li class="md:ml-4">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 md:hover:bg-transparent md:hover:text-white transition-colors duration-150">
                                    Odjava
                                </button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </span>
        </div>
    </nav>

    <div class="mt-14 flex-1 @if (session()->has('flash') && session()->has('message')) blurred @endif">
        {{ $slot }}
    </div>

    {{-- Admin floating button --}}
    @auth
        @if (auth()->user()->is_admin)
            <div class="fixed bottom-6 right-6 z-40">
                <a href="{{ route('admin') }}"
                    class="flex items-center justify-center w-14 h-14 bg-amber-500 hover:bg-amber-400 text-gray-900 font-bold rounded-full shadow-xl transition-colors duration-200 text-sm">
                    Admin
                </a>
            </div>
        @endif
    @endauth

    @if (request()->routeIs('home'))
        <footer class="border-t border-gray-800 bg-gray-900">
            <div class="container mx-auto px-4 py-1.5 max-w-5xl flex items-center justify-between gap-4">
                <p class="text-gray-600 text-xs">&copy; {{ date('Y') }} TK Tolmin</p>
                <a href="{{ route('terms') }}" class="text-gray-600 hover:text-gray-400 text-xs transition-colors">Pogoji uporabe</a>
            </div>
        </footer>
    @else
        <footer class="border-t border-gray-200 bg-gray-50">
            <div class="container mx-auto px-4 py-1.5 max-w-5xl flex items-center justify-between gap-4">
                <p class="text-gray-400 text-xs">&copy; {{ date('Y') }} TK Tolmin</p>
                <a href="{{ route('terms') }}" class="text-gray-400 hover:text-gray-600 text-xs transition-colors">Pogoji uporabe</a>
            </div>
        </footer>
    @endif

    @if (session()->has('flash') && session()->has('message'))
        <x-flash-message :route="$route ?? null" :flash="$flash ?? null" :message="$message ?? null" :model="$model ?? null" />
    @elseif (session()->has('message'))
        <x-flash-message-2 :message="$message" />
    @endif
</body>

<script>
    // Navbar toggle
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('navbar-toggle').addEventListener('click', function () {
            document.getElementById('navbar-default').classList.toggle('hidden');
        });
    });

    // Scroll position persistence across form submissions
    window.onload = function () {
        if (performance.navigation.type === 1) {
            window.history.replaceState({}, document.title, window.location.pathname);
        } else {
            const pos = sessionStorage.getItem('scrollPosition');
            if (pos !== null) {
                window.scrollTo(0, pos);
                sessionStorage.removeItem('scrollPosition');
            }
        }
    };
    document.addEventListener('DOMContentLoaded', function () {
        document.addEventListener('submit', function () {
            sessionStorage.setItem('scrollPosition', window.scrollY);
        });
    });

    // Delete confirmation dialog
    function showDeleteConfirmation(formId, itemId) {
        var deleteForm = document.getElementById(formId + itemId);
        var confirmationForm = document.getElementById('confirmDeleteForm');
        var dialog = document.getElementById('deleteConfirmationDialog');
        dialog.classList.remove('hidden');
        confirmationForm.action = deleteForm.action;
    }
    function hideDeleteConfirmation() {
        document.getElementById('deleteConfirmationDialog').classList.add('hidden');
    }

    // Admin section toggle
    function toggleComponent(componentId) {
        var el = document.getElementById(componentId);
        var visible = el.style.display !== 'none';
        el.style.display = visible ? 'none' : 'block';
        localStorage.setItem(componentId, visible ? 'none' : 'block');
    }

    // Fullscreen image modal — used by gallery, news, carousel
    function showFullImage(imageUrl) {
        const overlay = document.createElement('div');
        overlay.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,0.92);display:flex;justify-content:center;align-items:center;z-index:9999;cursor:zoom-out;animation:fadeIn 0.2s ease';

        // Spinner
        const spinner = document.createElement('div');
        spinner.style.cssText = 'position:absolute;';
        spinner.innerHTML = '<svg width="44" height="44" viewBox="0 0 24 24" fill="none" style="animation:spin 0.8s linear infinite"><circle cx="12" cy="12" r="10" stroke="rgba(255,255,255,0.2)" stroke-width="3"/><path d="M12 2a10 10 0 0 1 10 10" stroke="white" stroke-width="3" stroke-linecap="round"/></svg>';
        overlay.appendChild(spinner);

        const img = document.createElement('img');
        img.alt = 'Fullscreen';
        img.style.cssText = 'max-width:90vw;max-height:90vh;object-fit:contain;border-radius:8px;opacity:0;transition:opacity 0.3s ease;box-shadow:0 30px 80px rgba(0,0,0,0.6);cursor:default';
        img.addEventListener('click', e => e.stopPropagation());
        img.onload = () => { spinner.remove(); img.style.opacity = '1'; };
        img.src = imageUrl;
        overlay.appendChild(img);

        // Close button
        const closeBtn = document.createElement('button');
        closeBtn.innerHTML = '&times;';
        closeBtn.style.cssText = 'position:absolute;top:16px;right:16px;background:rgba(255,255,255,0.12);border:none;color:white;width:40px;height:40px;border-radius:50%;font-size:22px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background 0.2s;line-height:1';
        closeBtn.onmouseover = () => closeBtn.style.background = 'rgba(255,255,255,0.25)';
        closeBtn.onmouseout = () => closeBtn.style.background = 'rgba(255,255,255,0.12)';
        closeBtn.addEventListener('click', e => { e.stopPropagation(); overlay.remove(); });
        overlay.appendChild(closeBtn);

        overlay.addEventListener('click', () => overlay.remove());

        const keyHandler = e => { if (e.key === 'Escape') { overlay.remove(); document.removeEventListener('keydown', keyHandler); } };
        document.addEventListener('keydown', keyHandler);

        document.body.appendChild(overlay);
    }
</script>

</html>

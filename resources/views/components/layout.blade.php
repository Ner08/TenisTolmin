<!doctype html>
<html lang="sl">

<head>
    <title>Teniški klub Tolmin</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Nejc Robič">
    <meta name="description" content="Teniški klub Tolmin je priljubljena destinacija za ljubitelje tenisa v Tolminu in okolici. Organiziramo teniško ligo, turnirje in različne dogodke za vse starosti.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="preload" as="image" href="{{ asset('images/logo10.png') }}">
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        [data-animate] {
            opacity: 0;
            transition: opacity 0.35s ease;
        }
        [data-animate].in-view {
            opacity: 1;
        }
        .ga {
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .ga.in-view {
            opacity: 1;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-white text-gray-900 antialiased flex flex-col min-h-screen">
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

    <nav class="bg-gray-900 border-b border-gray-800 fixed w-full top-0 left-0 z-50 h-14">
        <div class="h-full max-w-screen-2xl flex items-center justify-between mx-auto px-4">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/logo10.png') }}" alt="TK Tolmin logo" class="h-8 w-auto" width="32" height="32" fetchpriority="high" />
                <span class="text-xl font-bold text-white tracking-tight">Teniški klub Tolmin</span>
            </a>

            {{-- Desktop nav --}}
            <div class="hidden nav:flex items-center gap-1">
                @foreach ($navLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                              {{ request()->routeIs($link['route']) || request()->routeIs($link['route'].'*')
                                   ? 'text-amber-400'
                                   : 'text-gray-300 hover:text-white hover:bg-gray-800' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
                @auth
                    @php $unreadCount = \App\Models\AppNotification::where('user_id', auth()->id())->whereNull('read_at')->count(); @endphp
                    <a href="{{ route('notifications') }}" class="relative ml-2 p-2 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        @if ($unreadCount > 0)
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        @endif
                    </a>
                    <a href="{{ route('settings') }}" class="ml-1 text-sm font-medium text-amber-400 bg-amber-500/10 border border-amber-500/20 rounded-full px-3 py-1 max-w-[9rem] truncate hover:bg-amber-500/20 transition-colors">{{ \Str::limit(explode(' ', auth()->user()->name)[0], 12, '') }}</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800 transition-colors duration-150">
                            Odjava
                        </button>
                    </form>
                @else
                    <a href="{{ route('login_view') }}"
                       class="ml-2 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                              {{ request()->routeIs('login_view') ? 'text-amber-400' : 'text-gray-300 hover:text-white hover:bg-gray-800' }}">
                        Prijava
                    </a>
                @endauth
            </div>

            {{-- Mobile hamburger --}}
            <button id="navbar-toggle" type="button"
                class="nav:hidden flex items-center justify-center w-9 h-9 text-gray-400 rounded-lg hover:bg-gray-800 hover:text-white transition-colors focus:outline-none"
                aria-label="Open main menu">
                <svg id="hamburger-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="close-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </nav>

    {{-- Mobile menu — slides down flush below nav, z-50 to stay above league title bar (z-40) --}}
    <div id="mobile-menu"
         class="nav:hidden fixed left-0 right-0 z-50 bg-gray-900 overflow-hidden"
         style="top:56px; max-height:0; transition:max-height 0.25s cubic-bezier(0.4,0,0.2,1);">
        <div class="border-t border-gray-800">
            {{-- Nav links — icon + label rows --}}
            @php
                $navIcons = [
                    'news'       => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>',
                    'leagues'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>',
                    'gallery'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
                    'events'     => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
                    'membership' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>',
                    'contact'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
                ];
            @endphp
            <div class="flex flex-col divide-y divide-gray-800/60">
                @foreach ($navLinks as $link)
                    @php $isActive = request()->routeIs($link['route']) || request()->routeIs($link['route'].'*'); @endphp
                    <a href="{{ route($link['route']) }}"
                       class="flex items-center gap-3.5 px-5 py-3.5 text-sm font-medium transition-colors
                              {{ $isActive ? 'text-white bg-gray-800/50' : 'text-gray-400 hover:text-white hover:bg-gray-800/30' }}">
                        <svg class="w-5 h-5 flex-shrink-0 {{ $isActive ? 'text-amber-400' : 'text-gray-600' }}"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $navIcons[$link['route']] !!}
                        </svg>
                        <span class="flex-1">{{ $link['label'] }}</span>
                        <svg class="w-4 h-4 flex-shrink-0 {{ $isActive ? 'text-amber-400' : 'text-gray-700' }}"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @endforeach
            </div>
            {{-- Auth row --}}
            <div class="flex items-center justify-between px-4 py-3 border-t border-gray-800/60">
                @auth
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="w-7 h-7 rounded-full bg-amber-500/20 flex items-center justify-center text-xs font-bold text-amber-400 flex-shrink-0">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                        <span class="text-sm font-medium text-gray-300 truncate">{{ \Str::limit(explode(' ', auth()->user()->name)[0], 12, '') }}</span>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <a href="{{ route('notifications') }}" class="relative p-1.5 text-gray-400 hover:text-white rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            @if (isset($unreadCount) && $unreadCount > 0)
                                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            @endif
                        </a>
                        <a href="{{ route('settings') }}"
                           class="text-xs font-medium text-gray-400 hover:text-white transition-colors px-3 py-1.5 rounded-full bg-gray-800 hover:bg-gray-700">
                            Nastavitve
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs font-medium text-gray-500 hover:text-white transition-colors px-3 py-1.5 rounded-full bg-gray-800 hover:bg-gray-700">
                                Odjava
                            </button>
                        </form>
                    </div>
                @else
                    <span class="text-sm text-gray-600">Niste prijavljeni</span>
                    <a href="{{ route('login_view') }}"
                       class="text-xs font-semibold px-4 py-1.5 rounded-full bg-amber-500 text-gray-900 hover:bg-amber-400 transition-colors">
                        Prijava
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <x-delete-confirmation />
    <x-score-dialog />

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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Animate elements in once on initial page load (no scroll-triggered reveal).
            document.querySelectorAll('[data-animate]').forEach(function (el) {
                el.classList.add('in-view');
            });

            document.querySelectorAll('.grid').forEach(function (grid) {
                Array.from(grid.children).forEach(function (child, i) {
                    child.classList.add('ga');
                    child.style.transitionDelay = Math.min(i * 80, 320) + 'ms';
                });
            });
            // Defer to next frame so the initial opacity:0 state is painted before transitioning in.
            requestAnimationFrame(function () {
                document.querySelectorAll('.ga').forEach(function (el) {
                    el.classList.add('in-view');
                });
            });

            // Fade in CSS background-image particles
            var particles = document.querySelector('.js-particles');
            if (particles) {
                var src = particles.style.backgroundImage.replace(/url\(['"]?(.+?)['"]?\)/, '$1');
                var preload = new Image();
                preload.onload = function () { particles.style.opacity = '0.6'; };
                preload.src = src;
            }

            // Fade images in on load so they don't snap in
            document.querySelectorAll('img[loading="lazy"]').forEach(function (img) {
                img.style.opacity = '0';
                img.style.transition = 'opacity 0.35s ease';
                if (img.complete && img.naturalWidth > 0) {
                    img.style.opacity = '1';
                } else {
                    img.addEventListener('load', function () { img.style.opacity = '1'; });
                    img.addEventListener('error', function () { img.style.opacity = '1'; });
                }
            });
        });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var toggle    = document.getElementById('navbar-toggle');
        var menu      = document.getElementById('mobile-menu');
        var hamburger = document.getElementById('hamburger-icon');
        var closeIcon = document.getElementById('close-icon');
        var nav       = document.querySelector('nav');

        if (!toggle || !menu) return;

        // Pin menu flush to bottom of nav (including its 1px border), then re-measure open height
        function pinMenu() {
            if (!nav) return;
            menu.style.top = nav.getBoundingClientRect().bottom + 'px';
            if (menu.style.maxHeight !== '0px' && menu.style.maxHeight !== '') {
                menu.style.maxHeight = menu.scrollHeight + 'px';
            }
        }
        pinMenu();
        window.addEventListener('resize', pinMenu);

        function openMenu() {
            menu.style.maxHeight = menu.scrollHeight + 'px';
            menu.style.borderBottom = '1px solid rgb(55 65 81)';
            menu.style.boxShadow = '0 10px 25px -5px rgb(0 0 0 / 0.4)';
            hamburger.classList.add('hidden');
            closeIcon.classList.remove('hidden');
        }

        function closeMenu() {
            menu.style.maxHeight = '0';
            menu.style.borderBottom = '';
            menu.style.boxShadow = '';
            hamburger.classList.remove('hidden');
            closeIcon.classList.add('hidden');
        }

        toggle.addEventListener('click', function() {
            menu.style.maxHeight === '0px' || !menu.style.maxHeight ? openMenu() : closeMenu();
        });

        menu.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', closeMenu);
        });

        document.addEventListener('click', function(e) {
            if (!menu.contains(e.target) && !toggle.contains(e.target)) closeMenu();
        });
    });
    </script>

    @if (!request()->routeIs('league') && !request()->routeIs('admin') && !request()->routeIs('admin_board'))
        @if (request()->routeIs('home'))
            <footer class="border-t border-gray-800 bg-gray-900">
                <div class="container mx-auto px-4 py-1.5 max-w-5xl xl:max-w-7xl flex items-center justify-between gap-4">
                    <p class="text-gray-600 text-xs">&copy; {{ date('Y') }} TK Tolmin</p>
                    <a href="{{ route('terms') }}" class="text-gray-600 hover:text-gray-400 text-xs transition-colors">Pogoji uporabe</a>
                </div>
            </footer>
        @else
            <footer class="border-t border-gray-200 bg-gray-50">
                <div class="container mx-auto px-4 py-1.5 max-w-5xl xl:max-w-7xl flex items-center justify-between gap-4">
                    <p class="text-gray-400 text-xs">&copy; {{ date('Y') }} TK Tolmin</p>
                    <a href="{{ route('terms') }}" class="text-gray-400 hover:text-gray-600 text-xs transition-colors">Pogoji uporabe</a>
                </div>
            </footer>
        @endif
    @endif

    @if (session()->has('flash') && session()->has('message'))
        <x-flash-message :route="$route ?? null" :flash="$flash ?? null" :message="$message ?? null" :model="$model ?? null" />
    @elseif (session()->has('message'))
        <x-flash-message-2 :message="session('message')" />
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
            if (typeof currentLeagueTab !== 'undefined' && currentLeagueTab) {
                sessionStorage.setItem('leagueReturnPanel', currentLeagueTab);
                sessionStorage.setItem('leagueReturnSub', typeof currentSubTab !== 'undefined' ? currentSubTab : 'content');
            }
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

    function showConfirmAction(formId, itemId, title, message, btnText, btnColor) {
        var sourceForm = document.getElementById(formId + itemId);
        var dialog     = document.getElementById('confirmActionDialog');
        var form       = document.getElementById('confirmActionForm');
        var btn        = document.getElementById('confirmActionBtn');
        document.getElementById('confirmActionTitle').textContent   = title || 'Ste prepričani?';
        document.getElementById('confirmActionMessage').textContent = message || '';
        btn.textContent = btnText || 'Potrdi';
        btn.className = 'px-5 py-2 text-sm font-medium text-white rounded-lg transition-colors duration-150 ' +
            (btnColor === 'red' ? 'bg-red-600 hover:bg-red-700' : 'bg-amber-500 hover:bg-amber-600');
        form.action = sourceForm.action;
        dialog.classList.remove('hidden');
    }
    function hideConfirmAction() {
        document.getElementById('confirmActionDialog').classList.add('hidden');
    }

    // Score entry dialog
    var _sdlgMatchId = null, _sdlgIsAdmin = false;

    function openScoreDialog(matchId, t1Name, t2Name, isAdmin, prefill) {
        _sdlgMatchId = matchId;
        _sdlgIsAdmin = isAdmin;
        document.getElementById('scoreDialogTitle').textContent = t1Name + ' — ' + t2Name;
        document.getElementById('scoreDialogT1').textContent = t1Name;
        document.getElementById('scoreDialogT2').textContent = t2Name;
        var fields = ['sdlg_t1s1','sdlg_t2s1','sdlg_t1s2','sdlg_t2s2','sdlg_t1s3','sdlg_t2s3'];
        var keys   = ['t1s1','t2s1','t1s2','t2s2','t1s3','t2s3'];
        fields.forEach(function(id, i) {
            var el = document.getElementById(id);
            el.value = (prefill && prefill[keys[i]] != null && prefill[keys[i]] !== '') ? prefill[keys[i]] : '';
            el.classList.remove('border-red-400');
        });
        document.getElementById('scoreDialog').classList.remove('hidden');
        document.getElementById('sdlg_t1s1').focus();
    }

    function closeScoreDialog() {
        document.getElementById('scoreDialog').classList.add('hidden');
        _sdlgMatchId = null;
    }

    function submitScoreFromDialog() {
        if (!_sdlgMatchId) return;
        var required = ['sdlg_t1s1','sdlg_t2s1','sdlg_t1s2','sdlg_t2s2'];
        var valid = true;
        required.forEach(function(id) {
            var el = document.getElementById(id);
            if (el.value === '') { valid = false; el.classList.add('border-red-400'); }
            else el.classList.remove('border-red-400');
        });
        if (!valid) return;

        var formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        formData.append('t1_first_set',  document.getElementById('sdlg_t1s1').value);
        formData.append('t2_first_set',  document.getElementById('sdlg_t2s1').value);
        formData.append('t1_second_set', document.getElementById('sdlg_t1s2').value);
        formData.append('t2_second_set', document.getElementById('sdlg_t2s2').value);
        var t1s3 = document.getElementById('sdlg_t1s3').value;
        var t2s3 = document.getElementById('sdlg_t2s3').value;
        if (t1s3 !== '') formData.append('t1_third_set', t1s3);
        if (t2s3 !== '') formData.append('t2_third_set', t2s3);

        var url = _sdlgIsAdmin
            ? '{{ route("matchups.admin.confirm", ":id") }}'.replace(':id', _sdlgMatchId) + '?_score=1'
            : '{{ route("matchups.result.store", ":id") }}'.replace(':id', _sdlgMatchId);

        closeScoreDialog();

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: formData,
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                if (typeof currentLeagueTab !== 'undefined' && currentLeagueTab) {
                    sessionStorage.setItem('leagueReturnPanel', currentLeagueTab);
                    sessionStorage.setItem('leagueReturnSub', typeof currentSubTab !== 'undefined' ? currentSubTab : 'content');
                }
                location.reload();
            }
        })
        .catch(function() { alert('Napaka pri pošiljanju rezultata'); });
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
        overlay.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,0.92);display:flex;justify-content:center;align-items:center;z-index:9999;cursor:zoom-out;opacity:0;transition:opacity 0.3s ease';
        requestAnimationFrame(() => requestAnimationFrame(() => overlay.style.opacity = '1'));

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

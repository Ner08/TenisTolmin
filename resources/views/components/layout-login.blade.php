<!doctype html>
<html lang="sl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="font-sans antialiased">
    <nav class="bg-gray-900 border-b border-gray-800">
        <div class="max-w-screen-2xl flex items-center justify-between mx-auto px-4 py-3">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/logo10.png') }}" alt="logo" class="h-8 w-auto" />
                <span class="text-white font-semibold text-lg">Teniški klub Tolmin</span>
            </a>
        </div>
    </nav>

    {{ $slot }}
</body>
</html>

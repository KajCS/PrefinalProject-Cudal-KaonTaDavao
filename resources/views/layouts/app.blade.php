<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Kaon Ta! Davao – Cudal\'s Food Guide')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-orange-50 min-h-screen flex flex-col">
    @include('partials.nav')

    <main class="flex-1 w-full max-w-6xl mx-auto px-4 py-6">
        @include('partials.flash')
        @yield('content')
    </main>

    <footer class="bg-white border-t text-center text-sm text-gray-500 py-4">
        Kaon Ta! Davao · City Tourism Office
    </footer>
</body>
</html>
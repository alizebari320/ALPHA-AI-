@php
    $locale = app()->getLocale();
    $locales = config('alphaai.locales', []);
    $dir = $locales[$locale]['dir'] ?? 'ltr';
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'AlphaAi'))</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head')
    </head>
    <body class="bg-graphite text-gray-200 font-sans antialiased{{ $dir === 'rtl' ? ' font-kurdish' : '' }}">
        @yield('content')
        @stack('scripts')
    </body>
</html>

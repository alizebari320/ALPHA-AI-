{{-- ALPHA AI v2 · shared <head> + chrome guard. Keeps: site-lang(so/ba), color-theme, kurdai-firebase-config, kurdai-imgbb-config, KaiF bootstrap, KaiPageReady, analytics beacon. --}}
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'ALPHA AI')</title>
<link rel="icon" href="{{ asset('favicon-alpha.svg') }}" type="image/svg+xml">
<link rel="stylesheet" href="{{ asset('css/alpha-theme.css') }}?v=1">
<script>
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    }
</script>
<script src="{{ asset('js/alpha-core.js') }}?v=1" defer></script>
@stack('head')

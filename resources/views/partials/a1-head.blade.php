{{-- A1 · shared head. Keeps: color-theme, site-lang, KaiPageReady, KaiF bootstrap, analytics --}}
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'ALPHA AI')</title>
<link rel="icon" href="{{ asset('favicon-a1.svg') }}" type="image/svg+xml">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;700;900&family=Vazirmatn:wght@400;700&family=JetBrains+Mono:wght@400;700&display=swap">
<link rel="stylesheet" href="{{ asset('css/a1.css') }}?v=3">
<script>
    /* dark-first: only honor explicit light choice */
    if (localStorage.getItem('color-theme') === 'light') {
        document.documentElement.classList.remove('dark');
    } else {
        document.documentElement.classList.add('dark');
    }
</script>
<script src="{{ asset('js/a1-core.js') }}?v=3"></script>
<script type="application/json" id="kurdai-firebase-config">{!! json_encode(config('kurdai.firebase'), 15) !!}</script>
<script type="application/json" id="kurdai-imgbb-config">{!! json_encode(config('kurdai.imgbb.api_key'), 15) !!}</script>
<script src="/js/kai-firebase.js?v=2" data-kai-shared defer></script>
@stack('a1-head')

<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ALPHA AI — {{ $__env->yieldContent('title') ?? 'Auth' }}</title>
    <link rel="icon" href="{{ asset('favicon-alpha.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('css/alpha-theme.css') }}?v=1">
</head>
<body class="al-body" style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px;background:var(--al-bg)">
    <main class="al-card al-card--pad" style="width:100%;max-width:420px">
        <div style="text-align:center;margin-bottom:20px">
            <img src="{{ asset('logo-alpha.svg') }}" width="44" height="44" alt="ALPHA AI">
        </div>
        {{ $slot }}
    </main>
</body>
</html>

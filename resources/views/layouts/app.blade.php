<!DOCTYPE html>
<html lang="ckb" dir="rtl" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ALPHA AI</title>
    <link rel="icon" href="{{ asset('favicon-a1.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('css/a1.css') }}?v=1">
    <script src="/js/a1-core.js?v=1" defer></script>
</head>
<body class="a1">
    @include('partials.a1-rail')
    <div class="a1-main">
        <div class="a1-page">
            {{ $slot }}
            @include('partials.a1-foot')
        </div>
    </div>
</body>
</html>

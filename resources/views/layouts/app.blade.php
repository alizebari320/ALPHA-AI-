<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ALPHA AI</title>
    <link rel="icon" href="{{ asset('favicon-alpha.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('css/alpha-theme.css') }}?v=1">
</head>
<body class="al-body">
    @include('partials.alpha-nav')
    <main class="al-container al-section">{{ $slot }}</main>
    @include('partials.alpha-foot')
</body>
</html>

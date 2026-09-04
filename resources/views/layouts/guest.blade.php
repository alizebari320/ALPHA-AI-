<!DOCTYPE html>
<html lang="ckb" dir="rtl" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ALPHA AI</title>
    <link rel="icon" href="{{ asset('favicon-a1.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('css/a1.css') }}?v=1">
</head>
<body class="a1" style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px">
    <main style="width:100%;max-width:400px">
        <div style="text-align:center;margin-bottom:22px">
            <img src="{{ asset('mark-a1.svg') }}" width="44" height="44" alt="ALPHA AI">
        </div>
        {{ $slot }}
    </main>
</body>
</html>

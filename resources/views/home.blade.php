@extends('layouts.app')

@section('title', 'سەرەکی')

@section('content')
@include('partials.nav', ['active' => 'home'])

    <div class="tech-glow w-80 h-80 top-0 right-1/3"></div>

    <main class="relative z-10 min-h-[70vh] flex items-center justify-center px-4">
        <p class="font-mono text-4xl md:text-6xl tracking-widest text-stone-700 dark:text-stone-500">// خاڵیە</p>
    </main>

    @include('partials.footer')

@endsection

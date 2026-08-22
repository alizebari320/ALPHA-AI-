@extends('layouts.app')

@section('title', __('Dashboard — ALPHA/AI'))

@section('content')
<div class="min-h-screen bg-void text-white overflow-hidden">

    {{-- Hero / Header --}}
    <section class="relative overflow-hidden border-b-2 border-edge">
        <div class="absolute -top-20 start-1/4 w-[500px] h-[500px] rounded-full bg-neon-blue/10 blur-[160px] pointer-events-none"></div>
        <div class="absolute -bottom-24 -end-1/4 w-[400px] h-[400px] rounded-full bg-neon-cyan/10 blur-[140px] pointer-events-none"></div>
        <div class="relative max-w-7xl mx-auto px-4 py-20 sm:py-28 lg:py-32">
            <p class="font-mono text-[11px] uppercase tracking-[0.3em] text-neon-cyan mb-4">// {{ __('Dashboard') }}</p>
            <h1 class="font-mega text-5xl sm:text-7xl lg:text-8xl tracking-tight leading-[0.92] mb-6">
                <span class="text-white">{{ __('داشبۆرد') }}</span><br>
                <span class="bg-gradient-to-r from-neon-blue via-neon-cyan to-neon-blue bg-clip-text text-transparent animate-sweep">{{ __('Your AI Hub') }}</span>
            </h1>
            <p class="max-w-2xl text-zinc-400 text-lg leading-relaxed">{{ __('Track your progress, manage favorites, and explore new AI resources from your personalized dashboard.') }}</p>
        </div>
    </section>

    {{-- Stats --}}
    <section class="max-w-7xl mx-auto px-4 -mt-12 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="p-6 rounded-2xl border-2 border-edge bg-card/80 backdrop-blur-sm animate-card-in" style="animation-delay: 0ms;">
                <div class="font-mega text-3xl text-neon-cyan">{{ $activityCount ?? 0 }}</div>
                <p class="font-mono text-[10px] uppercase tracking-widest text-zinc-500 mt-1">{{ __('Tools Viewed') }}</p>
            </div>
            <div class="p-6 rounded-2xl border-2 border-edge bg-card/80 backdrop-blur-sm animate-card-in" style="animation-delay: 80ms;">
                <div class="font-mega text-3xl text-neon-blue">{{ $conversationCount ?? 0 }}</div>
                <p class="font-mono text-[10px] uppercase tracking-widest text-zinc-500 mt-1">{{ __('Courses') }}</p>
            </div>
            <div class="p-6 rounded-2xl border-2 border-edge bg-card/80 backdrop-blur-sm animate-card-in" style="animation-delay: 160ms;">
                <div class="font-mega text-3xl text-neon-cyan">{{ count($savedTools ?? []) + count($savedPrompts ?? []) }}</div>
                <p class="font-mono text-[10px] uppercase tracking-widest text-zinc-500 mt-1">{{ __('Saved') }}</p>
            </div>
            <div class="p-6 rounded-2xl border-2 border-edge bg-card/80 backdrop-blur-sm animate-card-in" style="animation-delay: 240ms;">
                <div class="font-mega text-3xl text-neon-blue">{{ $promptCount ?? 0 }}</div>
                <p class="font-mono text-[10px] uppercase tracking-widest text-zinc-500 mt-1">{{ __('Days Active') }}</p>
            </div>
            <a href="{{ route('assistant.index') }}" class="group relative p-8 rounded-2xl border-2 border-edge bg-card/50 backdrop-blur-sm transition-all duration-500 hover:border-neon-cyan/50 hover:-translate-y-1"><h3 class="font-mega text-xl tracking-wide text-white mb-2">{{ __('AlphaAi Assistant') }}</h3><p class="text-zinc-400 text-sm">{{ __('Find a tool, prompt, or learning path.') }}</p></a>
        </div>
        @if(($savedTools ?? collect())->count())<h2 class="font-mega text-2xl tracking-wide text-white mt-16 mb-8">{{ __('Saved tools') }}</h2><div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">@foreach($savedTools as $saved)<a href="{{ route('tools.show', $saved->tool_key) }}" class="p-5 rounded-2xl border-2 border-edge bg-card/50 hover:border-neon-cyan/50"><strong class="text-white">{{ $saved->tool_name }}</strong><span class="block text-zinc-500 text-sm mt-1">{{ $saved->category }}</span></a>@endforeach</div>@endif
    </section>

    {{-- Quick Access Cards --}}
    <main class="max-w-7xl mx-auto px-4 py-16">
        <h2 class="font-mega text-2xl tracking-wide text-white mb-8">{{ __('Quick Access') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('tools.index') }}" class="group relative p-8 rounded-2xl border-2 border-edge bg-card/50 backdrop-blur-sm transition-all duration-500 hover:border-neon-cyan/50 hover:-translate-y-1 hover:shadow-neon hover:bg-neon-blue/[0.03]">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-neon-blue/20 to-neon-cyan/20 border border-neon-cyan/30 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-neon-cyan" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="font-mega text-xl tracking-wide text-white mb-2">{{ __('AI Tools') }}</h3>
                <p class="text-zinc-400 text-sm">{{ __('Browse and compare AI tools.') }}</p>
                <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-neon-blue/60 to-neon-cyan/60 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            </a>
            <a href="/courses" class="group relative p-8 rounded-2xl border-2 border-edge bg-card/50 backdrop-blur-sm transition-all duration-500 hover:border-neon-blue/50 hover:-translate-y-1 hover:shadow-[0_20px_50px_-12px_rgba(0,102,255,0.12)] hover:bg-neon-blue/[0.03]">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-neon-blue/20 to-neon-cyan/20 border border-neon-blue/30 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-neon-blue" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <h3 class="font-mega text-xl tracking-wide text-white mb-2">{{ __('Courses') }}</h3>
                <p class="text-zinc-400 text-sm">{{ __('Continue structured AI learning.') }}</p>
                <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-neon-blue/60 to-neon-cyan/60 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            </a>
            <a href="/news" class="group relative p-8 rounded-2xl border-2 border-edge bg-card/50 backdrop-blur-sm transition-all duration-500 hover:border-neon-cyan/50 hover:-translate-y-1 hover:shadow-[0_20px_50px_-12px_rgba(0,255,255,0.12)] hover:bg-neon-cyan/[0.03]">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-neon-cyan/20 to-neon-blue/20 border border-neon-cyan/30 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-neon-cyan" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <h3 class="font-mega text-xl tracking-wide text-white mb-2">{{ __('News') }}</h3>
                <p class="text-zinc-400 text-sm">{{ __('Stay updated with AI insights.') }}</p>
                <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-neon-cyan/60 to-neon-blue/60 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            </a>
        </div>
    </main>
</div>

@push('styles')
<style>
    @keyframes sweep { 0%{background-position:0% 50%} 100%{background-position:200% 50%} }
    .animate-sweep { background-size:200% 200%; animation:sweep 3s linear infinite; }
</style>
@endpush
@endsection

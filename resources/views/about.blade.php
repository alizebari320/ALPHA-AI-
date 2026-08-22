@extends('layouts.app')

@section('title', 'دەربارە — ALPHA/AI')

@section('content')
<div class="min-h-screen bg-void text-zinc-100 overflow-hidden">

    {{-- Hero with gradient text --}}
    <section class="relative overflow-hidden border-b-2 border-edge">
        <div class="absolute -top-32 -start-1/4 w-[500px] h-[500px] rounded-full bg-cyan-400/10 blur-[150px] pointer-events-none"></div>
        <div class="absolute -bottom-24 -end-1/4 w-[400px] h-[400px] rounded-full bg-pink-400/10 blur-[120px] pointer-events-none"></div>

        <div class="relative max-w-5xl mx-auto px-4 py-24 sm:py-32 lg:py-40 text-center">
            <p class="font-mono text-[11px] uppercase tracking-[0.3em] text-cyan-400 mb-6">// {{ __('About the Platform') }}</p>
            <h1 class="font-mega text-5xl sm:text-7xl lg:text-8xl tracking-tight leading-[0.92] mb-8">
                <span class="block text-white">دەربارەی</span>
                <span class="block bg-gradient-to-r from-cyan-400 via-violet-500 to-pink-400 bg-clip-text text-transparent animate-gradient-x">{{ __('ALPHA / AI') }}</span>
            </h1>
            <p class="max-w-2xl mx-auto text-lg sm:text-xl text-zinc-400 leading-relaxed">
                {{ __('A Kurdish-first artificial intelligence platform built for learners, researchers, and builders. Tools, structured learning, and real-time insights — all in your language.') }}
            </p>
            <div class="mt-10 flex flex-wrap items-center justify-center gap-3">
                <a href="/" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border-2 border-cyan-400/30 bg-cyan-400/10 text-cyan-300 font-display text-sm font-semibold tracking-wide transition-all hover:bg-cyan-400 hover:text-void hover:-translate-y-0.5 hover:shadow-[0_0_30px_-4px_rgba(34,229,255,0.6)]">
                    {{ __('Back Home') }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- Values / Features Grid --}}
    <section class="max-w-7xl mx-auto px-4 py-20 lg:py-28">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <article class="group relative p-8 rounded-2xl border-2 border-edge bg-card/50 backdrop-blur-sm transition-all duration-500 hover:border-cyan-400/40 hover:-translate-y-1.5 hover:shadow-[0_30px_60px_-20px_rgba(34,229,255,0.12)] hover:bg-cyan-400/[0.03]">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-cyan-500/20 to-violet-500/20 border border-cyan-400/30 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="font-mega text-xl tracking-wide text-white mb-3">{{ __('AI Tools Directory') }}</h3>
                <p class="text-zinc-400 text-sm leading-relaxed">{{ __('Discover and compare 200+ AI tools across development, writing, design, research, and Kurdish AI.') }}</p>
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-cyan-400/[0.04] via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
            </article>

            <article class="group relative p-8 rounded-2xl border-2 border-edge bg-card/50 backdrop-blur-sm transition-all duration-500 hover:border-violet-400/40 hover:-translate-y-1.5 hover:shadow-[0_30px_60px_-20px_rgba(139,92,255,0.12)] hover:bg-violet-400/[0.03]">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-violet-500/20 to-pink-500/20 border border-violet-400/30 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-violet-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <h3 class="font-mega text-xl tracking-wide text-white mb-3">{{ __('Structured Learning') }}</h3>
                <p class="text-zinc-400 text-sm leading-relaxed">{{ __('Step-by-step video courses with in-browser practice. From programming basics to advanced AI/ML.') }}</p>
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-violet-400/[0.04] via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
            </article>

            <article class="group relative p-8 rounded-2xl border-2 border-edge bg-card/50 backdrop-blur-sm transition-all duration-500 hover:border-pink-400/40 hover:-translate-y-1.5 hover:shadow-[0_30px_60px_-20px_rgba(255,47,185,0.12)] hover:bg-pink-400/[0.03]">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-pink-500/20 to-red-500/20 border border-pink-400/30 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-pink-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <h3 class="font-mega text-xl tracking-wide text-white mb-3">{{ __('Live AI News') }}</h3>
                <p class="text-zinc-400 text-sm leading-relaxed">{{ __('Automated pipeline fetching latest research and industry updates. Curated and summarized for you.') }}</p>
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-pink-400/[0.04] via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
            </article>
        </div>
    </section>

    {{-- Stats / Trust Bar --}}
    <section class="border-t-2 border-edge border-b-2 bg-card/30">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center p-6 rounded-2xl bg-card/40 border-2 border-edge backdrop-blur-sm">
                    <div class="font-mega text-4xl sm:text-5xl bg-gradient-to-r from-cyan-400 to-violet-400 bg-clip-text text-transparent">200+</div>
                    <p class="font-mono text-[11px] uppercase tracking-widest text-zinc-500 mt-2">{{ __('AI Tools') }}</p>
                </div>
                <div class="text-center p-6 rounded-2xl bg-card/40 border-2 border-edge backdrop-blur-sm">
                    <div class="font-mega text-4xl sm:text-5xl bg-gradient-to-r from-violet-400 to-pink-400 bg-clip-text text-transparent">50+</div>
                    <p class="font-mono text-[11px] uppercase tracking-widest text-zinc-500 mt-2">{{ __('Courses') }}</p>
                </div>
                <div class="text-center p-6 rounded-2xl bg-card/40 border-2 border-edge backdrop-blur-sm">
                    <div class="font-mega text-4xl sm:text-5xl bg-gradient-to-r from-pink-400 to-cyan-400 bg-clip-text text-transparent">4</div>
                    <p class="font-mono text-[11px] uppercase tracking-widest text-zinc-500 mt-2">{{ __('Languages') }}</p>
                </div>
                <div class="text-center p-6 rounded-2xl bg-card/40 border-2 border-edge backdrop-blur-sm">
                    <div class="font-mega text-4xl sm:text-5xl bg-gradient-to-r from-cyan-400 to-lime-400 bg-clip-text text-transparent">24/7</div>
                    <p class="font-mono text-[11px] uppercase tracking-widest text-zinc-500 mt-2">{{ __('Access') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Mission Statement --}}
    <section class="max-w-4xl mx-auto px-4 py-20 lg:py-28 text-center">
        <h2 class="font-mega text-3xl sm:text-4xl lg:text-5xl tracking-tight text-white mb-6">{{ __('Built for Kurdish AI') }}</h2>
        <p class="text-zinc-400 text-lg leading-relaxed">
            {{ __('ALPHA/AI is the first platform designed specifically for Kurdish-language learners navigating artificial intelligence. From curated tool directories to structured academic guides, everything is designed to reduce friction and accelerate understanding.') }}
        </p>
    </section>

</div>

@push('styles')
<style>
    @keyframes gradientX {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
    .animate-gradient-x { background-size: 200% 200%; animation: gradientX 8s ease infinite; }
</style>
@endpush
@endsection

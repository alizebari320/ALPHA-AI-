@extends('layouts.app')

@section('title', 'Dashboard — ALPHA/AI')

@section('content')
@include('partials.nav', ['active' => 'home'])

<div class="tech-glow w-96 h-96 bg-gold/30 -top-24 left-1/3"></div>

<div class="py-12 relative z-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
        <h2 class="font-black text-2xl font-display glow-text mb-8">
            {{ __('Dashboard') }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="card p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gold/10 border border-gold/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V10"/></svg>
                    </div>
                    <div>
                        <div class="text-sm text-slate-500 dark:text-slate-400 font-bold">{{ __('Dashboard') }}</div>
                        <div class="text-xl font-black text-slate-900 dark:text-white">AlphaAi</div>
                    </div>
                </div>
            </div>
            <div class="card p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gold/10 border border-gold/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <div class="text-sm text-slate-500 dark:text-slate-400 font-bold">{{ __('User') }}</div>
                        <div class="text-xl font-black text-slate-900 dark:text-white">{{ Auth::user()->name }}</div>
                    </div>
                </div>
            </div>
            <div class="card p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gold/10 border border-gold/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <div class="text-sm text-slate-500 dark:text-slate-400 font-bold">{{ __('Status') }}</div>
                        <div class="text-xl font-black text-amber-700">{{ __('Active') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card p-6 sm:p-8 overflow-hidden">
            <div class="flex items-center justify-between flex-wrap gap-4 mb-6">
                <div>
                    <h3 class="text-xl font-black font-display text-slate-900 dark:text-white mb-1">{{ __("You're logged in!") }}</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('Welcome to the AlphaAi control panel.') }}</p>
                </div>
                <a href="/" class="btn btn-primary">گەڕانەوە بۆ سەرەکی</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="/courses" class="bg-gold/10 text-amber-800 dark:text-gold font-bold py-4 px-6 rounded-xl text-center hover:bg-gold/20 transition border border-gold/20">کۆرسەکان</a>
                <a href="/ai-tools" class="bg-gold/10 text-amber-800 dark:text-gold font-bold py-4 px-6 rounded-xl text-center hover:bg-gold/20 transition border border-gold/20">تووڵەکانی AI</a>
                <a href="/profile" class="bg-gold/10 text-amber-800 dark:text-gold font-bold py-4 px-6 rounded-xl text-center hover:bg-gold/20 transition border border-gold/20">پەڕەی پڕۆفایل</a>
            </div>
        </div>
    </div>
</div>

@include('partials.footer')
@endsection

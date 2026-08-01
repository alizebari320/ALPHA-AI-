@extends('layouts.app')

@section('title', 'دەربارە — ALPHA/AI')

@section('content')
@include('partials.nav', ['active' => 'about'])

    

    <div class="tech-glow w-72 h-72 bg-gold -top-20 left-1/4"></div>
    <div class="tech-glow w-96 h-96 bg-amber-600 top-60 -right-24"></div>

    <header class="relative z-10 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 py-20 md:py-24 text-center relative">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-gold/40 bg-gold/10 text-amber-800 dark:text-gold text-xs font-bold mb-5 anim-slide-up">
                <span class="w-2 h-2 rounded-full bg-gold animate-pulse"></span>
                تیمی AlphaAi
            </div>
            <h1 class="text-5xl md:text-7xl font-black font-display tracking-tight mb-4 anim-slide-up delay-1 text-slate-900 dark:text-white">دەربارەی <span class="glow-text">AlphaAi</span></h1>
            <p class="text-lg text-slate-500 dark:text-slate-400 max-w-2xl mx-auto anim-slide-up delay-2">ناساندنی ئەندامانی تیمی پڕۆژە و زانیارییە پەیوەندییەکان</p>
        </div>
    </header>

    <section class="relative z-10 max-w-7xl mx-auto px-4 pb-24">
        <h2 class="text-3xl md:text-4xl font-black font-display text-center text-slate-900 dark:text-white mb-14">
            ئەندامانی <span class="glow-text">سەرەکی</span> پڕۆژە
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="tech-card glass p-8 flex flex-col anim-slide-up delay-1 relative overflow-hidden">
                <div class="absolute -top-10 -left-10 w-32 h-32 rounded-full bg-gold/15 blur-2xl"></div>
                <div class="text-center mb-6 relative">
                    <div class="w-28 h-28 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-4xl font-black text-white shadow-xl shadow-amber-700/30">م</div>
                    <h3 class="text-2xl font-black font-display text-slate-900 dark:text-white">محمد کامران حمەساڵح</h3>
                    <p class="text-amber-800 dark:text-gold font-bold text-sm mt-1">سەرپەرشتیاری گشتی و پەرەپێدەری سەرەکی</p>
                </div>
                <div class="space-y-3 mt-auto pt-6 border-t border-slate-200/70 dark:border-white/10 relative">
                    <span class="flex items-center gap-3 text-sm font-semibold text-slate-600 dark:text-slate-300"><svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg> alphaaiteam@gmail.com</span>
                    <span class="flex items-center gap-3 text-sm font-semibold text-slate-600 dark:text-slate-300"><svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg> 07511915347</span>
                </div>
            </div>

            <div class="tech-card glass p-8 flex flex-col anim-slide-up delay-2 relative overflow-hidden">
                <div class="absolute -top-10 -left-10 w-32 h-32 rounded-full bg-gold/15 blur-2xl"></div>
                <div class="text-center mb-6 relative">
                    <div class="w-28 h-28 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-4xl font-black text-white shadow-xl shadow-amber-700/30">?</div>
                    <h3 class="text-2xl font-black font-display text-slate-900 dark:text-white">[ ناوی ئەندامی دووەم ]</h3>
                    <p class="text-amber-800 dark:text-gold font-bold text-sm mt-1">[ ڕۆڵ ]</p>
                </div>
                <div class="space-y-3 mt-auto pt-6 border-t border-slate-200/70 dark:border-white/10 relative">
                    <span class="flex items-center gap-3 text-sm font-semibold text-slate-600 dark:text-slate-300"><svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg> [email2@example.com]</span>
                    <span class="flex items-center gap-3 text-sm font-semibold text-slate-600 dark:text-slate-300"><svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg> [ ژمارە موبایل ]</span>
                </div>
            </div>

            <div class="tech-card glass p-8 flex flex-col anim-slide-up delay-3 relative overflow-hidden">
                <div class="absolute -top-10 -left-10 w-32 h-32 rounded-full bg-gold/10 blur-2xl"></div>
                <div class="text-center mb-6 relative">
                    <div class="w-28 h-28 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-4xl font-black text-white shadow-xl shadow-amber-700/30">?</div>
                    <h3 class="text-2xl font-black font-display text-slate-900 dark:text-white">[ ناوی ئەندامی سێیەم ]</h3>
                    <p class="text-amber-800 dark:text-gold font-bold text-sm mt-1">[ ڕۆڵ ]</p>
                </div>
                <div class="space-y-3 mt-auto pt-6 border-t border-slate-200/70 dark:border-white/10 relative">
                    <span class="flex items-center gap-3 text-sm font-semibold text-slate-600 dark:text-slate-300"><svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg> [email3@example.com]</span>
                    <span class="flex items-center gap-3 text-sm font-semibold text-slate-600 dark:text-slate-300"><svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg> [ ژمارە موبایل ]</span>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')

    <script>
    </script>

@endsection
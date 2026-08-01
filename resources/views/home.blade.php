@extends('layouts.app')

@section('title', 'ALPHA/AI — پلاتفۆرمی کوردی')

@section('content')
@include('partials.nav', ['active' => 'home'])

    

    <div class="tech-glow w-80 h-80 top-0 right-1/3"></div>

    <header class="relative z-10 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 pt-20 pb-16 md:pt-28 md:pb-24 relative">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 border-2 border-amber-700/50 bg-gold/10 text-amber-800 dark:text-gold text-xs font-mono font-bold tracking-widest mb-6 anim-slide-up">
                    <span class="w-2 h-2 bg-gold animate-pulse"></span>
                    SYS.ALPHA — پلاتفۆرمی کوردی بۆ سەردەمی AI
                </div>
                <h1 class="font-mega text-6xl md:text-8xl tracking-wide leading-[0.95] text-stone-900 dark:text-cream mb-6 anim-slide-up delay-1">
                    Alpha<span class="gold-text">Ai</span><br>
                    <span class="text-4xl md:text-6xl">بەهێزکراو بە ژیریی دەستکرد</span>
                </h1>
                <p class="text-lg md:text-xl text-stone-600 dark:text-stone-400 mb-10 leading-relaxed anim-slide-up delay-2 max-w-xl">
                    پلاتفۆرمێکی تەواو بۆ فێربوونی پرۆگرامسازی، دۆزینەوەی ئامرازەکانی AI، و ڕێنمایی ئەکادیمی — هەمووی بە کوردی.
                </p>
                <div class="flex flex-wrap gap-4 anim-slide-up delay-3">
                    <a href="/ferga" class="btn btn-primary btn-glow !px-7 !py-3.5 !text-sm">دەستپێبکە بۆ فێربوون
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"/></svg>
                    </a>
                    <a href="/ai-tools" class="btn btn-outline !px-7 !py-3.5 !text-sm">گەڕانی ئامرازەکان</a>
                </div>
            </div>
            <div class="hidden lg:block absolute left-10 top-1/2 -translate-y-1/2 float-y">
                <div class="code-block rounded-lg p-6 shadow-[8px_8px_0_rgba(0,0,0,.25)] border-2 border-neutral-800 w-80" dir="ltr">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="w-2.5 h-2.5 bg-amber-600"></span>
                        <span class="w-2.5 h-2.5 bg-gold"></span>
                        <span class="w-2.5 h-2.5 bg-stone-600"></span>
                        <span class="font-mono text-[10px] text-stone-500 ms-auto">learn.py</span>
                    </div>
                    <pre class="text-xs leading-relaxed text-amber-300">$ python3 ai.py</pre>
                    <pre class="text-xs leading-relaxed mt-2">
<span class="text-amber-600">def</span> <span class="text-gold">learn</span>(<span class="text-amber-300">student</span>):
    <span class="text-stone-500"># بە کوردی فێربە</span>
    <span class="text-gold">print</span>(<span class="text-lime-400">"ئافەرین!"</span>)

<span class="text-amber-600">learn</span>(<span class="text-amber-300">you</span>)
<span class="text-stone-500">&gt;&gt;&gt; ئافەرین!</span></pre>
                </div>
            </div>
        </div>
    </header>

    <section class="relative z-10 max-w-7xl mx-auto px-4 pb-20">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-20">
            <div class="tech-card p-5 text-center anim-slide-up delay-1">
                <div class="text-4xl font-mega tracking-wider gold-text">٤+</div>
                <p class="text-xs font-mono font-bold text-stone-500 dark:text-stone-400 mt-1 tracking-widest">بەشی سەرەکی</p>
            </div>
            <div class="tech-card p-5 text-center anim-slide-up delay-2">
                <div class="text-4xl font-mega tracking-wider gold-text">٢</div>
                <p class="text-xs font-mono font-bold text-stone-500 dark:text-stone-400 mt-1 tracking-widest">زمانی پرۆگرامسازی</p>
            </div>
            <div class="tech-card p-5 text-center anim-slide-up delay-3">
                <div class="text-4xl font-mega tracking-wider gold-text">١٠+</div>
                <p class="text-xs font-mono font-bold text-stone-500 dark:text-stone-400 mt-1 tracking-widest">بەشی ئامرازەکانی AI</p>
            </div>
            <div class="tech-card p-5 text-center anim-slide-up delay-4">
                <div class="text-4xl font-mega tracking-wider gold-text">∞</div>
                <p class="text-xs font-mono font-bold text-stone-500 dark:text-stone-400 mt-1 tracking-widest">دەرفەتی فێربوون</p>
            </div>
        </div>

        <h2 class="text-4xl md:text-5xl font-mega tracking-wide text-center text-stone-900 dark:text-cream mb-3">
            چی <span class="gold-text">پێشکەش</span> دەکەین؟
        </h2>
        <div class="w-24 h-1 bg-gradient-to-l from-amber-400 to-amber-600 mx-auto mb-14"></div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="/ferga" class="tech-card glass p-8 anim-slide-up delay-1 block group relative overflow-hidden">
                <div class="absolute top-0 left-0 font-mega text-6xl text-gold/15 group-hover:text-gold/30 transition leading-none pt-3 px-4">01</div>
                <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-amber-600 border-2 border-amber-700 flex items-center justify-center mb-6 text-neutral-950 group-hover:scale-110 transition-transform shadow-[3px_3px_0_rgba(0,0,0,.3)]">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <h3 class="font-mega text-2xl tracking-wide mb-3 text-stone-900 dark:text-cream">فێرگە</h3>
                <p class="text-stone-500 dark:text-stone-400 text-sm leading-relaxed">فێری زمانی پایتۆن و C++ ببە بە هاوکاری ژیریی دەستکرد — لەگەڵ کۆدکردنی راستەوخۆ و تاقیکردنەوە</p>
                <span class="inline-flex items-center gap-1 text-sm font-bold text-amber-800 dark:text-gold mt-5 group-hover:gap-2.5 transition-all">زیاتر بزانە
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"/></svg>
                </span>
            </a>

            <a href="/ai-tools" class="tech-card glass p-8 anim-slide-up delay-2 block group relative overflow-hidden">
                <div class="absolute top-0 left-0 font-mega text-6xl text-gold/15 group-hover:text-gold/30 transition leading-none pt-3 px-4">02</div>
                <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-amber-600 border-2 border-amber-700 flex items-center justify-center mb-6 text-neutral-950 group-hover:scale-110 transition-transform shadow-[3px_3px_0_rgba(0,0,0,.3)]">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="font-mega text-2xl tracking-wide mb-3 text-stone-900 dark:text-cream">تووڵەکانی AI</h3>
                <p class="text-stone-500 dark:text-stone-400 text-sm leading-relaxed">کۆمەڵێک لە باشترین ئامرازەکانی ژیریی دەستکرد بۆ هەموو بوارێک — چات بۆت، وێنە، ڤیدیۆ و زیاتر</p>
                <span class="inline-flex items-center gap-1 text-sm font-bold text-amber-800 dark:text-gold mt-5 group-hover:gap-2.5 transition-all">زیاتر بزانە
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"/></svg>
                </span>
            </a>

            <a href="/academic-guide" class="tech-card glass p-8 anim-slide-up delay-3 block group relative overflow-hidden">
                <div class="absolute top-0 left-0 font-mega text-6xl text-gold/15 group-hover:text-gold/30 transition leading-none pt-3 px-4">03</div>
                <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-amber-600 border-2 border-amber-700 flex items-center justify-center mb-6 text-neutral-950 group-hover:scale-110 transition-transform shadow-[3px_3px_0_rgba(0,0,0,.3)]">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                </div>
                <h3 class="font-mega text-2xl tracking-wide mb-3 text-stone-900 dark:text-cream">ڕێنیشاندەری ئەکادیمی</h3>
                <p class="text-stone-500 dark:text-stone-400 text-sm leading-relaxed">ڕێنمایی و ڕاوێژکاری ئەکادیمی بۆ قوتابیان — لەگەڵ لیستی زانکۆکان و خشتەی وانەکان</p>
                <span class="inline-flex items-center gap-1 text-sm font-bold text-amber-800 dark:text-gold mt-5 group-hover:gap-2.5 transition-all">زیاتر بزانە
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"/></svg>
                </span>
            </a>
        </div>
    </section>

    <section class="relative z-10 max-w-4xl mx-auto px-4 pb-24">
        <h2 class="text-4xl md:text-5xl font-mega tracking-wide text-center text-stone-900 dark:text-cream mb-3">
            پرسیارە <span class="gold-text">دووبارەکان</span>
        </h2>
        <div class="w-24 h-1 bg-gradient-to-l from-amber-400 to-amber-600 mx-auto mb-14"></div>
        <div class="space-y-3">
            @foreach($faqs as $faq)
            <div class="tech-card overflow-hidden">
                <button onclick="toggleFaq('faq-{{ $faq->id }}')" class="w-full p-5 text-right flex justify-between items-center gap-4 focus:outline-none">
                    <h3 class="font-bold text-base md:text-lg text-stone-900 dark:text-cream">{{ $faq->question }}</h3>
                    <span class="w-8 h-8 border-2 border-amber-700/40 text-amber-800 dark:text-gold dark:border-gold/40 flex items-center justify-center shrink-0 transition-transform duration-300 font-mono font-bold" id="icon-faq-{{ $faq->id }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </span>
                </button>
                <div id="faq-{{ $faq->id }}" class="hidden px-5 pb-5 border-t-2 border-stone-300 dark:border-neutral-800">
                    <p class="text-stone-500 dark:text-stone-400 leading-relaxed pt-4 whitespace-pre-line">{{ $faq->answer }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    @include('partials.footer')

    <script>
        function toggleFaq(id) {
            const el = document.getElementById(id);
            const icon = document.getElementById('icon-' + id);
            el.classList.toggle('hidden');
            icon.style.transform = el.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
        }
    </script>

@endsection
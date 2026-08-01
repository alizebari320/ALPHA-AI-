<nav class="sticky top-0 z-50 bg-stone-100/95 dark:bg-graphite/95 border-b-2 border-stone-300 dark:border-gold/40 backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-4 h-14 flex justify-between items-center gap-4">
        <a href="/" class="flex items-center gap-2.5 group shrink-0">
            <span class="w-8 h-8 bg-gradient-to-br from-amber-400 to-amber-600 border-2 border-amber-700 flex items-center justify-center text-neutral-950 font-black text-sm shadow-[2px_2px_0_rgba(0,0,0,.35)] group-hover:shadow-[3px_3px_0_rgba(0,0,0,.35)] group-hover:-translate-y-px transition-all">▲</span>
            <span class="font-mega text-2xl tracking-wider text-stone-800 dark:text-cream leading-none">ALPHA<span class="gold-text">AI</span></span>
        </a>
        <div class="hidden lg:flex items-center gap-1">
            <a href="/" class="nav-link {{ ($active ?? '') === 'home' ? 'active' : '' }}">سەرەکی</a>
            <a href="/ferga" class="nav-link {{ ($active ?? '') === 'ferga' ? 'active' : '' }}">فێرگە</a>
            <a href="/ai-tools" class="nav-link {{ ($active ?? '') === 'tools' ? 'active' : '' }}">تووڵەکان</a>
            <a href="/courses" class="nav-link {{ ($active ?? '') === 'courses' ? 'active' : '' }}">کۆرسەکان</a>
            <a href="/news" class="nav-link {{ ($active ?? '') === 'news' ? 'active' : '' }}">هەواڵەکان</a>
            <a href="/academic-guide" class="nav-link {{ ($active ?? '') === 'guide' ? 'active' : '' }}">ڕێنیشاندەر</a>
            <a href="/universities" class="nav-link {{ ($active ?? '') === 'universities' ? 'active' : '' }}">زانکۆکان</a>
            <a href="/about" class="nav-link {{ ($active ?? '') === 'about' ? 'active' : '' }}">دەربارە</a>
        </div>
        <div class="flex items-center gap-2">
            <button id="mobile-menu-btn" class="lg:hidden w-9 h-9 border-2 border-stone-300 dark:border-neutral-800 rounded flex items-center justify-center text-stone-600 dark:text-stone-300 hover:border-gold transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>
    <div id="mobile-menu" class="hidden lg:hidden border-t-2 border-stone-300 dark:border-gold/30 bg-stone-100/98 dark:bg-graphite/98">
        <div class="px-4 py-3 flex flex-col gap-1">
            <a href="/" class="nav-link {{ ($active ?? '') === 'home' ? 'active' : '' }}">سەرەکی</a>
            <a href="/ferga" class="nav-link {{ ($active ?? '') === 'ferga' ? 'active' : '' }}">فێرگە</a>
            <a href="/ai-tools" class="nav-link {{ ($active ?? '') === 'tools' ? 'active' : '' }}">تووڵەکان</a>
            <a href="/courses" class="nav-link {{ ($active ?? '') === 'courses' ? 'active' : '' }}">کۆرسەکان</a>
            <a href="/news" class="nav-link {{ ($active ?? '') === 'news' ? 'active' : '' }}">هەواڵەکان</a>
            <a href="/academic-guide" class="nav-link {{ ($active ?? '') === 'guide' ? 'active' : '' }}">ڕێنیشاندەر</a>
            <a href="/universities" class="nav-link {{ ($active ?? '') === 'universities' ? 'active' : '' }}">زانکۆکان</a>
            <a href="/about" class="nav-link {{ ($active ?? '') === 'about' ? 'active' : '' }}">دەربارە</a>
        </div>
    </div>
</nav>
<script>
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', () => document.getElementById('mobile-menu').classList.toggle('hidden'));
</script>

<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/favicon.png" type="image/png">
    <title>دەربارەی ئێمە - کورد ئەی ئای</title>
    <meta name="description" content="کورد ئەی ئای - یەکەمین پلاتفۆرمی کوردی بۆ فێربوونی ژیریی دەستکرد و پرۆگرامسازی بە شێوازێکی مۆدێرن.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://alpha-ai.com/about">
    <meta property="og:title" content="دەربارەی ئێمە - KURD AI">
    <meta property="og:description" content="پلاتفۆرمی فێربوونی زیرەکی دەستکرد و پرۆگرامسازی بە زمانی کوردی">
    <meta property="og:image" content="/logo.jpg">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="/css/kai-tailwind.css">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;700;900&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'"><noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;700;900&display=swap"></noscript>
    <script>if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @include('partials.kurdai-design')
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-[#0a0f1c] dark:text-white min-h-screen transition-colors duration-300">

    @include('partials.nav', ['active' => 'about'])

    <!-- ===== Hero ===== -->
    <header class="kai-about-hero">
        <div class="relative z-10 max-w-4xl mx-auto px-4">
            <div class="inline-flex items-center gap-2.5 px-5 py-2.5 rounded-full glass border border-cyan-400/25 text-cyan-700 dark:text-cyan-300 font-extrabold text-sm mb-7 shadow-[0_0_26px_rgba(34,211,238,.14)]">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-cyan-400"></span>
                </span>
                <span class="lang-str" data-so="تیمی پەرەپێدەرانی کورد ئەی ئای" data-ba="تیمێ پێشڤەبەرێن کورد ئەی ئای">تیمی پەرەپێدەرانی کورد ئەی ئای</span>
            </div>
            <h1 class="text-5xl md:text-7xl font-black tracking-tight leading-tight mb-5 kai-grad-text lang-str" data-so="دەربارەی ئێمە و تیمەکەمان" data-ba="دەربارەی مە و تیمێ مە">دەربارەی ئێمە و تیمەکەمان</h1>
            <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 font-medium max-w-3xl mx-auto leading-relaxed lang-str" data-so="ناساندنی ئەندامانی تیمی پڕۆژە، زانکۆ و زانیارییە پەیوەندییەکان بۆ هاوکاری و ڕاوێژ" data-ba="ناساندنا ئەندامێن تیمێ پڕۆژەی، زانکۆ و زانیاریێن پەیوەندیێ بۆ هاریکاری و ڕاوێژێ">ناساندنی ئەندامانی تیمی پڕۆژە، زانکۆ و زانیارییە پەیوەندییەکان بۆ هاوکاری و ڕاوێژ</p>
            <div class="kai-about-divider" aria-hidden="true"></div>
        </div>
    </header>

    <!-- ===== Team ===== -->
    <section class="relative z-10 container mx-auto pb-24 px-4 max-w-6xl">
        <div class="text-center mb-14">
            <h3 class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white mb-4 lang-str" data-so="ئەندامانی سەرەکی پڕۆژە" data-ba="ئەندامێن سەرەکی یێن پڕۆژەی">ئەندامانی سەرەکی پڕۆژە</h3>
            <p class="text-gray-600 dark:text-gray-400 font-medium max-w-2xl mx-auto leading-relaxed lang-str" data-so="بۆ پەیوەندی کردن زانیاری ئەندامان دەتوانیت لە ڕێگەی ئیمێڵ، ژمارە موبایل یان فەیسبووکەوە پەیوەندی بکەیت" data-ba="بۆ پەیوەندیکرن و دیتنا زانیاریێن ئەندامان دشێی ب ڕێکا ئیمێلی، ژمارا موبایلی یان فەیسبووکی پەیوەندیێ بکەی">بۆ پەیوەندی کردن زانیاری ئەندامان دەتوانیت لە ڕێگەی ئیمێڵ، ژمارە موبایل یان فەیسبووکەوە پەیوەندی بکەیت</p>
        </div>

        <div id="about-team-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
            <!-- Member 1: محمد کامران حمەساڵح -->
            <div class="kai-cat kai-team kai-tilt h-full" style="--i:0; --beam-a:#3b82f6; --beam-b:#22d3ee; --kai-cat-glow-c:#3b82f622;" role="group" aria-label="محمد کامران حمەساڵح">
                <span class="kai-beam"></span>
                <span class="kai-cat-glow"></span>
                <div class="kai-team-avatar">
                    <span class="kai-team-ring"></span>
                    <img src="muhamad.jpg" alt="محمد کامران حمەساڵح" loading="lazy">
                </div>
                <h4 class="kai-team-name">محمد کامران حمەساڵح</h4>
                <p class="kai-team-uni lang-str" data-so="قوتابی ل زانکۆیا ئاکرێ بۆ زانستێن کارپێکراوی - ژیریا دەستکرد - قۆناغا سێیێ" data-ba="قوتابی ل زانکۆیا ئاکرێ بۆ زانستێن کارپێکراوی - ژیریا دەستکرد - قۆناغا سێیێ">قوتابی ل زانکۆیا ئاکرێ بۆ زانستێن کارپێکراوی - ژیریا دەستکرد - قۆناغا سێیێ</p>
                <div class="kai-team-contacts">
                    <a href="mailto:mahamadkamaran890@gmail.com" class="kai-team-link" aria-label="ئیمەیڵ" title="Email"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></a><a href="tel:+964XXXXXXXXX" class="kai-team-link" aria-label="ژمارەی موبایل" title="07XXXXXXXXX" dir="ltr"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></a><a href="https://www.facebook.com/share/1939LEuq7d/" target="_blank" rel="noopener noreferrer" class="kai-team-link" aria-label="فەیسبووک" title="Facebook"><svg fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg></a>
                </div>
            </div>
            <!-- Member 2: سیما هێمن شەریف -->
            <div class="kai-cat kai-team kai-tilt h-full" style="--i:1; --beam-a:#f59e0b; --beam-b:#fb923c; --kai-cat-glow-c:#f59e0b22;" role="group" aria-label="سیما هێمن شەریف">
                <span class="kai-beam"></span>
                <span class="kai-cat-glow"></span>
                <div class="kai-team-avatar">
                    <span class="kai-team-ring"></span>
                    <img src="sima.jpg" alt="سیما هێمن شەریف" loading="lazy">
                </div>
                <h4 class="kai-team-name">سیما هێمن شەریف</h4>
                <p class="kai-team-uni lang-str" data-so="خوێندکاری ئەندازیاری ژیری دەستکرد و ڕۆبۆتیکس - قۆناغی سێیەم - هەولێر" data-ba="خوێندکاری ئەندازیاری ژیری دەستکرد و ڕۆبۆتیکس - قۆناغی سێیەم - هەولێر">خوێندکاری ئەندازیاری ژیری دەستکرد و ڕۆبۆتیکس - قۆناغی سێیەم - هەولێر</p>
                <div class="kai-team-contacts">
                    <a href="mailto:Simahemin25@gmail.com" class="kai-team-link" aria-label="ئیمەیڵ" title="Email"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></a><a href="https://www.facebook.com/share/1TimMctkTt/" target="_blank" rel="noopener noreferrer" class="kai-team-link" aria-label="فەیسبووک" title="Facebook"><svg fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg></a>
                </div>
            </div>
            <!-- Member 3: ڕاستگۆ تۆفیق حسێن -->
            <div class="kai-cat kai-team kai-tilt h-full" style="--i:2; --beam-a:#8b5cf6; --beam-b:#ec4899; --kai-cat-glow-c:#8b5cf622;" role="group" aria-label="ڕاستگۆ تۆفیق حسێن">
                <span class="kai-beam"></span>
                <span class="kai-cat-glow"></span>
                <div class="kai-team-avatar">
                    <span class="kai-team-ring"></span>
                    <img src="rastgo.jpg" alt="ڕاستگۆ تۆفیق حسێن" loading="lazy">
                </div>
                <h4 class="kai-team-name">ڕاستگۆ تۆفیق حسێن</h4>
                <p class="kai-team-uni lang-str" data-so="قوتابی ل زانکۆیا زاخۆ - ئەندازیاریا ژیریا دەستکرد - قۆناغا دووێ" data-ba="قوتابی ل زانکۆیا زاخۆ - ئەندازیاریا ژیریا دەستکرد - قۆناغا دووێ">قوتابی ل زانکۆیا زاخۆ - ئەندازیاریا ژیریا دەستکرد - قۆناغا دووێ</p>
                <div class="kai-team-contacts">
                    <a href="mailto:rastgotofeq0@gmail.com" class="kai-team-link" aria-label="ئیمەیڵ" title="Email"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></a><a href="tel:+9647708913535" class="kai-team-link" aria-label="ژمارەی موبایل" title="077708913535" dir="ltr"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></a><a href="https://www.facebook.com/share/1Dvruge4Xg/" target="_blank" rel="noopener noreferrer" class="kai-team-link" aria-label="فەیسبووک" title="Facebook"><svg fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg></a>
                </div>
            </div>
            <!-- Member 4: علی عارف محمد -->
            <div class="kai-cat kai-team kai-tilt h-full" style="--i:3; --beam-a:#14b8a6; --beam-b:#34d399; --kai-cat-glow-c:#14b8a622;" role="group" aria-label="علی عارف محمد">
                <span class="kai-beam"></span>
                <span class="kai-cat-glow"></span>
                <div class="kai-team-avatar">
                    <span class="kai-team-ring"></span>
                    <img src="ali.jpg" alt="علی عارف محمد" loading="lazy">
                </div>
                <h4 class="kai-team-name">علی عارف محمد</h4>
                <p class="kai-team-uni lang-str" data-so="قوتابی ل زانکۆیا زاخۆ - ئەندازیاریا ژیریا دەستکرد - قۆناغا سێیێ" data-ba="قوتابی ل زانکۆیا زاخۆ - ئەندازیاریا ژیریا دەستکرد - قۆناغا سێیێ">قوتابی ل زانکۆیا زاخۆ - ئەندازیاریا ژیریا دەستکرد - قۆناغا سێیێ</p>
                <div class="kai-team-contacts">
                    <a href="mailto:ali.ai2004.20@gmail.com" class="kai-team-link" aria-label="ئیمەیڵ" title="Email"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></a><a href="tel:+9647511826231" class="kai-team-link" aria-label="ژمارەی موبایل" title="077511826231" dir="ltr"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></a><a href="https://www.facebook.com/share/19CRkdUVnh/" target="_blank" rel="noopener noreferrer" class="kai-team-link" aria-label="فەیسبووک" title="Facebook"><svg fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg></a>
                </div>
            </div>
        </div>

        @include('partials.site-analytics')

    </section>

</body>
</html>

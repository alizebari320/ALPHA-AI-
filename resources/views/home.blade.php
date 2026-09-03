<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    @include('partials.alpha-head')
    <meta name="description" content="ALPHA AI — فێربوونی پرۆگرامسازی و ژیریی دەستکرد بە زمانی کوردی.">
    <title>ALPHA AI — سەرەکی</title>
</head>
<body class="al-body">

@include('partials.alpha-nav', ['active' => 'home'])

<section class="al-hero">
    <div class="al-container">
        <span class="al-kicker lang-str" data-so="پلاتفۆرمی فێربوون" data-ba="پلاتفۆرما فێربوونێ">پلاتفۆرمی فێربوون</span>
        <h1 class="lang-str" data-so="فێربوونی پرۆگرامسازی و ژیریی دەستکرد — بە زمانی کوردی" data-ba="فێربوونا پرۆگرامسازیێ و ژیرییا دەستکرد — بە زمانێ کوردی">فێربوونی پرۆگرامسازی و ژیریی دەستکرد — بە زمانی کوردی</h1>
        <p class="al-hero__sub lang-str" data-so="لە وانەکانی فێرگەوە تا کۆرس و ئامرازەکانی ئەی ئای — هەموو شتێک لە یەک شوێن." data-ba="ژ وانێن فێرگێیێ تا کۆرس و ئامرازێن ئەی ئای — هەر شێ ب یەک جێیێ.">لە وانەکانی فێرگەوە تا کۆرس و ئامرازەکانی ئەی ئای — هەموو شتێک لە یەک شوێن.</p>
        <div style="display:flex; gap:12px; margin-top:28px; flex-wrap:wrap">
            <a href="/ferga" class="al-btn al-btn--solid lang-str" data-so="دەستپێبکە" data-ba="دەستپێبکە">دەستپێبکە</a>
            <a href="/ai-tools" class="al-btn al-btn--ghost lang-str" data-so="ئامرازەکان" data-ba="ئامراز">ئامرازەکان</a>
        </div>
    </div>
</section>

<main class="al-container al-section">
    <div class="al-grid">

        <a href="/ferga" class="al-card al-fade-in" style="text-decoration:none">
            <div class="al-item__media">
                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" style="color:var(--al-accent)"><path stroke-linecap="round" stroke-linejoin="round" d="M8 6l-6 6 6 6M16 6l6 6-6 6"/></svg>
            </div>
            <div class="al-item__body">
                <div class="al-item__title lang-str" data-so="فێرگە — وانەکانی پرۆگرامسازی" data-ba="فێرگە — وانێن پرۆگرامسازیێ">فێرگە — وانەکانی پرۆگرامسازی</div>
                <p class="al-item__desc lang-str" data-so="وانەی واکار و تاقیکردنەوە بۆ HTML, CSS, JS, Python, C++, Java, Rust و زیاتر." data-ba="وانێن کارێ و تاقیکرنێ بۆ HTML, CSS, JS, Python, C++, Java, Rust و زێدەتر.">وانەی واکار و تاقیکردنەوە بۆ HTML, CSS, JS, Python, C++, Java, Rust و زیاتر.</p>
            </div>
        </a>

        <a href="/courses" class="al-card al-fade-in" style="text-decoration:none">
            <div class="al-item__media">
                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" style="color:var(--al-accent)"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.247m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.247"/></svg>
            </div>
            <div class="al-item__body">
                <div class="al-item__title lang-str" data-so="کۆرسەکان" data-ba="کۆرس">کۆرسەکان</div>
                <p class="al-item__desc lang-str" data-so="کۆرسی تایبەت بە بوارە جیاوازەکان لەگەڵ ڤیدیۆ و سەرچاوە." data-ba="کۆرسێ تایبەت ب بەرێن جیاوازن لگەڵ ڤیدیۆ و سەرچاوە.">کۆرسی تایبەت بە بوارە جیاوازەکان لەگەڵ ڤیدیۆ و سەرچاوە.</p>
            </div>
        </a>

        <a href="/ai-tools" class="al-card al-fade-in" style="text-decoration:none">
            <div class="al-item__media">
                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" style="color:var(--al-accent)"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div class="al-item__body">
                <div class="al-item__title lang-str" data-so="ئامرازەکانی AI" data-ba="ئامرازێن AI">ئامرازەکانی AI</div>
                <p class="al-item__desc lang-str" data-so="ڕێنمایی بۆ باشترین ئامرازەکانی ژیریی دەستکرد بۆ کار و دروستکردن." data-ba="ڕێنمایی بۆ باشترین ئامرازێن ژیرییا دەستکرد بۆ کار و دروستکرن.">ڕێنمایی بۆ باشترین ئامرازەکانی ژیریی دەستکرد بۆ کار و دروستکردن.</p>
            </div>
        </a>

        <a href="/news" class="al-card al-fade-in" style="text-decoration:none">
            <div class="al-item__media">
                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" style="color:var(--al-accent)"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            </div>
            <div class="al-item__body">
                <div class="al-item__title lang-str" data-so="هەواڵی تەکنەلۆژیا" data-ba="نووچێن تەکنەلۆژیایێ">هەواڵی تەکنەلۆژیا</div>
                <p class="al-item__desc lang-str" data-so="دوایین هەواڵەکانی جیهانی ژیریی دەستکرد و تەکنەلۆژیا." data-ba="دوماهیک نووچێن جیهانا ژیرییا دەستکرد و تەکنەلۆژیایێ.">دوایین هەواڵەکانی جیهانی ژیریی دەستکرد و تەکنەلۆژیا.</p>
            </div>
        </a>

        <a href="/universities" class="al-card al-fade-in" style="text-decoration:none">
            <div class="al-item__media">
                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" style="color:var(--al-accent)"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
            </div>
            <div class="al-item__body">
                <div class="al-item__title lang-str" data-so="زانکۆکان" data-ba="زانکۆ">زانکۆکان</div>
                <p class="al-item__desc lang-str" data-so="زانیاری بەرفراوان لە زانکۆکانی کوردستان و دەرەوە." data-ba="زانیاری بەفرەح ژ زانکۆێن کوردستانێ و دەرڤە.">زانیاری بەرفراوان لە زانکۆکانی کوردستان و دەرەوە.</p>
            </div>
        </a>

        <a href="/academic-guide" class="al-card al-fade-in" style="text-decoration:none">
            <div class="al-item__media">
                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" style="color:var(--al-accent)"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 4m0 13V4m0 0L9 7"/></svg>
            </div>
            <div class="al-item__body">
                <div class="al-item__title lang-str" data-so="ڕێنیشاندەری خوێندن" data-ba="ڕێبەرێ خوێندنێ">ڕێنیشاندەری خوێندن</div>
                <p class="al-item__desc lang-str" data-so="وەڵامی پرسیارە باوەکانی خوێندن و بوارەکانی داهاتوو." data-ba="وەڵاما پرسیارێن باوێن خوێندنێ و بەرێن داهاتوویێ.">وەڵامی پرسیارە باوەکانی خوێندن و بوارەکانی داهاتوو.</p>
            </div>
        </a>

    </div>
</main>

@include('partials.alpha-foot')
</body>
</html>

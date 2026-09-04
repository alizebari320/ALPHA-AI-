<!DOCTYPE html>
<html lang="ckb" dir="rtl" class="dark">
<head>
    @include('partials.a1-head')
    <meta name="description" content="ALPHA AI — فێربوونی پرۆگرامسازی و ژیریی دەستکرد بە زمانی کوردی">
    <title>ALPHA AI</title>
</head>
<body class="a1">

@include('partials.a1-rail', ['active' => 'home'])

<div class="a1-main">
    <div class="a1-page">

        <div class="a1-strip">
            <span class="a1-strip__dot"></span>
            <span class="a1-strip__crumb lang-str" data-so="پلاتفۆرمی فێربوونی کوردی" data-ba="پلاتفۆرما فێربوونا کوردی">پلاتفۆرمی فێربوونی کوردی</span>
            <span style="margin-inline-start:auto">EST. 2026</span>
        </div>

        <section class="a1-hero">
            <h1 class="a1-display">
                <span class="lang-str" data-so="فێربوون" data-ba="فێربوون">فێربوون</span><br>
                <em class="lang-str" data-so="بە کۆد" data-ba="ب کۆدی">بە کۆد</em>
            </h1>
            <p class="a1-hero__sub lang-str"
               data-so="لە یەکەم دێر کۆدەوە تا پرۆژەی تەواو — وانە، تاقیکردنەوە و ئامراز، هەمووی بە کوردی."
               data-ba="ژ یەکەم دێر کۆدیێ تا پرۆژەیا تەواو — وانە، تاقیکرن و ئامراز، هەمی ب کوردی.">
               لە یەکەم دێر کۆدەوە تا پرۆژەی تەواو — وانە، تاقیکردنەوە و ئامراز، هەمووی بە کوردی.
            </p>
            <div style="display:flex;gap:12px;flex-wrap:wrap">
                <a href="/ferga" class="a1-btn a1-btn--accent a1-btn--lg lang-str" data-so="دەستپێبکە ئێستا ←" data-ba="دەستپێبکە نوکە ←">دەستپێبکە ئێستا ←</a>
                <a href="/ai-tools" class="a1-btn a1-btn--line a1-btn--lg lang-str" data-so="بینینی ئامرازەکان" data-ba="تحەپلێدنا ئامرازان">بینینی ئامرازەکان</a>
            </div>

            {{-- live stats from Firebase --}}
            <div id="a1-stats" style="display:flex;gap:12px;flex-wrap:wrap;margin-top:38px"></div>
        </section>

        <div class="a1-section-head">
            <h2 class="lang-str" data-so="بەشەکان" data-ba="بەش">بەشەکان</h2>
            <span class="a1-index">01 — 07</span>
        </div>

        <div class="a1-index-grid">
            <a href="/ferga" class="a1-index-cell">
                <span class="a1-num">01</span>
                <h3 class="lang-str" data-so="فێرگە" data-ba="فێرگە">فێرگە</h3>
                <p class="lang-str" data-so="وانەکانی پرۆگرامسازی بە شێوازی هەنگاو بە هەنگاو — HTML, CSS, JS, Python و زیاتر." data-ba="وانێن پرۆگرامسازیێ ب شێوازی هەنگام ب هەنگام — HTML, CSS, JS, Python و زێدەتر.">وانەکانی پرۆگرامسازی بە شێوازی هەنگاو بە هەنگاو — HTML, CSS, JS, Python و زیاتر.</p>
                <span class="a1-go">→ /ferga</span>
            </a>
            <a href="/courses" class="a1-index-cell">
                <span class="a1-num">02</span>
                <h3 class="lang-str" data-so="کۆرس" data-ba="کۆرس">کۆرس</h3>
                <p class="lang-str" data-so="کۆرسی وێدیۆیی بە بوارە جیاوازەکان." data-ba="کۆرسی ڤیدیۆیی ب بەرێن جیاوازن.">کۆرسی وێدیۆیی بە بوارە جیاوازەکان.</p>
                <span class="a1-go">→ /courses</span>
            </a>
            <a href="/ai-tools" class="a1-index-cell">
                <span class="a1-num">03</span>
                <h3 class="lang-str" data-so="ئامرازی AI" data-ba="ئامرازێ AI">ئامرازی AI</h3>
                <p class="lang-str" data-so="ڕێنمایی بۆ ئامرازەکانی ژیریی دەستکرد." data-ba="ڕێنمایی بۆ ئامرازێن ژیرییا دەستکرد.">ڕێنمایی بۆ ئامرازەکانی ژیریی دەستکرد.</p>
                <span class="a1-go">→ /ai-tools</span>
            </a>
            <a href="/news" class="a1-index-cell">
                <span class="a1-num">04</span>
                <h3 class="lang-str" data-so="هەواڵ" data-ba="نووچە">هەواڵ</h3>
                <p class="lang-str" data-so="هەواڵی تەکنەلۆژیا و ژیریی دەستکرد." data-ba="نووچێن تەکنەلۆژیایێ و ژیرییا دەستکرد.">هەواڵی تەکنەلۆژیا و ژیریی دەستکرد.</p>
                <span class="a1-go">→ /news</span>
            </a>
            <a href="/universities" class="a1-index-cell">
                <span class="a1-num">05</span>
                <h3 class="lang-str" data-so="زانکۆ" data-ba="زانکۆ">زانکۆ</h3>
                <p class="lang-str" data-so="ڕێنمایی زانکۆکانی ناوخۆ و دەرەوە." data-ba="ڕێنمایی زانکۆێن ناڤە و دەرڤە.">ڕێنمایی زانکۆکانی ناوخۆ و دەرەوە.</p>
                <span class="a1-go">→ /universities</span>
            </a>
            <a href="/academic-guide" class="a1-index-cell">
                <span class="a1-num">06</span>
                <h3 class="lang-str" data-so="ڕێبەری خوێندن" data-ba="ڕێبەرێ خوێندنێ">ڕێبەری خوێندن</h3>
                <p class="lang-str" data-so="وەڵامی پرسیارە باوەکانی خوێندن و داهاتوو." data-ba="وەڵاما پرسیارێن باوێن خوێندنێ و داهاتوویێ.">وەڵامی پرسیارە باوەکانی خوێندن و داهاتوو.</p>
                <span class="a1-go">→ /academic-guide</span>
            </a>
        </div>

        @include('partials.a1-foot')
    </div>
</div>

<script type="module">
    import { getDatabase, ref, get } from "/js/firebase10/firebase-database.js";

    const KaiF = window.KaiFirebase || {};
    const LABELS = {
        courses: { so: 'کۆرس', ba: 'کۆرس' },
        ai_tools: { so: 'ئامرازی AI', ba: 'ئامرازێ AI' },
        news: { so: 'هەواڵ', ba: 'نووچە' },
        ferga_lessons: { so: 'وانەی فێرگە', ba: 'وانێن فێرگێ' },
    };

    function esc(s) { return String(s == null ? '' : s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }

    async function loadStats() {
        const box = document.getElementById('a1-stats');
        if (!box) return;
        try {
            const app = KaiF.app ? KaiF.app() : null;
            if (!app && KaiF.whenReady) {
                await new Promise(res => KaiF.whenReady(res));
            }
            const a = KaiF.app ? KaiF.app() : null;
            if (!a) return;
            const db = getDatabase(a);
            const lang = localStorage.getItem('site-lang') || 'so';
            const roots = ['courses', 'ai_tools', 'news', 'ferga_lessons'];
            const counts = await Promise.all(roots.map(async r => {
                try {
                    const snap = await get(ref(db, r));
                    const v = snap.val();
                    return { root: r, n: (v && typeof v === 'object') ? Object.keys(v).length : 0 };
                } catch (e) { return { root: r, n: null }; }
            }));
            box.innerHTML = counts.map(c => `
                <span class="a1-stat">
                    <b>${c.n === null ? '—' : c.n}</b>
                    <span>${esc(LABELS[c.root][lang])}</span>
                </span>`).join('');
        } catch (e) {}
    }
    window.KaiPageReady(loadStats);
    window.addEventListener('kai:langchange', loadStats);
</script>

</body>
</html>

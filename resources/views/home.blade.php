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
            <span style="margin-inline-start:auto">2026</span>
        </div>

        <section class="a1-hero">
            <div>
                <h1 class="a1-display">
                    <span class="lang-str" data-so="کۆدەکەت بنووسە،" data-ba="کۆدەکەت بنڤیسە،">کۆدەکەت بنووسە،</span><br>
                    <em class="lang-str" data-so="داهاتووت دروست بکە" data-ba="داهاتوویێت دروست بکە">داهاتووت دروست بکە</em>
                </h1>
                <p class="a1-hero__sub lang-str"
                   data-so="لە یەکەم دێری کۆدەوە تا پرۆژەی تەواو — وانەی واکاردار، تاقیکردنەوەی زیندوو و ئامرازی AI، هەمووی بە زمانی کوردی."
                   data-ba="ژ یەکەم دێری کۆدیێ تا پرۆژەیا تەواو — وانێن کارێ، تاقیکرنا زیندی و ئامرازێ AI، هەمی ب زمانێ کوردی.">
                   لە یەکەم دێری کۆدەوە تا پرۆژەی تەواو — وانەی واکاردار، تاقیکردنەوەی زیندوو و ئامرازی AI، هەمووی بە زمانی کوردی.
                </p>
                <div style="display:flex;gap:11px;flex-wrap:wrap">
                    <a href="/ferga" class="a1-btn a1-btn--accent a1-btn--lg lang-str" data-so="دەستپێبکە ←" data-ba="دەستپێبکە ←">دەستپێبکە ←</a>
                    <a href="/ai-tools" class="a1-btn a1-btn--line a1-btn--lg lang-str" data-so="ئامرازەکان" data-ba="ئامراز">ئامرازەکان</a>
                </div>
                <div id="a1-stats" style="display:flex;gap:10px;flex-wrap:wrap;margin-top:30px"></div>
            </div>

            {{-- signature: live terminal --}}
            <div class="a1-term" aria-hidden="true">
                <div class="a1-term__bar">
                    <i></i><i></i><i></i>
                    <span>alpha — python</span>
                </div>
                <div class="a1-term__body" id="a1-term-body"></div>
            </div>
        </section>

        <div class="a1-section-head">
            <h2 class="lang-str" data-so="بەشەکان" data-ba="بەش">بەشەکان</h2>
            <span class="a1-index">01 — 04</span>
        </div>

        <div class="a1-index-grid">
            <a href="/ferga" class="a1-index-cell">
                <span class="a1-num">01</span>
                <h3 class="lang-str" data-so="فێرگە" data-ba="فێرگە">فێرگە</h3>
                <p class="lang-str" data-so="وانەکانی پرۆگرامسازی بە شێوازی هەنگاو بە هەنگاو — HTML, CSS, JS, Python و زیاتر، لەگەڵ تاقیکردنەوەی زیندوو لە وێبگەڕەکەت." data-ba="وانێن پرۆگرامسازیێ ب شێوازی هەنگام ب هەنگام — HTML, CSS, JS, Python و زێدەتر، لگەڵ تاقیکرنا زیندی د وێبگەڕا تە.">وانەکانی پرۆگرامسازی بە شێوازی هەنگاو بە هەنگاو — HTML, CSS, JS, Python و زیاتر، لەگەڵ تاقیکردنەوەی زیندوو لە وێبگەڕەکەت.</p>
                <span class="a1-go">→ /ferga</span>
            </a>
            <a href="/courses" class="a1-index-cell">
                <span class="a1-num">02</span>
                <h3 class="lang-str" data-so="کۆرس" data-ba="کۆرس">کۆرس</h3>
                <p class="lang-str" data-so="کۆرسی وێدیۆیی بە بوارە جیاوازەکانی تەکنەلۆژیا و ژیریی دەستکرد." data-ba="کۆرسی ڤیدیۆیی ب بەرێن جیاوازێن تەکنەلۆژیایێ و ژیرییا دەستکرد.">کۆرسی وێدیۆیی بە بوارە جیاوازەکانی تەکنەلۆژیا و ژیریی دەستکرد.</p>
                <span class="a1-go">→ /courses</span>
            </a>
            <a href="/ai-tools" class="a1-index-cell">
                <span class="a1-num">03</span>
                <h3 class="lang-str" data-so="ئامرازی AI" data-ba="ئامرازێ AI">ئامرازی AI</h3>
                <p class="lang-str" data-so="ڕێنمایی بۆ باشترین ئامرازەکانی ژیریی دەستکرد بۆ نووسین، دیزاین، کۆد و توێژینەوە." data-ba="ڕێنمایی بۆ باشترین ئامرازێن ژیرییا دەستکرد بۆ نووسین، دیزاین، کۆد و توێژینەوە.">ڕێنمایی بۆ باشترین ئامرازەکانی ژیریی دەستکرد بۆ نووسین، دیزاین، کۆد و توێژینەوە.</p>
                <span class="a1-go">→ /ai-tools</span>
            </a>
            <a href="/news" class="a1-index-cell">
                <span class="a1-num">04</span>
                <h3 class="lang-str" data-so="هەواڵ" data-ba="نووچە">هەواڵ</h3>
                <p class="lang-str" data-so="هەواڵی نوێی جیهانی تەکنەلۆژیا و ژیریی دەستکرد بە زمانی کوردی." data-ba="نووچێن نووی جیهانا تەکنەلۆژیایێ و ژیرییا دەستکرد ب زمانێ کوردی.">هەواڵی نوێی جیهانی تەکنەلۆژیا و ژیریی دەستکرد بە زمانی کوردی.</p>
                <span class="a1-go">→ /news</span>
            </a>
        </div>

        @include('partials.a1-foot')
    </div>
</div>

<script>
/* ---- terminal typing ---- */
(function () {
    var lines = [
        { t: '<span class="c"># ALPHA AI — fêrga</span>', d: 300 },
        { t: '<span class="p">def</span> silav(nav):', d: 26 },
        { t: '    <span class="p">return</span> <span class="s">f"Silav {nav}! 🧡"</span>', d: 18 },
        { t: '', d: 60 },
        { t: 'silav(<span class="s">"Alpha"</span>)', d: 22 },
        { t: '<span class="out">\'Silav Alpha! 🧡\'</span>', d: 200 }
    ];
    var body = document.getElementById('a1-term-body');
    if (!body) return;
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduce) {
        body.innerHTML = lines.map(function (l) { return '<div>' + l.t + '</div>'; }).join('') + '<div><span class="a1-term__caret"></span></div>';
        return;
    }
    var li = 0, done = false;
    function typeLine() {
        if (li >= lines.length) { done = true; body.insertAdjacentHTML('beforeend', '<div><span class="a1-term__caret"></span></div>'); return; }
        var l = lines[li];
        if (l.t === '') { body.insertAdjacentHTML('beforeend', '<div>&nbsp;</div>'); li++; setTimeout(typeLine, l.d * 8); return; }
        var plain = l.t.replace(/<[^>]+>/g, '');
        var row = document.createElement('div');
        body.appendChild(row);
        var ci = 0;
        function typeChar() {
            ci++;
            if (ci >= plain.length) { row.innerHTML = l.t; li++; setTimeout(typeLine, l.d * 6); return; }
            row.textContent = plain.slice(0, ci);
            setTimeout(typeChar, l.d);
        }
        typeChar();
    }
    setTimeout(typeLine, 900);
})();
</script>

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
            if (KaiF.whenReady) { await new Promise(res => KaiF.whenReady(res)); }
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

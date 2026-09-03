<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    @include('partials.alpha-head')
    <title>ALPHA AI — @yield('title')</title>
</head>
<body class="al-body">

@include('partials.alpha-nav', ['active' => 'feedback'])

<meta name="csrf-token" content="{{ csrf_token() }}">

<main class="al-container al-section">
    <header style="margin-bottom: 26px">
        <span class="al-kicker lang-str" data-so="پەیوەندی" data-ba="پەیوەندی">پەیوەندی</span>
        <h1 style="font-size: 1.9rem" class="lang-str" data-so="ڕەخنە و پێشنیار" data-ba="ڕەخنە و پێشنیار">ڕەخنە و پێشنیار</h1>
        <p class="al-hero__sub lang-str" data-so="ڕەخنەکەت بنووسە — یەک بە یەک دەیخوێنینەوە." data-ba="ڕەخنەت بنڤیسە — یەک ب یەک دێخوێنەڤە.">ڕەخنەکەت بنووسە — یەک بە یەک دەیخوێنینەوە.</p>
    </header>

    <div class="al-card al-card--pad" style="max-width:640px;margin:0 auto">
        <form id="al-feedback-form">
            <input type="hidden" id="fb-category" value="general">
            <label class="al-field"><span class="al-field__label lang-str" data-so="جۆری ڕەخنە" data-ba="جۆرێ ڕەخنێ">جۆری ڕەخنە</span>
                <select id="fb-cat-select" class="al-select">
                    <option value="general" data-so="گشتی" data-ba="گشتی">گشتی</option>
                    <option value="bug" data-so="کێشەی تەکنیکی" data-ba="کێشەیا تەکنیکی">کێشەی تەکنیکی</option>
                    <option value="feature" data-so="پێشنیار" data-ba="پێشنیار">پێشنیار</option>
                </select></label>
            <label class="al-field"><span class="al-field__label lang-str" data-so="نامەکەت" data-ba="نامەت">نامەکەت</span>
                <textarea id="fb-message" rows="5" maxlength="500" required class="al-textarea" placeholder="..."></textarea></label>
            <div class="al-flex al-flex--between" style="margin-bottom:16px">
                <span id="fb-char-count" style="font-size:0.78rem;color:var(--al-muted)">0 / 500</span>
            </div>
            <div id="fb-success" hidden class="al-note" style="margin-bottom:16px"></div>
            <button type="submit" id="al-fb-submit" class="al-btn al-btn--solid" style="width:100%">
                <span class="lang-str" data-so="ناردن" data-ba="ناردن">ناردن</span></button>
        </form>
        <hr class="al-divider">
        <h4 class="lang-str" style="margin-bottom:12px" data-so="ڕەخنەکانی من" data-ba="ڕەخنێن من">ڕەخنەکانی من</h4>
        <div id="fb-my-list" style="display:grid;gap:10px"></div>
        <div id="fb-my-empty" class="al-empty" style="padding:18px">
            <span class="lang-str" data-so="هێشتا هیچت نەناردووە" data-ba="هێشتا چی نەناردوویە">هێشتا هیچت نەناردووە</span>
        </div>
    </div>
</main>

<div id="fb-toast" hidden style="position:fixed;bottom:24px;inset-inline-start:24px;z-index:150;padding:12px 18px;border-radius:10px;background:var(--al-accent);color:#fff;font-weight:700;font-size:0.88rem"></div>

@include('partials.alpha-foot')

<script type="application/json" id="kurdai-firebase-config">{!! json_encode(config('kurdai.firebase'), 15) !!}</script>
<script src="/js/kai-firebase.js?v=1" data-kai-shared defer></script>
<script>
(function () {
    let currentLang = localStorage.getItem('site-lang') || 'so';
    const CSRF = document.querySelector('meta[name="csrf-token"]').content;

    function applyLanguage() {
        document.querySelectorAll('.lang-str').forEach(el => { el.textContent = el.getAttribute('data-' + currentLang) || el.getAttribute('data-so'); });
        document.querySelectorAll('#fb-cat-select option').forEach(o => { o.textContent = o.getAttribute('data-' + currentLang) || o.getAttribute('data-so'); });
    }
    document.getElementById('lang-toggle').addEventListener('click', () => {
        currentLang = currentLang === 'so' ? 'ba' : 'so';
        localStorage.setItem('site-lang', currentLang);
        applyLanguage();
    });
    applyLanguage();

    const msg = document.getElementById('fb-message');
    const count = document.getElementById('fb-char-count');
    msg.addEventListener('input', () => { count.textContent = msg.value.length + ' / 500'; });
    document.getElementById('fb-cat-select').addEventListener('change', (e) => {
        document.getElementById('fb-category').value = e.target.value;
    });

    function toast(text) {
        const t = document.getElementById('fb-toast');
        t.textContent = text; t.hidden = false;
        setTimeout(() => { t.hidden = true; }, 2600);
    }

    document.getElementById('al-feedback-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const box = document.getElementById('fb-success');
        box.hidden = true;
        try {
            const res = await fetch('/feedback/store', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: JSON.stringify({ category: document.getElementById('fb-category').value, message: msg.value })
            });
            const data = await res.json();
            if (res.ok && data.success) {
                box.textContent = data.message || 'سوپاس! ڕەخنەکەت گەیشت.';
                box.hidden = false;
                msg.value = ''; count.textContent = '0 / 500';
                loadMine();
            } else {
                toast(data.message || 'هەڵەیەک ڕوویدا');
            }
        } catch (err) {
            toast('پەیوەندی بە ئینتەرنێتەوە نەکرا');
        }
    });

    async function loadMine() {
        try {
            const res = await fetch('/feedback/mine', { headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF } });
            const data = await res.json();
            const list = document.getElementById('fb-my-list');
            const empty = document.getElementById('fb-my-empty');
            const items = (data.data || data.items || []);
            if (!items.length) { list.innerHTML = ''; empty.style.display = ''; return; }
            empty.style.display = 'none';
            list.innerHTML = items.map(f => `
                <div class="al-card" style="padding:12px 16px">
                    <div class="al-flex al-flex--between">
                        <span class="al-tag">${esc(f.category || '')}</span>
                        <span style="font-size:0.75rem;color:var(--al-muted)">${esc((f.created_at || '').toString().slice(0, 10))}</span>
                    </div>
                    <p style="font-size:0.88rem;margin-top:8px;line-height:1.7">${esc(f.message || '')}</p>
                </div>`).join('');
        } catch (e) {}
    }
    function esc(s) { return String(s == null ? '' : s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }

    window.KaiPageReady(loadMine);
})();
</script>
</body>
</html>

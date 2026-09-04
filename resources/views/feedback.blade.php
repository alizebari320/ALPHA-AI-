<!DOCTYPE html>
<html lang="ckb" dir="rtl" class="dark">
<head>
    @include('partials.a1-head')
    <title>ALPHA AI — @yield('title')</title>
</head>
<body class="a1">

@include('partials.a1-rail', ['active' => 'feedback'])

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="a1-main">
    <div class="a1-page">

        <div class="a1-strip"><span class="a1-strip__dot"></span><span class="a1-strip__crumb">ALPHA / FEEDBACK</span></div>

        <div class="a1-section-head">
            <h2 class="lang-str" data-so="ڕەخنە و پێشنیار" data-ba="ڕەخنە و پێشنیار">ڕەخنە و پێشنیار</h2>
            <span class="a1-index">TX</span>
        </div>

        <div style="max-width:560px">
            <form id="a1-fb-form">
                <input type="hidden" id="fb-category" value="general">
                <label class="a1-field"><span class="a1-field__label">TYPE</span>
                    <select id="fb-cat-select" class="a1-select">
                        <option value="general" data-so="گشتی" data-ba="گشتی">گشتی</option>
                        <option value="bug" data-so="کێشەی تەکنیکی" data-ba="کێشەیا تەکنیکی">کێشەی تەکنیکی</option>
                        <option value="feature" data-so="پێشنیار" data-ba="پێشنیار">پێشنیار</option>
                    </select></label>
                <label class="a1-field"><span class="a1-field__label lang-str" data-so="نامەکەت" data-ba="نامەت">نامەکەت</span>
                    <textarea id="fb-message" rows="5" maxlength="500" required class="a1-textarea" placeholder="..."></textarea></label>
                <div class="a1-hrow" style="margin-bottom:18px">
                    <span id="fb-char-count" style="font-family:var(--a1-mono);font-size:0.7rem;color:var(--a1-faint)">0/500</span>
                </div>
                <div id="fb-success" hidden class="a1-note" style="margin-bottom:16px"></div>
                <button type="submit" class="a1-btn a1-btn--accent" style="width:100%">
                    <span class="lang-str" data-so="ناردن" data-ba="ناردن">ناردن</span></button>
            </form>

            <div class="a1-section-head" style="padding-top:36px">
                <h3 style="font-size:1rem" class="lang-str" data-so="ڕەخنەکانی من" data-ba="ڕەخنێن من">ڕەخنەکانی من</h3>
            </div>
            <div id="fb-my-list" class="a1-stack"></div>
            <div id="fb-my-empty" class="a1-empty"><span class="lang-str" data-so="هێشتا هیچت نەناردووە" data-ba="هێشتا چی نەناردوویە">هێشتا هیچت نەناردووە</span></div>
        </div>

        @include('partials.a1-foot')
    </div>
</div>

<div id="fb-toast" hidden style="position:fixed;bottom:24px;inset-inline-start:24px;z-index:150;padding:12px 18px;background:var(--a1-accent);color:var(--a1-accent-ink);font-weight:800;font-size:0.85rem"></div>

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
    msg.addEventListener('input', () => { count.textContent = msg.value.length + '/500'; });
    document.getElementById('fb-cat-select').addEventListener('change', (e) => {
        document.getElementById('fb-category').value = e.target.value;
    });

    function toast(text) {
        const t = document.getElementById('fb-toast');
        t.textContent = text; t.hidden = false;
        setTimeout(() => { t.hidden = true; }, 2600);
    }

    document.getElementById('a1-fb-form').addEventListener('submit', async (e) => {
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
                box.textContent = data.message || 'سوپاس — گەیشت.';
                box.hidden = false;
                msg.value = ''; count.textContent = '0/500';
                loadMine();
            } else { toast(data.message || 'هەڵە'); }
        } catch (err) { toast('پەیوەندی نەکرا'); }
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
                <div style="border:1px solid var(--a1-line);padding:14px 16px">
                    <div class="a1-hrow">
                        <span class="a1-tag">${esc(f.category || '')}</span>
                        <span style="font-family:var(--a1-mono);font-size:0.7rem;color:var(--a1-faint)">${esc((f.created_at || '').toString().slice(0, 10))}</span>
                    </div>
                    <p style="font-size:0.88rem;margin:8px 0 0;line-height:1.8;color:var(--a1-dim)">${esc(f.message || '')}</p>
                </div>`).join('');
        } catch (e) {}
    }
    function esc(s) { return String(s == null ? '' : s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }

    window.KaiPageReady(loadMine);
})();
</script>
</body>
</html>

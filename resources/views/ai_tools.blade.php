<!DOCTYPE html>
<html lang="ckb" dir="rtl" class="dark">
<head>
    @include('partials.a1-head')
    <title>ALPHA AI — @yield('title')</title>
</head>
<body class="a1">

@include('partials.a1-rail', ['active' => 'ai-tools'])


<div class="a1-main">
    <div class="a1-page">

        <div class="a1-strip"><span class="a1-strip__dot"></span><span class="a1-strip__crumb">ALPHA / TOOLS</span></div>

        <div class="a1-section-head">
            <h2 class="lang-str" data-so="ئامرازەکانی AI" data-ba="ئامرازێن AI">ئامرازەکانی AI</h2>
            <span class="a1-index" id="a1-tools-count">—</span>
        </div>

        <div class="a1-hrow" style="margin-bottom:22px">
            <div class="a1-search">
                <span class="a1-search__ico">⌕</span>
                <input type="search" id="a1-search" class="a1-input" placeholder="...">
            </div>
            <div id="a1-cats" style="display:flex;gap:8px;flex-wrap:wrap"></div>
            <button type="button" id="a1-add-open" class="a1-btn a1-btn--accent a1-btn--sm lang-str admin-only" data-so="+ زیادکردن" data-ba="+ زێدەکرن" style="display:none">+ زیادکردن</button>
        </div>

        <div class="a1-rows" id="a1-tools"></div>

        {{-- add sheet --}}
        <div class="a1-sheet" id="a1-add-sheet" hidden>
            <div class="a1-sheet__box">
                <div class="a1-sheet__head">
                    <span class="lang-str" data-so="ئامرازی نوێ" data-ba="ئامرازێ نوی">ئامرازی نوێ</span>
                    <button type="button" class="a1-btn a1-btn--quiet a1-btn--sm" data-a1-close="a1-add-sheet">✕</button>
                </div>
                <form id="a1-add-form" class="a1-sheet__body">
                    <label class="a1-field"><span class="a1-field__label">TITLE — سۆرانی</span><input type="text" id="title_so" required class="a1-input"></label>
                    <label class="a1-field"><span class="a1-field__label">TITLE — بادینی</span><input type="text" id="title_ba" required class="a1-input"></label>
                    <label class="a1-field"><span class="a1-field__label">DESC — سۆرانی</span><textarea id="desc_so" rows="3" required class="a1-textarea"></textarea></label>
                    <label class="a1-field"><span class="a1-field__label">DESC — بادینی</span><textarea id="desc_ba" rows="3" required class="a1-textarea"></textarea></label>
                    <label class="a1-field"><span class="a1-field__label">URL</span><input type="url" id="tool_url" required dir="ltr" class="a1-input" placeholder="https://"></label>
                    <label class="a1-field"><span class="a1-field__label">CATEGORY</span>
                        <select id="tool_category" class="a1-select">
                            <option value="dev">dev</option><option value="writing">writing</option>
                            <option value="design">design</option><option value="audio_video">audio_video</option>
                            <option value="research">research</option><option value="kurdish_ai">kurdish_ai</option>
                        </select></label>
                    <label class="a1-field"><span class="a1-field__label">IMAGE</span><input type="file" id="tool_image_input" accept="image/*" class="a1-input"></label>
                    <button type="submit" id="submit-form-btn" class="a1-btn a1-btn--accent" style="width:100%">
                        <span class="lang-str" data-so="پاشەکەوت" data-ba="پاشەکەفت">پاشەکەوت</span></button>
                </form>
            </div>
        </div>

        @include('partials.a1-foot')
    </div>
</div>

<script type="module">
    import { getDatabase, ref as dbRef, push, set, remove, onValue } from "/js/firebase10/firebase-database.js";

    const KaiF = window.KaiFirebase || {};
    let app = KaiF.app ? KaiF.app() : null;
    let db = app ? getDatabase(app) : null;
    const IMGBB_API_KEY = JSON.parse((document.getElementById('kurdai-imgbb-config') || {}).textContent || 'null');

    let currentLang = localStorage.getItem('site-lang') || 'so';
    let cache = {};
    let activeCategory = 'all';
    let searchTerm = '';
    if (window.KaiTrack) window.KaiTrack.visit('ai_tools');

    /* search box */
    const searchEl = document.getElementById('a1-search');
    if (searchEl) {
        searchEl.placeholder = currentLang === 'so' ? 'گەڕان لە ئامرازەکان...' : 'گەران د ئامرازان...';
        searchEl.addEventListener('input', () => { searchTerm = searchEl.value.trim().toLowerCase(); renderTools(); });
    }

    function esc(s) { return String(s == null ? '' : s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }
    function T(o, b) { return (o && (o[b + '_' + currentLang] || o[b + '_so'])) || ''; }

    const CATS = {
        all: { so: 'هەموو', ba: 'هەمی' }, dev: { so: 'گەشەپێدان', ba: 'گەشەپێدان' },
        writing: { so: 'نووسین', ba: 'نووسین' }, design: { so: 'دیزاین', ba: 'دیزاین' },
        audio_video: { so: 'دەنگ/ڤیدیۆ', ba: 'دەنگ/ڤیدیۆ' }, research: { so: 'توێژینەوە', ba: 'توێژینەوە' },
        kurdish_ai: { so: 'AI کوردی', ba: 'AI کوردی' },
    };

    function renderCats() {
        const el = document.getElementById('a1-cats');
        el.innerHTML = Object.keys(CATS).map(k =>
            `<button type="button" data-cat="${k}" class="a1-tag ${k === activeCategory ? 'a1-tag--accent' : ''}">${CATS[k][currentLang]}</button>`).join('');
        el.querySelectorAll('[data-cat]').forEach(b => b.addEventListener('click', () => {
            activeCategory = b.dataset.cat; renderCats(); renderTools();
        }));
    }

    function renderTools() {
        const box = document.getElementById('a1-tools');
        document.getElementById('a1-tools-count').textContent = Object.keys(cache).length + ' ITEMS';
        const entries = Object.entries(cache).filter(([, t]) => {
            if (activeCategory !== 'all' && t.category !== activeCategory) return false;
            if (searchTerm) {
                const hay = [t.title_so, t.title_ba, t.desc_so, t.desc_ba, t.category]
                    .map(x => String(x || '').toLowerCase()).join(' ');
                if (!hay.includes(searchTerm)) return false;
            }
            return true;
        });
        if (!entries.length) {
            box.innerHTML = `<div class="a1-empty">EMPTY — هێشتا هیچ نییە</div>`;
            return;
        }
        const isAdmin = window.isAdmin === true;
        box.innerHTML = entries.map(([id, t]) => `
            <article class="a1-row">
                <div class="a1-row__glyph">${t.image_url ? `<img src="${esc(t.image_url)}" loading="lazy" alt="">` : 'AI'}</div>
                <div>
                    <div class="a1-row__title">${esc(T(t,'title'))}</div>
                    <p class="a1-row__desc">${esc(T(t,'desc'))}</p>
                    <div class="a1-row__meta">
                        <span class="a1-tag">${esc(t.category || '')}</span>
                    </div>
                </div>
                <div class="a1-row__actions">
                    <a href="${esc(t.tool_url || '#')}" target="_blank" rel="noopener" class="a1-btn a1-btn--accent a1-btn--sm">↗ <span class="lang-str" data-so="کردارەوە" data-ba="ڤەکرن">کردارەوە</span></a>
                    ${isAdmin ? `<button type="button" data-del="${esc(id)}" class="a1-btn a1-btn--quiet a1-btn--sm lang-str" data-so="سڕینەوە" data-ba="سڕینەوە">سڕینەوە</button>` : ''}
                </div>
            </article>`).join('');
        box.querySelectorAll('[data-del]').forEach(b => b.addEventListener('click', async () => {
            if (confirm('سڕینەوە؟') && db) await remove(dbRef(db, 'ai_tools/' + b.dataset.del));
        }));
    }

    function applyLanguage() {
        const lt = document.getElementById('lang-text');
        if (lt) lt.textContent = currentLang === 'so' ? 'بادینی' : 'سۆرانی';
        document.querySelectorAll('.lang-str').forEach(el => { el.textContent = el.getAttribute('data-' + currentLang) || el.getAttribute('data-so'); });
        renderCats(); renderTools();
    }
    document.getElementById('lang-toggle').addEventListener('click', () => {
        currentLang = currentLang === 'so' ? 'ba' : 'so';
        localStorage.setItem('site-lang', currentLang);
        applyLanguage();
    });

    function whenUser(cb) {
        if (KaiF.whenReady) KaiF.whenReady(function (st) { cb(st && st.user ? st.user : null); });
        else if (KaiF.onAuthStateChanged) KaiF.onAuthStateChanged(cb);
    }
    const ADMIN_EMAILS = ["team@alpha-ai.com", "alphaaiteam@gmail.com"];
    window.isAdmin = false;
    whenUser(function (user) {
        if (user && ADMIN_EMAILS.includes(String(user.email || '').toLowerCase())) {
            window.isAdmin = true;
            document.querySelectorAll('.admin-only').forEach(el => el.style.display = '');
        }
    });

    function closeSheet(id) { document.getElementById(id).hidden = true; }
    document.querySelectorAll('[data-a1-close]').forEach(b => b.addEventListener('click', () => closeSheet(b.dataset.a1Close)));
    document.getElementById('a1-add-open').addEventListener('click', () => { document.getElementById('a1-add-sheet').hidden = false; });

    function subscribe(fdb) {
        onValue(dbRef(fdb, 'ai_tools'), (snapshot) => { cache = snapshot.val() || {}; renderTools(); });
    }
    window.KaiPageReady(function () {
        if (db) subscribe(db);
        else if (KaiF.whenReady) KaiF.whenReady(function (S) { if (S && S.db) { db = S.db; subscribe(db); } });
    });

    let busy = false;
    document.getElementById('a1-add-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        if (busy || !db) return;
        const btn = document.getElementById('submit-form-btn');
        busy = true; btn.disabled = true;
        try {
            let image_url = '';
            const file = document.getElementById('tool_image_input').files[0];
            if (file) {
                const fd = new FormData(); fd.append('image', file);
                const res = await fetch(`https://api.imgbb.com/1/upload?key=${IMGBB_API_KEY}`, { method: 'POST', body: fd });
                const rData = await res.json();
                if (!rData.success) throw new Error('upload');
                image_url = rData.data.url;
            }
            await set(push(dbRef(db, 'ai_tools')), {
                title_so: document.getElementById('title_so').value,
                title_ba: document.getElementById('title_ba').value,
                desc_so: document.getElementById('desc_so').value,
                desc_ba: document.getElementById('desc_ba').value,
                tool_url: document.getElementById('tool_url').value,
                image_url: image_url,
                category: document.getElementById('tool_category').value
            });
            document.getElementById('a1-add-form').reset();
            closeSheet('a1-add-sheet');
        } catch (err) { alert('نەمانتوانی پاشەکەوت بکەین — دووبارە هەوڵ بدە'); }
        finally { busy = false; btn.disabled = false; }
    });

    applyLanguage();
</script>
</body>
</html>

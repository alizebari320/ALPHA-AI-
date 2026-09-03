<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    @include('partials.alpha-head')
    <title>ALPHA AI — @yield('title')</title>
</head>
<body class="al-body">

@include('partials.alpha-nav', ['active' => 'ai-tools'])

<script type="application/json" id="kurdai-firebase-config">{!! json_encode(config('kurdai.firebase'), 15) !!}</script>
<script type="application/json" id="kurdai-imgbb-config">{!! json_encode(config('kurdai.imgbb.api_key'), 15) !!}</script>
<script src="/js/kai-firebase.js?v=1" data-kai-shared defer></script>

<main class="al-container al-section">

    <header style="margin-bottom: 26px">
        <span class="al-kicker lang-str" data-so="ڕێنمایی" data-ba="ڕێنمایی">ڕێنمایی</span>
        <h1 style="font-size: 1.9rem" class="lang-str" data-so="ئامرازەکانی ژیریی دەستکرد" data-ba="ئامرازێن ژیرییا دەستکرد">ئامرازەکانی ژیریی دەستکرد</h1>
        <p class="al-hero__sub lang-str" data-so="باشترین ئامرازەکان بۆ نووسین، دیزاین، کۆد و توێژینەوە." data-ba="باشترین ئامراز بۆ نووسین، دیزاین، کۆد و توێژینەوە.">باشترین ئامرازەکان بۆ نووسین، دیزاین، کۆد و توێژینەوە.</p>
    </header>

    <div class="al-adminbar" id="al-adminbar" style="display:none">
        <span class="al-tag al-tag--accent lang-str" data-so="دەسەڵاتی ئەدمین" data-ba="دەسەڵاتا ئەدمین">دەسەڵاتی ئەدمین</span>
        <button type="button" id="al-add-open" class="al-btn al-btn--solid al-btn--sm lang-str" data-so="+ زیادکردنی ئامراز" data-ba="+ زێدەکرنا ئامرازی">+ زیادکردنی ئامراز</button>
    </div>

    <div class="al-chip-row" id="al-cats"></div>
    <div class="al-grid" id="al-tools"></div>

    {{-- ---------- add modal (admin) ---------- --}}
    <div class="al-modal" id="al-add-modal" hidden>
        <div class="al-modal__box">
            <div class="al-modal__head">
                <h3 class="lang-str" data-so="زیادکردنی ئامرازی نوێ" data-ba="زێدەکرنا ئامرازێ نوی">زیادکردنی ئامرازی نوێ</h3>
                <button type="button" class="al-iconbtn" data-al-close="al-add-modal">✕</button>
            </div>
            <form id="al-add-form" class="al-modal__body">
                <label class="al-field"><span class="al-field__label lang-str" data-so="ناونیشان (سۆرانی)" data-ba="ناونیشان (سۆرانی)">ناونیشان (سۆرانی)</span>
                    <input type="text" id="title_so" required class="al-input"></label>
                <label class="al-field"><span class="al-field__label lang-str" data-so="ناونیشان (بادینی)" data-ba="ناونیشان (بادینی)">ناونیشان (بادینی)</span>
                    <input type="text" id="title_ba" required class="al-input"></label>
                <label class="al-field"><span class="al-field__label lang-str" data-so="وەسف (سۆرانی)" data-ba="وەسف (سۆرانی)">وەسف (سۆرانی)</span>
                    <textarea id="desc_so" rows="3" required class="al-textarea"></textarea></label>
                <label class="al-field"><span class="al-field__label lang-str" data-so="وەسف (بادینی)" data-ba="وەسف (بادینی)">وەسف (بادینی)</span>
                    <textarea id="desc_ba" rows="3" required class="al-textarea"></textarea></label>
                <label class="al-field"><span class="al-field__label">URL</span>
                    <input type="url" id="tool_url" required dir="ltr" class="al-input" placeholder="https://..."></label>
                <label class="al-field"><span class="al-field__label lang-str" data-so="بەش" data-ba="بەش">بەش</span>
                    <select id="tool_category" class="al-select">
                        <option value="dev">Dev</option>
                        <option value="writing">Writing</option>
                        <option value="design">Design</option>
                        <option value="audio_video">Audio / Video</option>
                        <option value="research">Research</option>
                        <option value="kurdish_ai">Kurdish AI</option>
                    </select></label>
                <label class="al-field"><span class="al-field__label lang-str" data-so="وێنە" data-ba="وێنە">وێنە</span>
                    <input type="file" id="tool_image_input" accept="image/*" class="al-input"></label>
                <button type="submit" id="submit-form-btn" class="al-btn al-btn--solid" style="width:100%">
                    <span class="lang-str" data-so="زیادکردن" data-ba="زێدەکرن">زیادکردن</span></button>
            </form>
        </div>
    </div>

</main>

@include('partials.alpha-foot')

<script type="module">
    import { getDatabase, ref as dbRef, push, set, remove, onValue } from "/js/firebase10/firebase-database.js";

    const KaiF = window.KaiFirebase || {};
    let app = KaiF.app ? KaiF.app() : null;
    let db = app ? getDatabase(app) : null;
    const IMGBB_API_KEY = JSON.parse((document.getElementById('kurdai-imgbb-config') || {}).textContent || 'null');

    let currentLang = localStorage.getItem('site-lang') || 'so';
    let firebaseDataCache = {};
    let activeCategory = 'all';
    if (window.KaiTrack) window.KaiTrack.visit('ai_tools');

    const CATS = {
        all:         { so: 'هەموو',            ba: 'هەمی' },
        dev:         { so: 'گەشەپێدان',        ba: 'گەشەپێدان' },
        writing:     { so: 'نووسین',           ba: 'نووسین' },
        design:      { so: 'دیزاین',           ba: 'دیزاین' },
        audio_video: { so: 'دەنگ و ڤیدیۆ',     ba: 'دەنگ و ڤیدیۆ' },
        research:    { so: 'توێژینەوە',        ba: 'توێژینەوە' },
        kurdish_ai:  { so: 'AI کوردی',         ba: 'AI کوردی' },
    };

    function esc(s) { return String(s == null ? '' : s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }
    function T(obj, base) { return (obj && (obj[base + '_' + currentLang] || obj[base + '_so'])) || ''; }

    function renderCats() {
        const el = document.getElementById('al-cats');
        el.innerHTML = Object.keys(CATS).map(k =>
            `<button type="button" data-cat="${k}" class="al-tag ${k === activeCategory ? 'al-tag--accent' : ''}">${CATS[k][currentLang]}</button>`
        ).join('');
        el.querySelectorAll('[data-cat]').forEach(b => b.addEventListener('click', () => {
            activeCategory = b.dataset.cat; renderCats(); renderTools(firebaseDataCache);
        }));
    }

    function renderTools(data) {
        const box = document.getElementById('al-tools');
        if (!data || !Object.keys(data).length) {
            box.innerHTML = `<div class="al-empty lang-str" data-so="هێشتا هیچ ئامرازێک زیاد نەکراوە" data-ba="هێشتا چ ئامراز نەهاتینە زێدەکرن">هێشتا هیچ ئامرازێک زیاد نەکراوە</div>`;
            return;
        }
        const isAdmin = window.isAdmin === true;
        const rows = Object.entries(data)
            .filter(([, t]) => activeCategory === 'all' || t.category === activeCategory)
            .map(([id, t]) => `
            <article class="al-card al-fade-in">
                <div class="al-item__media">${t.image_url ? `<img src="${esc(t.image_url)}" loading="lazy" alt="${esc(T(t,'title'))}">` : ''}
                </div>
                <div class="al-item__body">
                    <span class="al-tag">${esc(CATS[t.category] ? CATS[t.category][currentLang] : (t.category || '—'))}</span>
                    <div class="al-item__title" style="margin-top:8px">${esc(T(t,'title'))}</div>
                    <p class="al-item__desc">${esc(T(t,'desc'))}</p>
                    <div style="display:flex;gap:8px;margin-top:14px;flex-wrap:wrap">
                        <a href="${esc(t.tool_url || '#')}" target="_blank" rel="noopener" class="al-btn al-btn--solid al-btn--sm" style="flex:1">↗ <span class="lang-str" data-so="سەردان" data-ba="سەردان">سەردان</span></a>
                        ${isAdmin ? `<button type="button" data-del="${esc(id)}" class="al-btn al-btn--danger al-btn--sm lang-str" data-so="سڕینەوە" data-ba="سڕینەوە">سڕینەوە</button>` : ''}
                    </div>
                </div>
            </article>`);
        box.innerHTML = rows.length ? rows.join('') : `<div class="al-empty lang-str" data-so="هیچ ئامرازێک لەم بەشەدا نییە" data-ba="چ ئامراز د ڤێ بەشێدا نین">هیچ ئامرازێک لەم بەشەدا نییە</div>`;
        box.querySelectorAll('[data-del]').forEach(b => b.addEventListener('click', async () => {
            if (confirm('دڵنیایت لە سڕینەوە؟') && db) { await remove(dbRef(db, 'ai_tools/' + b.dataset.del)); }
        }));
    }

    function applyLanguage() {
        const lt = document.getElementById('lang-text');
        if (lt) lt.textContent = currentLang === 'so' ? 'بادینی' : 'سۆرانی';
        document.querySelectorAll('.lang-str').forEach(el => { el.textContent = el.getAttribute('data-' + currentLang) || el.getAttribute('data-so'); });
        renderCats(); renderTools(firebaseDataCache);
    }
    document.getElementById('lang-toggle').addEventListener('click', () => {
        currentLang = currentLang === 'so' ? 'ba' : 'so';
        localStorage.setItem('site-lang', currentLang);
        applyLanguage();
    });

    /* modal helpers */
    function openModal(id) { document.getElementById(id).hidden = false; }
    function closeModal(id) { document.getElementById(id).hidden = true; }
    document.querySelectorAll('[data-al-close]').forEach(b => b.addEventListener('click', () => closeModal(b.dataset.alClose)));
    document.getElementById('al-add-open').addEventListener('click', () => openModal('al-add-modal'));

    /* admin detection (same rule as before) */
    const ADMIN_EMAILS = ["team@alpha-ai.com", "alphaaiteam@gmail.com"];
    window.isAdmin = false;
    function whenUser(cb) {
        if (KaiF.whenReady) KaiF.whenReady(function (st) { cb(st && st.user ? st.user : null); });
        else if (KaiF.onAuthStateChanged) KaiF.onAuthStateChanged(cb);
    }
    whenUser(function (user) {
        if (user && ADMIN_EMAILS.includes(String(user.email || '').toLowerCase())) {
            window.isAdmin = true;
            document.getElementById('al-adminbar').style.display = '';
        }
    });

    /* subscribe */
    function subscribe(fdb) {
        onValue(dbRef(fdb, 'ai_tools'), (snapshot) => {
            firebaseDataCache = snapshot.val() || {};
            renderTools(firebaseDataCache);
        });
    }
    window.KaiPageReady(function () {
        if (db) subscribe(db);
        else if (KaiF.whenReady) KaiF.whenReady(function (S) { if (S && S.db) { db = S.db; subscribe(db); } });
    });

    /* add form — same contract: imgbb → set(push(ai_tools)) */
    let isUploading = false;
    document.getElementById('al-add-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        if (isUploading || !db) return;
        const btn = document.getElementById('submit-form-btn');
        isUploading = true; btn.disabled = true; btn.style.opacity = .6;

        try {
            let image_url = '';
            const file = document.getElementById('tool_image_input').files[0];
            if (file) {
                const fd = new FormData(); fd.append('image', file);
                const res = await fetch(`https://api.imgbb.com/1/upload?key=${IMGBB_API_KEY}`, { method: 'POST', body: fd });
                const rData = await res.json();
                if (!rData.success) throw new Error('upload failed');
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
            document.getElementById('al-add-form').reset();
            closeModal('al-add-modal');
        } catch (err) {
            alert('نەتوانرا زیاد بکرێت — دووبارە هەوڵ بدەرەوە');
        } finally {
            isUploading = false; btn.disabled = false; btn.style.opacity = 1;
        }
    });

    applyLanguage();
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="ckb" dir="rtl" class="dark">
<head>
    @include('partials.a1-head')
    <title>ALPHA AI — @yield('title')</title>
</head>
<body class="a1">

@include('partials.a1-rail', ['active' => 'courses'])


<div class="a1-main">
    <div class="a1-page">

        <div class="a1-strip"><span class="a1-strip__dot"></span><span class="a1-strip__crumb">ALPHA / COURSES</span></div>

        <div class="a1-section-head">
            <h2 class="lang-str" data-so="کۆرسەکان" data-ba="کۆرس">کۆرسەکان</h2>
            <span class="a1-index" id="a1-count">—</span>
        </div>

        <div class="a1-hrow" style="margin-bottom:22px">
            <span></span>
            <button type="button" id="a1-add-open" class="a1-btn a1-btn--accent a1-btn--sm lang-str admin-only" data-so="+ کۆرسی نوێ" data-ba="+ کۆرسێ نوی" style="display:none">+ کۆرسی نوێ</button>
        </div>

        <div class="a1-rows" id="a1-courses"></div>

        <div class="a1-sheet" id="a1-add-sheet" hidden>
            <div class="a1-sheet__box">
                <div class="a1-sheet__head">
                    <span class="lang-str" data-so="کۆرسی نوێ" data-ba="کۆرسێ نوی">کۆرسی نوێ</span>
                    <button type="button" class="a1-btn a1-btn--quiet a1-btn--sm" data-a1-close="a1-add-sheet">✕</button>
                </div>
                <form id="a1-add-form" class="a1-sheet__body">
                    <label class="a1-field"><span class="a1-field__label">TITLE — سۆرانی</span><input type="text" id="title_so" required class="a1-input"></label>
                    <label class="a1-field"><span class="a1-field__label">TITLE — بادینی</span><input type="text" id="title_ba" required class="a1-input"></label>
                    <label class="a1-field"><span class="a1-field__label">DESC — سۆرانی</span><textarea id="desc_so" rows="3" class="a1-textarea"></textarea></label>
                    <label class="a1-field"><span class="a1-field__label">DESC — بادینی</span><textarea id="desc_ba" rows="3" class="a1-textarea"></textarea></label>
                    <label class="a1-field"><span class="a1-field__label">VIDEO URL</span><input type="url" id="video_url" dir="ltr" class="a1-input" placeholder="https://"></label>
                    <label class="a1-field"><span class="a1-field__label">PRICE ($)</span><input type="number" id="price" min="0" class="a1-input" placeholder="0"></label>
                    <label class="a1-field"><span class="a1-field__label">IMAGE</span><input type="file" id="course_image_input" accept="image/*" class="a1-input"></label>
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
    if (window.KaiTrack) window.KaiTrack.visit('courses');

    function esc(s) { return String(s == null ? '' : s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }
    function T(o, b) { return (o && (o[b + '_' + currentLang] || o[b + '_so'])) || ''; }

    function render() {
        const box = document.getElementById('a1-courses');
        document.getElementById('a1-count').textContent = Object.keys(cache).length + ' ITEMS';
        const entries = Object.entries(cache);
        if (!entries.length) { box.innerHTML = `<div class="a1-empty">EMPTY</div>`; return; }
        const isAdmin = window.isAdmin === true;
        box.innerHTML = entries.map(([id, c]) => `
            <article class="a1-row">
                <div class="a1-row__glyph">${c.image_url ? `<img src="${esc(c.image_url)}" loading="lazy" alt="">` : '▶'}</div>
                <div>
                    <div class="a1-row__title">${esc(T(c,'title'))}</div>
                    <p class="a1-row__desc">${esc(T(c,'desc'))}</p>
                    <div class="a1-row__meta">
                        ${Number(c.price) > 0 ? `<span class="a1-tag a1-tag--accent">$${esc(c.price)}</span>` : `<span class="a1-tag">FREE</span>`}
                    </div>
                </div>
                <div class="a1-row__actions">
                    ${c.video_url ? `<a href="${esc(c.video_url)}" target="_blank" rel="noopener" class="a1-btn a1-btn--accent a1-btn--sm">▶ <span class="lang-str" data-so="سەیر" data-ba="تحەپل">سەیر</span></a>` : ''}
                    ${isAdmin ? `<button type="button" data-del="${esc(id)}" class="a1-btn a1-btn--quiet a1-btn--sm lang-str" data-so="سڕینەوە" data-ba="سڕینەوە">سڕینەوە</button>` : ''}
                </div>
            </article>`).join('');
        box.querySelectorAll('[data-del]').forEach(b => b.addEventListener('click', async () => {
            if (confirm('سڕینەوە؟') && db) await remove(dbRef(db, 'courses/' + b.dataset.del));
        }));
    }

    function applyLanguage() {
        const lt = document.getElementById('lang-text');
        if (lt) lt.textContent = currentLang === 'so' ? 'بادینی' : 'سۆرانی';
        document.querySelectorAll('.lang-str').forEach(el => { el.textContent = el.getAttribute('data-' + currentLang) || el.getAttribute('data-so'); });
        render();
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
        onValue(dbRef(fdb, 'courses'), (snapshot) => { cache = snapshot.val() || {}; render(); });
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
            const file = document.getElementById('course_image_input').files[0];
            if (file) {
                const fd = new FormData(); fd.append('image', file);
                const res = await fetch(`https://api.imgbb.com/1/upload?key=${IMGBB_API_KEY}`, { method: 'POST', body: fd });
                const rData = await res.json();
                if (!rData.success) throw new Error('upload');
                image_url = rData.data.url;
            }
            await set(push(dbRef(db, 'courses')), {
                title_so: document.getElementById('title_so').value,
                title_ba: document.getElementById('title_ba').value,
                desc_so: document.getElementById('desc_so').value,
                desc_ba: document.getElementById('desc_ba').value,
                video_url: document.getElementById('video_url').value,
                price: Number(document.getElementById('price').value) || 0,
                image_url: image_url
            });
            document.getElementById('a1-add-form').reset();
            closeSheet('a1-add-sheet');
        } catch (err) { alert('نەمانتوانی پاشەکەوت بکەین'); }
        finally { busy = false; btn.disabled = false; }
    });

    applyLanguage();
</script>
</body>
</html>

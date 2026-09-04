<!DOCTYPE html>
<html lang="ckb" dir="rtl" class="dark">
<head>
    @include('partials.a1-head')
    <title>ALPHA AI — @yield('title')</title>
</head>
<body class="a1">

@include('partials.a1-rail', ['active' => 'universities'])


<div class="a1-main">
    <div class="a1-page">

        <div class="a1-strip"><span class="a1-strip__dot"></span><span class="a1-strip__crumb">ALPHA / UNIS</span></div>

        <div class="a1-section-head">
            <h2 class="lang-str" data-so="زانکۆکان" data-ba="زانکۆ">زانکۆکان</h2>
            <span class="a1-index" id="a1-count">—</span>
        </div>

        <div class="a1-hrow" style="margin-bottom:22px">
            <span></span>
            <button type="button" id="a1-add-open" class="a1-btn a1-btn--accent a1-btn--sm lang-str admin-only" data-so="+ زانکۆی نوێ" data-ba="+ زانکۆیا نوی" style="display:none">+ زانکۆی نوێ</button>
        </div>

        <div class="a1-rows" id="a1-unis"></div>

        <div class="a1-sheet" id="a1-add-sheet" hidden>
            <div class="a1-sheet__box">
                <div class="a1-sheet__head">
                    <span class="lang-str" data-so="زانکۆی نوێ" data-ba="زانکۆیا نوی">زانکۆی نوێ</span>
                    <button type="button" class="a1-btn a1-btn--quiet a1-btn--sm" data-a1-close="a1-add-sheet">✕</button>
                </div>
                <form id="a1-add-form" class="a1-sheet__body">
                    <label class="a1-field"><span class="a1-field__label">NAME — سۆرانی</span><input type="text" id="uni_name_so" required class="a1-input"></label>
                    <label class="a1-field"><span class="a1-field__label">NAME — بادینی</span><input type="text" id="uni_name_ba" required class="a1-input"></label>
                    <label class="a1-field"><span class="a1-field__label">LOGO URL</span><input type="url" id="uni_logo_url" dir="ltr" class="a1-input" placeholder="https://"></label>
                    <label class="a1-field"><span class="a1-field__label">WEB URL</span><input type="url" id="uni_web_url" dir="ltr" class="a1-input" placeholder="https://"></label>
                    <button type="submit" class="a1-btn a1-btn--accent" style="width:100%">
                        <span class="lang-str" data-so="پاشەکەوت" data-ba="پاشەکەفت">پاشەکەوت</span></button>
                </form>
            </div>
        </div>

        <div class="a1-sheet" id="a1-schedule-sheet" hidden>
            <div class="a1-sheet__box">
                <div class="a1-sheet__head">
                    <span class="lang-str" data-so="خشتەی هەفتانە" data-ba="خشتەیا هەفتانە">خشتەی هەفتانە</span>
                    <button type="button" class="a1-btn a1-btn--quiet a1-btn--sm" data-a1-close="a1-schedule-sheet">✕</button>
                </div>
                <div class="a1-sheet__body" id="a1-schedule-body"></div>
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

    let currentLang = localStorage.getItem('site-lang') || 'so';
    let unisData = {};
    if (window.KaiTrack) window.KaiTrack.visit('universities');

    function esc(s) { return String(s == null ? '' : s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }
    function T(o, b) { return (o && (o[b + '_' + currentLang] || o[b + '_so'])) || ''; }
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

    const DAYS = { so: ['شەممە','یەکشەممە','دووشەممە','سێشەممە','چوارشەممە','پێنجشەممە','هەینی'], ba: ['شەم','یەکشەم','دوشەم','سێشەم','چوارشەم','پێنجشەم','هەینی'] };

    function render() {
        const box = document.getElementById('a1-unis');
        const entries = Object.entries(unisData);
        document.getElementById('a1-count').textContent = entries.length + ' ITEMS';
        if (!entries.length) { box.innerHTML = `<div class="a1-empty">EMPTY</div>`; return; }
        const isAdmin = window.isAdmin === true;
        box.innerHTML = entries.map(([id, u]) => `
            <article class="a1-row">
                <div class="a1-row__glyph">${u.logo_url ? `<img src="${esc(u.logo_url)}" loading="lazy" alt="" style="object-fit:contain;padding:10px">` : 'U'}</div>
                <div>
                    <div class="a1-row__title">${esc(T(u,'name'))}</div>
                </div>
                <div class="a1-row__actions">
                    ${u.web_url ? `<a href="${esc(u.web_url)}" target="_blank" rel="noopener" class="a1-btn a1-btn--accent a1-btn--sm">↗ <span class="lang-str" data-so="کردارەوە" data-ba="ڤەکرن">کردارەوە</span></a>` : ''}
                    <button type="button" data-schedule="${esc(id)}" class="a1-btn a1-btn--line a1-btn--sm">🗓 <span class="lang-str" data-so="خشتە" data-ba="خشتە">خشتە</span></button>
                    ${isAdmin ? `<button type="button" data-del="${esc(id)}" class="a1-btn a1-btn--quiet a1-btn--sm lang-str" data-so="سڕینەوە" data-ba="سڕینەوە">سڕینەوە</button>` : ''}
                </div>
            </article>`).join('');
        box.querySelectorAll('[data-del]').forEach(b => b.addEventListener('click', async () => {
            if (confirm('سڕینەوە؟') && db) await remove(dbRef(db, 'universities/' + b.dataset.del));
        }));
        box.querySelectorAll('[data-schedule]').forEach(b => b.addEventListener('click', () => openSchedule(b.dataset.schedule)));
    }

    function openSchedule(uniId) {
        const u = unisData[uniId] || {};
        const schedules = u.schedules || {};
        const days = DAYS[currentLang] || DAYS.so;
        const rows = Object.keys(schedules).length
            ? Object.entries(schedules).map(([day, info]) => `
                <div style="border:1px solid var(--a1-line);padding:12px 16px;margin-bottom:8px">
                    <strong style="font-size:0.9rem">${esc(days[day] || day)}</strong>
                    <p style="font-size:0.85rem;color:var(--a1-dim);margin:4px 0 0">${esc(typeof info === 'string' ? info : (info.text || ''))}</p>
                </div>`).join('')
            : `<div class="a1-empty">—</div>`;
        document.getElementById('a1-schedule-body').innerHTML = `<h3 style="margin-bottom:14px">${esc(T(u,'name'))}</h3>` + rows;
        document.getElementById('a1-schedule-sheet').hidden = false;
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

    function closeSheet(id) { document.getElementById(id).hidden = true; }
    document.querySelectorAll('[data-a1-close]').forEach(b => b.addEventListener('click', () => closeSheet(b.dataset.a1Close)));
    document.getElementById('a1-add-open').addEventListener('click', () => { document.getElementById('a1-add-sheet').hidden = false; });

    function subscribe(fdb) {
        onValue(dbRef(fdb, 'universities'), (s) => { unisData = s.val() || {}; render(); });
    }
    window.KaiPageReady(function () {
        if (db) subscribe(db);
        else if (KaiF.whenReady) KaiF.whenReady(function (S) { if (S && S.db) { db = S.db; subscribe(db); } });
    });

    document.getElementById('a1-add-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!db) return;
        await set(push(dbRef(db, 'universities')), {
            name_so: document.getElementById('uni_name_so').value,
            name_ba: document.getElementById('uni_name_ba').value,
            logo_url: document.getElementById('uni_logo_url').value,
            web_url: document.getElementById('uni_web_url').value
        });
        document.getElementById('a1-add-form').reset();
        closeSheet('a1-add-sheet');
    });

    applyLanguage();
</script>
</body>
</html>

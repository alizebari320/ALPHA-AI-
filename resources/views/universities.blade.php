<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    @include('partials.alpha-head')
    <title>ALPHA AI — @yield('title')</title>
</head>
<body class="al-body">

@include('partials.alpha-nav', ['active' => 'universities'])

<script type="application/json" id="kurdai-firebase-config">{!! json_encode(config('kurdai.firebase'), 15) !!}</script>
<script type="application/json" id="kurdai-imgbb-config">{!! json_encode(config('kurdai.imgbb.api_key'), 15) !!}</script>
<script src="/js/kai-firebase.js?v=1" data-kai-shared defer></script>

<main class="al-container al-section">

    <header style="margin-bottom: 26px">
        <span class="al-kicker lang-str" data-so="خوێندن" data-ba="خوێندن">خوێندن</span>
        <h1 style="font-size: 1.9rem" class="lang-str" data-so="زانکۆکان" data-ba="زانکۆ">زانکۆکان</h1>
    </header>

    <div class="al-adminbar" id="al-adminbar" style="display:none">
        <span class="al-tag al-tag--accent lang-str" data-so="دەسەڵاتی ئەدمین" data-ba="دەسەڵاتا ئەدمین">دەسەڵاتی ئەدمین</span>
        <button type="button" id="al-add-open" class="al-btn al-btn--solid al-btn--sm lang-str" data-so="+ زانکۆی نوێ" data-ba="+ زانکۆیا نوی">+ زانکۆی نوێ</button>
    </div>

    <div class="al-grid" id="al-unis"></div>

    {{-- add modal --}}
    <div class="al-modal" id="al-add-modal" hidden>
        <div class="al-modal__box">
            <div class="al-modal__head">
                <h3 class="lang-str" data-so="زیادکردنی زانکۆ" data-ba="زێدەکرنا زانکۆیێ">زیادکردنی زانکۆ</h3>
                <button type="button" class="al-iconbtn" data-al-close="al-add-modal">✕</button>
            </div>
            <form id="al-add-form" class="al-modal__body">
                <label class="al-field"><span class="al-field__label">Name (سۆرانی)</span>
                    <input type="text" id="uni_name_so" required class="al-input"></label>
                <label class="al-field"><span class="al-field__label">Name (بادینی)</span>
                    <input type="text" id="uni_name_ba" required class="al-input"></label>
                <label class="al-field"><span class="al-field__label">Logo URL</span>
                    <input type="url" id="uni_logo_url" dir="ltr" class="al-input" placeholder="https://..."></label>
                <label class="al-field"><span class="al-field__label">Web URL</span>
                    <input type="url" id="uni_web_url" dir="ltr" class="al-input" placeholder="https://..."></label>
                <button type="submit" id="submit-form-btn" class="al-btn al-btn--solid" style="width:100%">
                    <span class="lang-str" data-so="زیادکردن" data-ba="زێدەکرن">زیادکردن</span></button>
            </form>
        </div>
    </div>

    {{-- schedule modal --}}
    <div class="al-modal" id="al-schedule-modal" hidden>
        <div class="al-modal__box">
            <div class="al-modal__head">
                <h3 class="lang-str" data-so="خشتەی هەفتانە" data-ba="خشتەیا هەفتانە">خشتەی هەفتانە</h3>
                <button type="button" class="al-iconbtn" data-al-close="al-schedule-modal">✕</button>
            </div>
            <div class="al-modal__body" id="al-schedule-body"></div>
        </div>
    </div>

</main>

@include('partials.alpha-foot')

<script type="module">
    import { getDatabase, ref as dbRef, push, set, update, remove, onValue } from "/js/firebase10/firebase-database.js";

    const KaiF = window.KaiFirebase || {};
    let app = KaiF.app ? KaiF.app() : null;
    let db = app ? getDatabase(app) : null;

    let currentLang = localStorage.getItem('site-lang') || 'so';
    let unisData = {};
    if (window.KaiTrack) window.KaiTrack.visit('universities');

    function esc(s) { return String(s == null ? '' : s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }
    function T(obj, base) { return (obj && (obj[base + '_' + currentLang] || obj[base + '_so'])) || ''; }
    function whenUser(cb) {
        if (KaiF.whenReady) KaiF.whenReady(function (st) { cb(st && st.user ? st.user : null); });
        else if (KaiF.onAuthStateChanged) KaiF.onAuthStateChanged(cb);
    }

    const ADMIN_EMAILS = ["team@alpha-ai.com", "alphaaiteam@gmail.com"];
    window.isAdmin = false;
    whenUser(function (user) {
        if (user && ADMIN_EMAILS.includes(String(user.email || '').toLowerCase())) {
            window.isAdmin = true;
            document.getElementById('al-adminbar').style.display = '';
        }
    });

    const DAYS = { so: ['شەممە','یەکشەممە','دووشەممە','سێشەممە','چوارشەممە','پێنجشەممە','هەینی'], ba: ['شەم','یەکشەم','دوشەم','سێشەم','چوارشەم','پێنجشەم','هەینی'] };

    function renderUnis() {
        const box = document.getElementById('al-unis');
        const entries = Object.entries(unisData);
        if (!entries.length) {
            box.innerHTML = `<div class="al-empty lang-str" data-so="هێشتا هیچ زانکۆیێک زیاد نەکراوە" data-ba="هێشتا چ زانکۆ نەهاتینە زێدەکرن">هێشتا هیچ زانکۆیێک زیاد نەکراوە</div>`;
            return;
        }
        const isAdmin = window.isAdmin === true;
        box.innerHTML = entries.map(([id, u]) => `
            <article class="al-card al-fade-in">
                <div class="al-item__media" style="aspect-ratio:4/3">
                    ${u.logo_url ? `<img src="${esc(u.logo_url)}" loading="lazy" alt="${esc(T(u,'name'))}" style="object-fit:contain;padding:18px">` : ''}
                </div>
                <div class="al-item__body">
                    <div class="al-item__title">${esc(T(u,'name'))}</div>
                    <div style="display:flex;gap:8px;margin-top:14px;flex-wrap:wrap">
                        ${u.web_url ? `<a href="${esc(u.web_url)}" target="_blank" rel="noopener" class="al-btn al-btn--solid al-btn--sm" style="flex:1">↗ <span class="lang-str" data-so="سەردان" data-ba="سەردان">سەردان</span></a>` : ''}
                        <button type="button" data-schedule="${esc(id)}" class="al-btn al-btn--ghost al-btn--sm">🗓 <span class="lang-str" data-so="خشتە" data-ba="خشتە">خشتە</span></button>
                        ${isAdmin ? `<button type="button" data-del="${esc(id)}" class="al-btn al-btn--danger al-btn--sm lang-str" data-so="سڕینەوە" data-ba="سڕینەوە">سڕینەوە</button>` : ''}
                    </div>
                </div>
            </article>`).join('');

        box.querySelectorAll('[data-del]').forEach(b => b.addEventListener('click', async () => {
            if (confirm('دڵنیایت لە سڕینەوە؟') && db) await remove(dbRef(db, 'universities/' + b.dataset.del));
        }));
        box.querySelectorAll('[data-schedule]').forEach(b => b.addEventListener('click', () => openSchedule(b.dataset.schedule)));
    }

    function openSchedule(uniId) {
        const u = unisData[uniId] || {};
        const modal = document.getElementById('al-schedule-modal');
        const body = document.getElementById('al-schedule-body');
        const schedules = u.schedules || {};
        const days = DAYS[currentLang] || DAYS.so;
        const rows = Object.keys(schedules).length
            ? Object.entries(schedules).map(([day, info]) => `
                <div class="al-card al-card--pad" style="padding:12px 16px;margin-bottom:8px">
                    <strong style="font-size:0.9rem">${esc(days[day] || day)}</strong>
                    <p style="font-size:0.85rem;color:var(--al-muted);margin-top:4px">${esc(typeof info === 'string' ? info : (info.text || ''))}</p>
                </div>`).join('')
            : `<div class="al-empty" style="padding:20px">خشتە بەردەست نییە</div>`;
        body.innerHTML = `<h4 style="margin-bottom:14px">${esc(T(u,'name'))}</h4>` + rows;
        modal.hidden = false;
    }

    function applyLanguage() {
        const lt = document.getElementById('lang-text');
        if (lt) lt.textContent = currentLang === 'so' ? 'بادینی' : 'سۆرانی';
        document.querySelectorAll('.lang-str').forEach(el => { el.textContent = el.getAttribute('data-' + currentLang) || el.getAttribute('data-so'); });
        renderUnis();
    }
    document.getElementById('lang-toggle').addEventListener('click', () => {
        currentLang = currentLang === 'so' ? 'ba' : 'so';
        localStorage.setItem('site-lang', currentLang);
        applyLanguage();
    });

    function closeModal(id) { document.getElementById(id).hidden = true; }
    document.querySelectorAll('[data-al-close]').forEach(b => b.addEventListener('click', () => closeModal(b.dataset.alClose)));
    document.getElementById('al-add-open').addEventListener('click', () => { document.getElementById('al-add-modal').hidden = false; });

    function subscribe(fdb) {
        onValue(dbRef(fdb, 'universities'), (s) => { unisData = s.val() || {}; renderUnis(); });
    }
    window.KaiPageReady(function () {
        if (db) subscribe(db);
        else if (KaiF.whenReady) KaiF.whenReady(function (S) { if (S && S.db) { db = S.db; subscribe(db); } });
    });

    document.getElementById('al-add-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!db) return;
        await set(push(dbRef(db, 'universities')), {
            name_so: document.getElementById('uni_name_so').value,
            name_ba: document.getElementById('uni_name_ba').value,
            logo_url: document.getElementById('uni_logo_url').value,
            web_url: document.getElementById('uni_web_url').value
        });
        document.getElementById('al-add-form').reset();
        closeModal('al-add-modal');
    });

    applyLanguage();
</script>
</body>
</html>

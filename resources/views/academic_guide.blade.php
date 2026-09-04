<!DOCTYPE html>
<html lang="ckb" dir="rtl" class="dark">
<head>
    @include('partials.a1-head')
    <title>ALPHA AI — @yield('title')</title>
</head>
<body class="a1">

@include('partials.a1-rail', ['active' => 'academic-guide'])


<div class="a1-main">
    <div class="a1-page">

        <div class="a1-strip"><span class="a1-strip__dot"></span><span class="a1-strip__crumb">ALPHA / GUIDE</span></div>

        <div class="a1-section-head">
            <h2 class="lang-str" data-so="ڕێبەری خوێندن" data-ba="ڕێبەرێ خوێندنێ">ڕێبەری خوێندن</h2>
            <span class="a1-index" id="a1-count">—</span>
        </div>

        <div class="a1-hrow" style="margin-bottom:22px">
            <span></span>
            <button type="button" id="a1-add-open" class="a1-btn a1-btn--accent a1-btn--sm lang-str admin-only" data-so="+ پرسیاری نوێ" data-ba="+ پرسیارێ نوی" style="display:none">+ پرسیاری نوێ</button>
        </div>

        <div class="a1-rows" id="a1-guide"></div>

        <div class="a1-sheet" id="a1-add-sheet" hidden>
            <div class="a1-sheet__box">
                <div class="a1-sheet__head">
                    <span class="lang-str" data-so="پرسیاری نوێ" data-ba="پرسیارێ نوی">پرسیاری نوێ</span>
                    <button type="button" class="a1-btn a1-btn--quiet a1-btn--sm" data-a1-close="a1-add-sheet">✕</button>
                </div>
                <form id="a1-add-form" class="a1-sheet__body">
                    <label class="a1-field"><span class="a1-field__label">Q — سۆرانی</span><input type="text" id="guide_question_so" required class="a1-input"></label>
                    <label class="a1-field"><span class="a1-field__label">Q — بادینی</span><input type="text" id="guide_question_ba" class="a1-input"></label>
                    <label class="a1-field"><span class="a1-field__label">A — سۆرانی</span><textarea id="guide_answer_so" rows="4" required class="a1-textarea"></textarea></label>
                    <label class="a1-field"><span class="a1-field__label">A — بادینی</span><textarea id="guide_answer_ba" rows="4" class="a1-textarea"></textarea></label>
                    <button type="submit" class="a1-btn a1-btn--accent" style="width:100%">
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

    let currentLang = localStorage.getItem('site-lang') || 'so';
    let guideData = {};
    if (window.KaiTrack) window.KaiTrack.visit('academic_guide');

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

    function render() {
        const box = document.getElementById('a1-guide');
        const entries = Object.entries(guideData);
        document.getElementById('a1-count').textContent = entries.length + ' ITEMS';
        if (!entries.length) { box.innerHTML = `<div class="a1-empty">EMPTY</div>`; return; }
        const isAdmin = window.isAdmin === true;
        box.innerHTML = entries.map(([id, g]) => `
            <details class="a1-row" style="display:block;padding-top:20px">
                <summary style="cursor:pointer;list-style:none;display:flex;justify-content:space-between;align-items:center;gap:12px;font-weight:800;font-size:1.05rem">
                    <span>${esc(T(g,'question'))}</span><span style="color:var(--a1-accent)">+</span>
                </summary>
                <p style="color:var(--a1-dim);line-height:1.9;margin:12px 0 0">${esc(T(g,'answer'))}</p>
                ${isAdmin ? `<button type="button" data-del="${esc(id)}" class="a1-btn a1-btn--quiet a1-btn--sm lang-str" style="margin-top:10px" data-so="سڕینەوە" data-ba="سڕینەوە">سڕینەوە</button>` : ''}
            </details>`).join('');
        box.querySelectorAll('[data-del]').forEach(b => b.addEventListener('click', async () => {
            if (confirm('سڕینەوە؟') && db) await remove(dbRef(db, 'academic_guide/' + b.dataset.del));
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

    function closeSheet(id) { document.getElementById(id).hidden = true; }
    document.querySelectorAll('[data-a1-close]').forEach(b => b.addEventListener('click', () => closeSheet(b.dataset.a1Close)));
    document.getElementById('a1-add-open').addEventListener('click', () => { document.getElementById('a1-add-sheet').hidden = false; });

    function subscribe(fdb) {
        onValue(dbRef(fdb, 'academic_guide'), (s) => { guideData = s.val() || {}; render(); });
    }
    window.KaiPageReady(function () {
        if (db) subscribe(db);
        else if (KaiF.whenReady) KaiF.whenReady(function (S) { if (S && S.db) { db = S.db; subscribe(db); } });
    });

    document.getElementById('a1-add-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!db) return;
        await set(push(dbRef(db, 'academic_guide')), {
            question_so: document.getElementById('guide_question_so').value,
            question_ba: document.getElementById('guide_question_ba').value,
            answer_so: document.getElementById('guide_answer_so').value,
            answer_ba: document.getElementById('guide_answer_ba').value
        });
        document.getElementById('a1-add-form').reset();
        closeSheet('a1-add-sheet');
    });

    applyLanguage();
</script>
</body>
</html>

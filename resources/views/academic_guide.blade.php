<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    @include('partials.alpha-head')
    <title>ALPHA AI — @yield('title')</title>
</head>
<body class="al-body">

@include('partials.alpha-nav', ['active' => 'academic-guide'])

<script type="application/json" id="kurdai-firebase-config">{!! json_encode(config('kurdai.firebase'), 15) !!}</script>
<script src="/js/kai-firebase.js?v=1" data-kai-shared defer></script>

<main class="al-container al-section">

    <header style="margin-bottom: 26px">
        <span class="al-kicker lang-str" data-so="ڕێبەر" data-ba="ڕێبەر">ڕێبەر</span>
        <h1 style="font-size: 1.9rem" class="lang-str" data-so="ڕێنیشاندەری خوێندن" data-ba="ڕێبەرێ خوێندنێ">ڕێنیشاندەری خوێندن</h1>
        <p class="al-hero__sub lang-str" data-so="وەڵامی پرسیارە باوەکانی بواری خوێندن و کار." data-ba="وەڵاما پرسیارێن باوێن بواری خوێندنێ و کار.">وەڵامی پرسیارە باوەکانی بواری خوێندن و کار.</p>
    </header>

    <div class="al-adminbar" id="al-adminbar" style="display:none">
        <span class="al-tag al-tag--accent lang-str" data-so="دەسەڵاتی ئەدمین" data-ba="دەسەڵاتا ئەدمین">دەسەڵاتی ئەدمین</span>
        <button type="button" id="al-add-open" class="al-btn al-btn--solid al-btn--sm lang-str" data-so="+ پرسیاری نوێ" data-ba="+ پرسیارێ نوی">+ پرسیاری نوێ</button>
    </div>

    <div id="al-guide" style="display:grid;gap:14px"></div>

    {{-- add modal --}}
    <div class="al-modal" id="al-add-modal" hidden>
        <div class="al-modal__box">
            <div class="al-modal__head">
                <h3 class="lang-str" data-so="زیادکردنی پرسیار" data-ba="زێدەکرنا پرسیاری">زیادکردنی پرسیار</h3>
                <button type="button" class="al-iconbtn" data-al-close="al-add-modal">✕</button>
            </div>
            <form id="al-add-form" class="al-modal__body">
                <label class="al-field"><span class="al-field__label">Question (سۆرانی)</span>
                    <input type="text" id="guide_question_so" required class="al-input"></label>
                <label class="al-field"><span class="al-field__label">Question (بادینی)</span>
                    <input type="text" id="guide_question_ba" class="al-input"></label>
                <label class="al-field"><span class="al-field__label lang-str" data-so="وەڵام (سۆرانی)" data-ba="وەڵام (سۆرانی)">وەڵام (سۆرانی)</span>
                    <textarea id="guide_answer_so" rows="4" required class="al-textarea"></textarea></label>
                <label class="al-field"><span class="al-field__label lang-str" data-so="وەڵام (بادینی)" data-ba="وەڵام (بادینی)">وەڵام (بادینی)</span>
                    <textarea id="guide_answer_ba" rows="4" class="al-textarea"></textarea></label>
                <button type="submit" class="al-btn al-btn--solid" style="width:100%">
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

    let currentLang = localStorage.getItem('site-lang') || 'so';
    let guideData = {};
    if (window.KaiTrack) window.KaiTrack.visit('academic_guide');

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

    function renderGuide() {
        const box = document.getElementById('al-guide');
        const entries = Object.entries(guideData);
        if (!entries.length) {
            box.innerHTML = `<div class="al-empty lang-str" data-so="هێشتا هیچ پرسیارێک نییە" data-ba="هێشتا چ پرسیار نین">هێشتا هیچ پرسیارێک نییە</div>`;
            return;
        }
        const isAdmin = window.isAdmin === true;
        box.innerHTML = entries.map(([id, g]) => `
            <details class="al-card al-fade-in" style="padding:0">
                <summary style="padding:18px 20px;cursor:pointer;font-weight:800;color:var(--al-ink);list-style:none;display:flex;justify-content:space-between;align-items:center;gap:12px">
                    <span>${esc(T(g,'question'))}</span>
                    <span style="color:var(--al-accent);font-size:1.2rem">+</span>
                </summary>
                <div style="padding:0 20px 18px;border-top:1px solid var(--al-line);padding-top:14px">
                    <p style="color:var(--al-muted);line-height:1.8">${esc(T(g,'answer'))}</p>
                    ${isAdmin ? `<button type="button" data-del="${esc(id)}" class="al-btn al-btn--danger al-btn--sm lang-str" data-so="سڕینەوە" data-ba="سڕینەوە">سڕینەوە</button>` : ''}
                </div>
            </details>`).join('');
        box.querySelectorAll('[data-del]').forEach(b => b.addEventListener('click', async () => {
            if (confirm('دڵنیایت لە سڕینەوە؟') && db) await remove(dbRef(db, 'academic_guide/' + b.dataset.del));
        }));
    }

    function applyLanguage() {
        const lt = document.getElementById('lang-text');
        if (lt) lt.textContent = currentLang === 'so' ? 'بادینی' : 'سۆرانی';
        document.querySelectorAll('.lang-str').forEach(el => { el.textContent = el.getAttribute('data-' + currentLang) || el.getAttribute('data-so'); });
        renderGuide();
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
        onValue(dbRef(fdb, 'academic_guide'), (s) => { guideData = s.val() || {}; renderGuide(); });
    }
    window.KaiPageReady(function () {
        if (db) subscribe(db);
        else if (KaiF.whenReady) KaiF.whenReady(function (S) { if (S && S.db) { db = S.db; subscribe(db); } });
    });

    document.getElementById('al-add-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!db) return;
        await set(push(dbRef(db, 'academic_guide')), {
            question_so: document.getElementById('guide_question_so').value,
            question_ba: document.getElementById('guide_question_ba').value,
            answer_so: document.getElementById('guide_answer_so').value,
            answer_ba: document.getElementById('guide_answer_ba').value
        });
        document.getElementById('al-add-form').reset();
        closeModal('al-add-modal');
    });

    applyLanguage();
</script>
</body>
</html>

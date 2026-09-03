<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    @include('partials.alpha-head')
    <title>ALPHA AI — @yield('title')</title>
</head>
<body class="al-body">

@include('partials.alpha-nav', ['active' => 'profile'])

<script type="application/json" id="kurdai-firebase-config">{!! json_encode(config('kurdai.firebase'), 15) !!}</script>
<script src="/js/kai-firebase.js?v=1" data-kai-shared defer></script>

<main class="al-container al-section">
    <header style="margin-bottom: 26px">
        <h1 style="font-size: 1.7rem" class="lang-str" data-so="هەژمارەکەم" data-ba="هەژمارا من">هەژمارەکەم</h1>
    </header>

    <div class="al-grid" style="grid-template-columns:repeat(auto-fill,minmax(320px,1fr))">
        <div class="al-card al-card--pad">
            <h3 class="lang-str" style="margin-bottom:16px" data-so="زانیاری هەژمار" data-ba="زانیاری هەژمار">زانیاری هەژمار</h3>
            <div style="display:grid;gap:12px">
                <div class="al-flex al-flex--between"><span class="al-tag">Email</span><strong id="al-p-email" dir="ltr">—</strong></div>
                <div class="al-flex al-flex--between"><span class="al-tag lang-str" data-so="UID" data-ba="UID">UID</span><strong id="al-p-uid" dir="ltr" style="font-size:0.72rem">—</strong></div>
                <div class="al-flex al-flex--between"><span class="al-tag lang-str" data-so="ڕۆڵ" data-ba="ڕۆڵ">ڕۆڵ</span><strong id="al-p-role">—</strong></div>
            </div>
        </div>

        <div class="al-card al-card--pad">
            <h3 class="lang-str" style="margin-bottom:16px" data-so="پێشکەوتنی فێرگە" data-ba="پێشڤەچوونا فێرگێ">پێشکەوتنی فێرگە</h3>
            <div id="al-ferga-progress" class="al-empty" style="padding:20px">
                <span class="lang-str" data-so="هێشتا داتایەک نییە" data-ba="هێشتا داتایەک نین">هێشتا داتایەک نییە</span>
            </div>
        </div>

        <div class="al-card al-card--pad">
            <h3 class="lang-str" style="margin-bottom:16px" data-so="خەڵاتەکان" data-ba="خەلات">خەڵاتەکان</h3>
            <div id="al-ferga-badges" style="display:flex;gap:8px;flex-wrap:wrap"></div>
        </div>
    </div>
</main>

@include('partials.alpha-foot')

<script type="module">
    import { getDatabase, ref, onValue } from "/js/firebase10/firebase-database.js";

    const KaiF = window.KaiFirebase || {};
    let currentLang = localStorage.getItem('site-lang') || 'so';
    if (window.KaiTrack) window.KaiTrack.visit('profile');

    const ADMIN_EMAILS = ["team@alpha-ai.com", "alphaaiteam@gmail.com"];

    function esc(s) { return String(s == null ? '' : s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }

    function whenUser(cb) {
        if (KaiF.whenReady) KaiF.whenReady(function (st) { cb(st && st.user ? st.user : null); });
        else if (KaiF.onAuthStateChanged) KaiF.onAuthStateChanged(cb);
    }

    whenUser(function (user) {
        if (!user) return;
        document.getElementById('al-p-email').textContent = user.email || '—';
        document.getElementById('al-p-uid').textContent = user.uid || '—';
        const isAdmin = ADMIN_EMAILS.includes(String(user.email || '').toLowerCase());
        document.getElementById('al-p-role').textContent = isAdmin
            ? (currentLang === 'so' ? 'ئەدمین' : 'ئەدمین')
            : (currentLang === 'so' ? 'ئەندام' : 'ئەندام');

        const app = KaiF.app ? KaiF.app() : null;
        const db = app ? getDatabase(app) : null;
        if (!db) return;

        onValue(ref(db, 'users/' + user.uid + '/ferga_progress'), (snap) => {
            const val = snap.val();
            const box = document.getElementById('al-ferga-progress');
            if (!val) return;
            const langs = Object.keys(val);
            box.classList.remove('al-empty');
            box.style.padding = '';
            box.innerHTML = langs.map(l => {
                const lessons = val[l] || {};
                const done = Object.values(lessons).filter(v => v && (v.completed || v.done)).length;
                const total = Object.keys(lessons).length;
                const pct = total ? Math.round((done / total) * 100) : 0;
                return `
                <div style="margin-bottom:14px">
                    <div class="al-flex al-flex--between" style="margin-bottom:6px">
                        <strong style="font-size:0.85rem">${esc(l)}</strong>
                        <span style="font-size:0.8rem;color:var(--al-muted)">${done}/${total} — ${pct}%</span>
                    </div>
                    <div style="height:6px;border-radius:3px;background:var(--al-line);overflow:hidden">
                        <div style="height:100%;width:${pct}%;background:var(--al-accent);border-radius:3px"></div>
                    </div>
                </div>`;
            }).join('');
        });

        onValue(ref(db, 'users/' + user.uid + '/ferga_badges'), (snap) => {
            const badges = snap.val();
            const box = document.getElementById('al-ferga-badges');
            if (!badges) return;
            const list = Array.isArray(badges) ? badges : Object.values(badges);
            box.innerHTML = list.map(b => `<span class="al-tag al-tag--accent">🏅 ${esc(typeof b === 'string' ? b : (b.name || 'badge'))}</span>`).join('');
        });
    });

    function applyLanguage() {
        const lt = document.getElementById('lang-text');
        if (lt) lt.textContent = currentLang === 'so' ? 'بادینی' : 'سۆرانی';
        document.querySelectorAll('.lang-str').forEach(el => { el.textContent = el.getAttribute('data-' + currentLang) || el.getAttribute('data-so'); });
    }
    document.getElementById('lang-toggle').addEventListener('click', () => {
        currentLang = currentLang === 'so' ? 'ba' : 'so';
        localStorage.setItem('site-lang', currentLang);
        applyLanguage();
    });
    applyLanguage();
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="ckb" dir="rtl" class="dark">
<head>
    @include('partials.a1-head')
    <title>ALPHA AI — @yield('title')</title>
</head>
<body class="a1">

@include('partials.a1-rail', ['active' => 'profile'])


<div class="a1-main">
    <div class="a1-page">

        <div class="a1-strip"><span class="a1-strip__dot"></span><span class="a1-strip__crumb">ALPHA / ACCOUNT</span></div>

        <div class="a1-section-head">
            <h2 class="lang-str" data-so="هەژمارەکەم" data-ba="هەژمارا من">هەژمارەکەم</h2>
            <span class="a1-index">ID</span>
        </div>

        <div class="a1-stack">
            <div style="border:1px solid var(--a1-line);padding:22px 24px">
                <h3 style="font-size:0.95rem;margin-bottom:16px" class="lang-str" data-so="زانیاری هەژمار" data-ba="زانیاری هەژمار">زانیاری هەژمار</h3>
                <div class="a1-stack" style="gap:10px">
                    <div class="a1-hrow"><span class="a1-tag">EMAIL</span><strong id="a1-p-email" dir="ltr" style="font-size:0.9rem">—</strong></div>
                    <div class="a1-hrow"><span class="a1-tag">UID</span><strong id="a1-p-uid" dir="ltr" style="font-family:var(--a1-mono);font-size:0.7rem">—</strong></div>
                    <div class="a1-hrow"><span class="a1-tag lang-str" data-so="ڕۆڵ" data-ba="ڕۆڵ">ڕۆڵ</span><strong id="a1-p-role">—</strong></div>
                </div>
            </div>

            <div style="border:1px solid var(--a1-line);padding:22px 24px">
                <h3 style="font-size:0.95rem;margin-bottom:16px" class="lang-str" data-so="پێشکەوتنی فێرگە" data-ba="پێشڤەچوونا فێرگێ">پێشکەوتنی فێرگە</h3>
                <div id="a1-ferga-progress" class="a1-empty">—</div>
            </div>

            <div style="border:1px solid var(--a1-line);padding:22px 24px">
                <h3 style="font-size:0.95rem;margin-bottom:16px" class="lang-str" data-so="خەڵاتەکان" data-ba="خەلات">خەڵاتەکان</h3>
                <div id="a1-ferga-badges" style="display:flex;gap:8px;flex-wrap:wrap"></div>
            </div>
        </div>

        @include('partials.a1-foot')
    </div>
</div>

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
        document.getElementById('a1-p-email').textContent = user.email || '—';
        document.getElementById('a1-p-uid').textContent = user.uid || '—';
        const isAdmin = ADMIN_EMAILS.includes(String(user.email || '').toLowerCase());
        document.getElementById('a1-p-role').textContent = isAdmin ? 'ADMIN' : 'MEMBER';

        const app = KaiF.app ? KaiF.app() : null;
        const db = app ? getDatabase(app) : null;
        if (!db) return;

        onValue(ref(db, 'users/' + user.uid + '/ferga_progress'), (snap) => {
            const val = snap.val();
            if (!val) return;
            const box = document.getElementById('a1-ferga-progress');
            box.classList.remove('a1-empty');
            box.style.padding = '0'; box.style.border = 'none';
            box.innerHTML = Object.keys(val).map(l => {
                const lessons = val[l] || {};
                const done = Object.values(lessons).filter(v => v && (v.completed || v.done)).length;
                const total = Object.keys(lessons).length;
                const pct = total ? Math.round((done / total) * 100) : 0;
                return `
                <div style="margin-bottom:16px">
                    <div class="a1-hrow" style="margin-bottom:8px">
                        <strong style="font-size:0.85rem;font-family:var(--a1-mono)">${esc(l)}</strong>
                        <span style="font-family:var(--a1-mono);font-size:0.72rem;color:var(--a1-dim)">${done}/${total} · ${pct}%</span>
                    </div>
                    <div style="height:4px;background:var(--a1-line)">
                        <div style="height:100%;width:${pct}%;background:var(--a1-accent)"></div>
                    </div>
                </div>`;
            }).join('');
        });

        onValue(ref(db, 'users/' + user.uid + '/ferga_badges'), (snap) => {
            const badges = snap.val();
            if (!badges) return;
            const list = Array.isArray(badges) ? badges : Object.values(badges);
            document.getElementById('a1-ferga-badges').innerHTML = list.map(b =>
                `<span class="a1-tag a1-tag--accent">★ ${esc(typeof b === 'string' ? b : (b.name || 'BADGE'))}</span>`).join('');
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

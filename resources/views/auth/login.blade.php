<!DOCTYPE html>
<html lang="ckb" dir="rtl" class="dark">
<head>
    @include('partials.a1-head')
    <title>ALPHA AI — LOGIN</title>
</head>
<body class="a1" style="display:flex;align-items:center;justify-content:center;min-height:100vh">


<main style="width:100%;max-width:360px;padding:20px">
    <div style="text-align:center;margin-bottom:30px">
        <img src="{{ asset('mark-a1.svg') }}" width="48" height="48" alt="ALPHA AI" style="margin-bottom:16px">
        <div class="a1-strip" style="justify-content:center;border:none;padding:0;margin-bottom:8px">
            <span class="a1-strip__dot"></span><span>ALPHA / AUTH</span>
        </div>
        <h1 class="a1-display" style="font-size:1.9rem">ALPHA<span style="color:var(--a1-accent)">.</span></h1>
    </div>

    <div id="login-error" hidden class="a1-note" style="margin-bottom:16px;border-color:var(--a1-danger);color:var(--a1-danger)"></div>
    <div id="login-ok" hidden class="a1-note" style="margin-bottom:16px"></div>

    <form id="a1-login-form">
        <label class="a1-field"><span class="a1-field__label">EMAIL</span>
            <input type="email" id="login-email" required dir="ltr" class="a1-input" placeholder="you@example.com" autocomplete="email"></label>
        <label class="a1-field"><span class="a1-field__label lang-str" data-so="وشەی نهێنی" data-ba="کەلیمەیا نهێن">وشەی نهێنی</span>
            <input type="password" id="login-password" required dir="ltr" class="a1-input" placeholder="••••••" autocomplete="current-password"></label>
        <button type="submit" id="login-send-btn" class="a1-btn a1-btn--accent" style="width:100%">
            <span class="lang-str" data-so="چوونەژوورەوە" data-ba="چوونە ژوورە">چوونەژوورەوە</span></button>
    </form>

    <p style="text-align:center;margin-top:22px;font-family:var(--a1-mono);font-size:0.7rem;letter-spacing:0.15em">
        <a href="/" style="color:var(--a1-faint)">← <span class="lang-str" data-so="گەڕانەوە" data-ba="گەڕانەوە">گەڕانەوە</span></a>
    </p>
</main>

<script type="module">
    import { getAuth, signInWithEmailAndPassword, onAuthStateChanged } from "/js/firebase10/firebase-auth.js";

    const KaiF = window.KaiFirebase || {};
    let auth = null;
    let submitting = false, navigated = false;

    /* lang sweep on this minimal page */
    (function () {
        let cl = localStorage.getItem('site-lang') || 'so';
        document.querySelectorAll('.lang-str').forEach(el => { el.textContent = el.getAttribute('data-' + cl) || el.getAttribute('data-so'); });
    })();

    function returnPath() {
        const value = new URLSearchParams(location.search).get('return') || '/';
        return value.startsWith('/') && !value.startsWith('//') && value !== '/login' ? value : '/';
    }
    function ensureAuth() {
        return new Promise((resolve) => {
            if (auth) return resolve(auth);
            if (KaiF.auth) return resolve(KaiF.auth());
            KaiF.whenReady(function (st) { resolve(st && st.auth); });
        });
    }
    function showError(text) { const e = document.getElementById('login-error'); e.textContent = text; e.hidden = false; document.getElementById('login-ok').hidden = true; }
    function showOk(text) { const e = document.getElementById('login-ok'); e.textContent = text; e.hidden = false; document.getElementById('login-error').hidden = true; }

    function loginDone() {
        if (navigated) return;
        navigated = true;
        try { localStorage.setItem('kurdai-authenticated', '1'); } catch (e) {}
        showOk('OK — ...');
        setTimeout(() => { location.replace(returnPath()); }, 350);
    }

    (function watchAuth() {
        if (KaiF.onAuthStateChanged) {
            KaiF.onAuthStateChanged(function (user) {
                if (user && !submitting && !navigated) {
                    try { localStorage.setItem('kurdai-authenticated', '1'); } catch (e) {}
                    location.replace(returnPath());
                }
            });
            return;
        }
        ensureAuth().then(function (a) { if (a) onAuthStateChanged(a, function (user) {
            if (user && !submitting && !navigated) {
                try { localStorage.setItem('kurdai-authenticated', '1'); } catch (e) {}
                location.replace(returnPath());
            }
        }); });
    })();

    document.getElementById('a1-login-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const email = document.getElementById('login-email').value.trim();
        const password = document.getElementById('login-password').value;
        document.getElementById('login-error').hidden = true;
        document.getElementById('login-ok').hidden = true;
        if (!email) return;
        if (password.length < 6) { showError('وشەی نهێنی کەمتر لە 6 پیتە.'); return; }
        submitting = true;
        const btn = document.getElementById('login-send-btn');
        btn.disabled = true;
        try {
            const a = await ensureAuth();
            if (!a) { showError('فایەربەیس ئامادە نییە — چەند چرکەیەک چاوەڕێ بکە.'); return; }
            await signInWithEmailAndPassword(a, email, password);
            try { if (window.KaiTrack) window.KaiTrack.login(email); } catch (err) {}
            loginDone();
        } catch (err) {
            if (err.code === 'auth/user-not-found') showError('ئەم ئیمێڵە تۆمار نەکراوە.');
            else if (err.code === 'auth/invalid-credential' || err.code === 'auth/wrong-password') showError('ئیمێڵ یان وشەی نهێنی هەڵەیە.');
            else if (err.code === 'auth/too-many-requests') showError('هەوڵەکان زۆر بوون.');
            else showError('هەڵە: ' + (err.code || ''));
        } finally {
            submitting = false; btn.disabled = false;
        }
    });
</script>
</body>
</html>

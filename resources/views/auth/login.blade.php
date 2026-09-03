<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    @include('partials.alpha-head')
    <title>ALPHA AI — چوونەژوورەوە</title>
</head>
<body class="al-body" style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px">

<script type="application/json" id="kurdai-firebase-config">{!! json_encode(config('kurdai.firebase'), 15) !!}</script>
<script src="/js/kai-firebase.js?v=1" data-kai-shared defer></script>

<main class="al-card al-card--pad" style="width:100%;max-width:400px">
    <div style="text-align:center;margin-bottom:24px">
        <img src="{{ asset('logo-alpha.svg') }}" width="52" height="52" alt="ALPHA AI" style="margin-bottom:12px">
        <h1 style="font-size:1.4rem">ALPHA AI</h1>
        <p class="lang-str" style="color:var(--al-muted);font-size:0.88rem" data-so="چوونەژوورەوە بۆ هەژمارەکەت" data-ba="چوونە ژوورە بۆ هەژمارا تە">چوونەژوورەوە بۆ هەژمارەکەت</p>
    </div>

    <div id="login-error" hidden class="al-note" style="background:#fef2f2;color:#dc2626;margin-bottom:16px"></div>
    <div id="login-ok" hidden class="al-note" style="margin-bottom:16px"></div>

    <form id="al-login-form">
        <label class="al-field"><span class="al-field__label">Email</span>
            <input type="email" id="login-email" required dir="ltr" class="al-input" placeholder="you@example.com" autocomplete="email"></label>
        <label class="al-field"><span class="al-field__label lang-str" data-so="وشەی نهێنی" data-ba="کەلیمەیا نهێن">وشەی نهێنی</span>
            <input type="password" id="login-password" required dir="ltr" class="al-input" placeholder="••••••" autocomplete="current-password"></label>
        <button type="submit" id="login-send-btn" class="al-btn al-btn--solid" style="width:100%">
            <span class="lang-str" data-so="چوونەژوورەوە" data-ba="چوونە ژوورە">چوونەژوورەوە</span></button>
    </form>

    <div style="text-align:center;margin-top:16px">
        <a href="/" style="color:var(--al-accent);font-size:0.85rem;font-weight:700;text-decoration:none">← <span class="lang-str" data-so="گەڕانەوە بۆ ماڵپەر" data-ba="گەڕانەوە بۆ ماڵپەر">گەڕانەوە بۆ ماڵپەر</span></a>
    </div>
</main>

<script type="module">
    import { getAuth, signInWithEmailAndPassword, onAuthStateChanged } from "/js/firebase10/firebase-auth.js";

    const KaiF = window.KaiFirebase || {};
    let auth = null;
    let submitting = false, navigated = false;

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
    function showSuccess(text) { const e = document.getElementById('login-ok'); e.textContent = text; e.hidden = false; document.getElementById('login-error').hidden = true; }
    function emailPasswordError(e) {
        if (e.code === 'auth/invalid-credential' || e.code === 'auth/wrong-password') return 'ئیمێڵ یان وشەی نهێنی هەڵەیە.';
        if (e.code === 'auth/too-many-requests') return 'هەوڵەکان زۆر بوون — دواتر هەوڵ بدەرەوە.';
        if (e.code === 'auth/network-request-failed') return 'پەیوەندی بە ئینتەرنێتەوە نەکرا.';
        return 'هەڵەیەک ڕوویدا: ' + (e.code || '');
    }

    function loginDone() {
        if (navigated) return;
        navigated = true;
        try { localStorage.setItem('kurdai-authenticated', '1'); } catch (e) {}
        showSuccess('سەرکەوتوو بوو...');
        setTimeout(() => { location.replace(returnPath()); }, 350);
    }

    onAuthStateChangedWrapper(function (user) {
        if (user && !submitting && !navigated) {
            try { localStorage.setItem('kurdai-authenticated', '1'); } catch (e) {}
            location.replace(returnPath());
        }
    });
    function onAuthStateChangedWrapper(cb) {
        if (KaiF.onAuthStateChanged) { KaiF.onAuthStateChanged(cb); return; }
        ensureAuth().then(function (a) { if (a) onAuthStateChanged(a, cb); });
    }

    document.getElementById('al-login-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const email = document.getElementById('login-email').value.trim();
        const password = document.getElementById('login-password').value;
        document.getElementById('login-error').hidden = true;
        document.getElementById('login-ok').hidden = true;
        if (!email) return;
        if (password.length < 6) { showError('وشەی نهێنی کەمتر لە 6 پیتە.'); return; }
        submitting = true;
        const btn = document.getElementById('login-send-btn');
        btn.disabled = true; btn.style.opacity = .6;
        try {
            const a = await ensureAuth();
            if (!a) { showError('پەیوەندی بە فایەربەیسەوە نەبەستراوە — چەند چرکەیەک چاوەڕێ بکە.'); return; }
            await signInWithEmailAndPassword(a, email, password);
            try { if (window.KaiTrack) window.KaiTrack.login(email); } catch (err) {}
            loginDone();
        } catch (err) {
            if (err.code === 'auth/user-not-found') showError('ئەم ئیمێڵە تۆمار نەکراوە.');
            else showError(emailPasswordError(err));
        } finally {
            submitting = false; btn.disabled = false; btn.style.opacity = 1;
        }
    });
</script>
</body>
</html>

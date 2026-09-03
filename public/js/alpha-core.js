/* ==========================================================================
   ALPHA AI — alpha-core · v1
   New chrome, same plumbing. Provides:
     • KaiPageReady(fn)                     — page boot helper
     • window.AlphaGuard                    — auth gate (replaces kurdai-design guard)
     • capture-level lang/theme/logout ctl — ids: lang-toggle, theme-toggle, logout-btn
     • .lang-str sweep + kai:langchange     — same events as before
     • KaiTrack beacon                      — /api/analytics/visit (same endpoint)
     • Firebase config tags are rendered by the page; KaiF loads via kai-firebase.js
   ========================================================================== */
(function () {
    'use strict';

    /* ---------- KaiPageReady ---------- */
    window.KaiPageReady = function (fn) {
        if (typeof fn !== 'function') return;
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fn, { once: true });
        } else { fn(); }
    };

    /* ---------- auth guard ---------- */
    document.documentElement.classList.add('al-auth-pending');
    (function guard() {
        function release() { document.documentElement.classList.remove('al-auth-pending'); }
        function returnPath() { return location.pathname + (location.search || '') + (location.hash || ''); }
        if (!document.querySelector('.al-nav[data-al-auth-required]')) { release(); return; }
        var remembered = false;
        try { remembered = localStorage.getItem('kurdai-authenticated') === '1'; } catch (e) {}
        if (!remembered) { location.replace('/login?return=' + encodeURIComponent(returnPath())); return; }
        var fb = window.KaiFirebase;
        if (!fb || typeof fb.whenReady !== 'function') { setTimeout(guard, 50); return; }
        fb.whenReady(function (state) {
            if (state && state.user) { release(); return; }
            try { localStorage.removeItem('kurdai-authenticated'); } catch (e) {}
            location.replace('/login?return=' + encodeURIComponent(returnPath()));
        });
    })();

    /* ---------- KaiTrack beacon (same /api/analytics/visit contract) ---------- */
    (function () {
        var identity = { uid: '', email: '' };
        function send(payload) {
            try {
                if (navigator.sendBeacon) {
                    navigator.sendBeacon('/api/analytics/visit', new Blob([JSON.stringify(payload)], { type: 'application/json' }));
                } else {
                    fetch('/api/analytics/visit', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload), keepalive: true }).catch(function () {});
                }
            } catch (e) {}
        }
        function userKey() {
            var k = localStorage.getItem('kurdai_user_key');
            if (!k) { k = 'u' + Math.random().toString(36).slice(2, 10) + Date.now().toString(36); try { localStorage.setItem('kurdai_user_key', k); } catch (e) {} }
            return k;
        }
        window.KaiTrack = {
            setIdentity: function (uid, email) { identity.uid = uid || ''; identity.email = String(email || '').toLowerCase(); },
            visit: function (section) {
                try {
                    var now = Date.now();
                    var last = sessionStorage.getItem('ka_v_' + section);
                    if (last && now - Number(last) < 15000) return;
                    sessionStorage.setItem('ka_v_' + section, String(now));
                    send({ type: 'visit', section: section, user_key: userKey(), uid: identity.uid, email: identity.email });
                } catch (e) {}
            },
            login: function (email) {
                try { window.KaiTrack.setIdentity('', email); send({ type: 'login', section: 'auth', user_key: userKey(), uid: '', email: String(email || '').toLowerCase() }); } catch (e) {}
            }
        };
        document.addEventListener('kurdai:identity', function (e) { window.KaiTrack.setIdentity('', e.detail && e.detail.email); });
    })();

    /* ---------- lang / theme / logout / burger ---------- */
    document.addEventListener('click', function (e) {
        var t = e.target && e.target.closest ? e.target.closest('#lang-toggle, #theme-toggle, #logout-btn, #al-burger') : null;
        if (!t) return;

        if (t.id === 'lang-toggle') {
            e.preventDefault(); e.stopImmediatePropagation();
            var lang = localStorage.getItem('site-lang') || 'so';
            lang = lang === 'so' ? 'ba' : 'so';
            localStorage.setItem('site-lang', lang);
            var lt = document.getElementById('lang-text');
            if (lt) lt.textContent = lang === 'so' ? 'بادینی' : 'سۆرانی';
            document.querySelectorAll('.lang-str').forEach(function (el) {
                el.textContent = el.getAttribute('data-' + lang) || el.getAttribute('data-so') || '';
            });
            try { window.dispatchEvent(new CustomEvent('kai:langchange', { detail: { lang: lang } })); } catch (ignore) {}
            return;
        }

        if (t.id === 'theme-toggle') {
            e.preventDefault(); e.stopImmediatePropagation();
            var dark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('color-theme', dark ? 'dark' : 'light');
            var ico = document.getElementById('al-theme-ico');
            if (ico) ico.textContent = dark ? '☀' : '☾';
            return;
        }

        if (t.id === 'logout-btn') {
            e.preventDefault(); e.stopImmediatePropagation();
            try { localStorage.removeItem('kurdai-authenticated'); } catch (err) {}
            var fbq = window.KaiFirebase;
            var done = function () { window.location.href = '/login'; };
            if (fbq && typeof fbq.signOut === 'function') { fbq.signOut().then(done, done); } else { done(); }
            return;
        }

        if (t.id === 'al-burger') {
            e.preventDefault();
            var links = document.getElementById('al-navlinks');
            if (links) links.classList.toggle('is-open');
            return;
        }
    }, true);

    /* burger visibility on small screens */
    function syncBurger() {
        var b = document.getElementById('al-burger');
        if (!b) return;
        b.style.display = window.innerWidth <= 640 ? 'inline-flex' : 'none';
        var links = document.getElementById('al-navlinks');
        if (links && window.innerWidth > 640) links.classList.remove('is-open');
    }
    window.addEventListener('resize', syncBurger);
    KaiPageReady(function () {
        syncBurger();
        var ico = document.getElementById('al-theme-ico');
        if (ico) ico.textContent = document.documentElement.classList.contains('dark') ? '☀' : '☾';
        var lt = document.getElementById('lang-text');
        var cl = localStorage.getItem('site-lang') || 'so';
        if (lt) lt.textContent = cl === 'so' ? 'بادینی' : 'سۆرانی';
        document.querySelectorAll('.lang-str').forEach(function (el) {
            el.textContent = el.getAttribute('data-' + cl) || el.getAttribute('data-so') || '';
        });
    });
})();

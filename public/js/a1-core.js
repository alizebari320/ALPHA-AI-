/* ALPHA AI — a1-core · side-rail chrome
   Same plumbing as always: KaiPageReady, KaiTrack beacon, .lang-str sweep,
   kai:langchange, kurdai-authenticated guard, KaiF. New: rail open/close. */
(function () {
    'use strict';

    window.KaiPageReady = function (fn) {
        if (typeof fn !== 'function') return;
        if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', fn, { once: true }); }
        else { fn(); }
    };

    /* ---------- rail toggle ---------- */
    function bindRail() {
        var rail = document.getElementById('a1-rail');
        var btn = document.getElementById('a1-rail-toggle');
        if (rail && btn) {
            btn.addEventListener('click', function () { rail.classList.toggle('is-open'); });
            document.addEventListener('click', function (e) {
                if (rail.classList.contains('is-open') && !rail.contains(e.target)) rail.classList.remove('is-open');
            });
            document.addEventListener('keydown', function (e) { if (e.key === 'Escape') rail.classList.remove('is-open'); });
        }
    }

    /* ---------- auth guard ---------- */
    function runGuard() {
        var cover = document.getElementById('a1-auth-cover');
        function hideCover() { if (cover) cover.hidden = true; }
        function showCover() { if (cover) cover.hidden = false; }
        if (!document.querySelector('.a1-rail[data-a1-auth-required]')) { hideCover(); return; }

        var remembered = false;
        try { remembered = localStorage.getItem('kurdai-authenticated') === '1'; } catch (e) {}
        if (!remembered) {
            location.replace('/login?return=' + encodeURIComponent(location.pathname + (location.search || '')));
            return;
        }
        showCover();
        var fb = window.KaiFirebase;
        if (!fb || typeof fb.whenReady !== 'function') { setTimeout(runGuard, 50); return; }
        fb.whenReady(function (state) {
            if (state && state.user) { hideCover(); return; }
            try { localStorage.removeItem('kurdai-authenticated'); } catch (e) {}
            location.replace('/login?return=' + encodeURIComponent(location.pathname + (location.search || '')));
        });
    }

    /* ---------- analytics beacon (same endpoint) ---------- */
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

    /* ---------- controls (capture-level) ---------- */
    document.addEventListener('click', function (e) {
        var t = e.target && e.target.closest ? e.target.closest('#lang-toggle, #theme-toggle, #logout-btn') : null;
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
            var light = document.documentElement.classList.toggle('dark') === false;
            localStorage.setItem('color-theme', light ? 'light' : 'dark');
            var ico = document.getElementById('a1-theme-ico');
            if (ico) ico.textContent = light ? '☀' : '☾';
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
    }, true);

    /* ---------- toast helper ---------- */
    window.A1Toast = function (text, ms) {
        try {
            var old = document.querySelector('.a1-toast');
            if (old) old.remove();
            var t = document.createElement('div');
            t.className = 'a1-toast';
            t.textContent = String(text || '');
            document.body.appendChild(t);
            setTimeout(function () {
                t.classList.add('is-out');
                setTimeout(function () { t.remove(); }, 260);
            }, ms || 2600);
        } catch (e) {}
    };

    /* ---------- avatar + greeting ---------- */
    function initialsOf(email) {
        var name = String(email || '').split('@')[0] || '؟';
        var parts = name.replace(/[._-]+/g, ' ').trim().split(/\s+/);
        if (parts.length >= 2) return (parts[0][0] + parts[1][0]).toUpperCase();
        return name.slice(0, 2).toUpperCase();
    }
    function paintUser(email) {
        var av = document.getElementById('a1-avatar');
        var nm = document.getElementById('a1-user-name');
        if (!email) return;
        if (av) av.textContent = initialsOf(email);
        if (nm) nm.textContent = String(email).split('@')[0];
    }
    document.addEventListener('kurdai:identity', function (e) { paintUser(e.detail && e.detail.email); });
    (function pollIdentity() {
        var fb = window.KaiFirebase;
        if (!fb || typeof fb.whenReady !== 'function') { setTimeout(pollIdentity, 80); return; }
        fb.whenReady(function (st) { if (st && st.user) paintUser(st.user.email); });
    })();

    /* ---------- scroll progress + back-to-top ---------- */
    function bindScrollExtras() {
        var bar = document.querySelector('.a1-progress i');
        var fab = document.createElement('button');
        fab.type = 'button';
        fab.className = 'a1-fab';
        fab.setAttribute('aria-label', 'top');
        fab.innerHTML = '↑';
        document.body.appendChild(fab);
        fab.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: 'smooth' }); });
        window.addEventListener('scroll', function () {
            var max = document.documentElement.scrollHeight - window.innerHeight;
            var pct = max > 0 ? (window.scrollY / max) * 100 : 0;
            if (bar) bar.style.width = pct.toFixed(1) + '%';
            fab.classList.toggle('is-show', window.scrollY > 420);
        }, { passive: true });
    }

    KaiPageReady(function () {
        bindRail();
        runGuard();
        bindScrollExtras();
        var ico = document.getElementById('a1-theme-ico');
        if (ico) ico.textContent = document.documentElement.classList.contains('dark') ? '☾' : '☀';
        var lt = document.getElementById('lang-text');
        var cl = localStorage.getItem('site-lang') || 'so';
        if (lt) lt.textContent = cl === 'so' ? 'بادینی' : 'سۆرانی';
        document.querySelectorAll('.lang-str').forEach(function (el) {
            el.textContent = el.getAttribute('data-' + cl) || el.getAttribute('data-so') || '';
        });
    });
})();

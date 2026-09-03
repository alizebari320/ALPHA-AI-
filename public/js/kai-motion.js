/* ==========================================================================
   KURD AI — kai-motion.js · "AURORA PRO" interaction engine (additive — v1)
   --------------------------------------------------------------------------
   Loaded once per session (data-kai-shared). Purely presentational:
     • injects the aurora mesh background (#kai-aurora-bg)
     • scroll-entrance reveals (IntersectionObserver, auto-tagged)
     • cursor spotlight on glass cards (--mx/--my CSS vars)
     • ripple effect on gradient buttons + .kbtn
     • toast system (window.KaiToast.show)
     • animated number counters ([data-kai-count])
   Never touches page logic, data, or routing. Re-scans after SPA swaps
   (page:swapped) and throttled DOM mutations.
   ========================================================================== */
(function () {
    'use strict';
    if (window.__kaiMotionActive) return;
    window.__kaiMotionActive = true;

    var REDUCED = false;
    try { REDUCED = window.matchMedia('(prefers-reduced-motion: reduce)').matches; } catch (e) {}

    /* ================= 1. AURORA MESH BACKGROUND ================= */
    function injectAurora() {
        if (document.getElementById('kai-aurora-bg')) return;
        var wrap = document.createElement('div');
        wrap.id = 'kai-aurora-bg';
        wrap.setAttribute('aria-hidden', 'true');
        wrap.innerHTML =
            '<div class="kai-orb kai-orb--1"></div>' +
            '<div class="kai-orb kai-orb--2"></div>' +
            '<div class="kai-orb kai-orb--3"></div>' +
            '<div class="kai-orb kai-orb--4"></div>' +
            '<div class="kai-grid"></div>' +
            (REDUCED ? '' : '<div class="kai-grain"></div>');
        document.body.insertBefore(wrap, document.body.firstChild);
    }

    /* ================= 2. SCROLL REVEALS ================= */
    var revealObserver = null;
    var revealSeq = 0;

    function initObserver() {
        if (revealObserver || REDUCED) return;
        if (!('IntersectionObserver' in window)) return;
        revealObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('kai-in');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });
    }

    function inSkippableContainer(el) {
        return !!(el.closest && el.closest('[aria-modal="true"], .fixed, #ka-drawer, #kai-hero'));
    }

    function tagReveals(root) {
        if (REDUCED) return;
        initObserver();
        if (!revealObserver) return;
        var targets = (root || document).querySelectorAll(
            'section .glass-card, section .service-card, .kai-reveal'
        );
        targets.forEach(function (el) {
            if (el.classList.contains('kai-reveal')) {
                revealObserver.observe(el);
                return;
            }
            if (inSkippableContainer(el)) return;
            if (el.closest('.kai-skip-reveal')) return;
            el.classList.add('kai-reveal');
            el.style.setProperty('--kai-d', ((revealSeq++ % 8) * 70) + 'ms');
            revealObserver.observe(el);
        });
    }

    /* ================= 3. CARD SPOTLIGHT ================= */
    var spotRaf = null;
    var spotTargets = [];

    function collectSpotlight(root) {
        spotTargets = Array.prototype.slice.call(
            (root || document).querySelectorAll('.glass-card, .service-card, .kai-cat')
        ).filter(function (el) { return !inSkippableContainer(el); });
    }

    function onSpotMove(e) {
        if (spotRaf) return;
        spotRaf = requestAnimationFrame(function () {
            spotRaf = null;
            for (var i = 0; i < spotTargets.length; i++) {
                var el = spotTargets[i];
                var r = el.getBoundingClientRect();
                var near = !(e.clientY < r.top - 80 || e.clientY > r.bottom + 80 || e.clientX < r.left - 80 || e.clientX > r.right + 80);
                if (!near) {
                    /* reset tilt when the cursor leaves a card's orbit */
                    if (el.__kaiTilted) {
                        el.style.setProperty('--rx', '0deg');
                        el.style.setProperty('--ry', '0deg');
                        el.__kaiTilted = false;
                    }
                    continue;
                }
                var mx = ((e.clientX - r.left) / r.width * 100) + '%';
                var my = ((e.clientY - r.top) / r.height * 100) + '%';
                /* feed both var systems: ours (--mx/--my) and the base
                   layer's (--kai-mx/--kai-my) so every card lights up. */
                el.style.setProperty('--mx', mx);
                el.style.setProperty('--my', my);
                el.style.setProperty('--kai-mx', mx);
                el.style.setProperty('--kai-my', my);
                /* 3D tilt for .kai-tilt cards (Persian-gulf subtle, max ~6deg) */
                if (el.classList.contains('kai-tilt') && !REDUCED) {
                    var cx = (e.clientX - r.left) / r.width - 0.5;
                    var cy = (e.clientY - r.top) / r.height - 0.5;
                    el.style.setProperty('--ry', (cx * 6).toFixed(2) + 'deg');
                    el.style.setProperty('--rx', (-cy * 6).toFixed(2) + 'deg');
                    el.__kaiTilted = true;
                }
            }
        });
    }

    /* ================= 4. RIPPLE ================= */
    function spawnRipple(el, x, y) {
        if (REDUCED) return;
        var r = el.getBoundingClientRect();
        var size = Math.max(r.width, r.height) * 0.7;
        var span = document.createElement('span');
        span.className = 'kai-ripple';
        span.style.width = span.style.height = size + 'px';
        span.style.left = (x - r.left - size / 2) + 'px';
        span.style.top = (y - r.top - size / 2) + 'px';
        el.appendChild(span);
        setTimeout(function () { span.remove(); }, 700);
    }

    function isRippleTarget(el) {
        if (!el || el === document) return false;
        if (el.classList.contains('kbtn')) return true;
        var cls = el.getAttribute && el.getAttribute('class') || '';
        return /bg-gradient-to-[rb]/.test(cls) && (el.tagName === 'A' || el.tagName === 'BUTTON');
    }

    document.addEventListener('pointerdown', function (e) {
        if (e.button && e.button !== 0) return;
        var el = e.target.closest && e.target.closest('.kbtn, a, button');
        while (el && el !== document.body) {
            if (isRippleTarget(el)) {
                if (getComputedStyle(el).position === 'static') el.style.position = 'relative';
                if (getComputedStyle(el).overflow !== 'hidden') el.style.overflow = 'hidden';
                spawnRipple(el, e.clientX, e.clientY);
                return;
            }
            el = el.parentElement;
        }
    }, { passive: true });

    /* ================= 5. TOAST SYSTEM ================= */
    function toastContainer() {
        var c = document.getElementById('kai-toasts');
        if (!c) {
            c = document.createElement('div');
            c.id = 'kai-toasts';
            c.setAttribute('aria-live', 'polite');
            document.body.appendChild(c);
        }
        return c;
    }

    window.KaiToast = {
        show: function (msg, type, ms) {
            type = type || 'info'; // info | success | error | warning
            ms = ms || 3200;
            var icons = { info: 'ℹ️', success: '✅', error: '⚠️', warning: '🔔' };
            var t = document.createElement('div');
            t.className = 'kai-toast kai-toast--' + type;
            t.setAttribute('role', 'status');
            t.innerHTML =
                '<span class="kai-toast__bar"></span>' +
                '<span>' + (icons[type] || icons.info) + '</span>' +
                '<span class="kai-toast__msg"></span>';
            t.querySelector('.kai-toast__msg').textContent = String(msg);
            var c = toastContainer();
            c.appendChild(t);
            while (c.children.length > 4) c.removeChild(c.firstChild);
            setTimeout(function () {
                t.classList.add('kai-out');
                setTimeout(function () { t.remove(); }, 360);
            }, ms);
        },
        success: function (m, ms) { window.KaiToast.show(m, 'success', ms); },
        error: function (m, ms) { window.KaiToast.show(m, 'error', ms); },
        warning: function (m, ms) { window.KaiToast.show(m, 'warning', ms); },
    };

    /* ================= 6. ANIMATED COUNTERS ================= */
    function animateCount(el) {
        var target = parseFloat(el.getAttribute('data-kai-count'));
        if (isNaN(target)) return;
        var suffix = el.getAttribute('data-kai-count-suffix') || '';
        var dur = 1100;
        var t0 = null;
        function frame(ts) {
            if (!t0) t0 = ts;
            var p = Math.min((ts - t0) / dur, 1);
            var eased = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.round(target * eased).toLocaleString('en') + suffix;
            if (p < 1) requestAnimationFrame(frame);
        }
        requestAnimationFrame(frame);
    }

    function initCounters(root) {
        if (REDUCED) return;
        var els = (root || document).querySelectorAll('[data-kai-count]:not([data-kai-counted])');
        if (!els.length || !('IntersectionObserver' in window)) return;
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.setAttribute('data-kai-counted', '1');
                    animateCount(entry.target);
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.4 });
        els.forEach(function (el) { io.observe(el); });
    }

    /* ================= BOOT + RESCAN ================= */
    function rescan() {
        injectAurora();
        tagReveals();
        collectSpotlight();
        initCounters();
    }

    function boot() {
        rescan();
        if (!REDUCED) {
            window.addEventListener('pointermove', onSpotMove, { passive: true });
        }
        /* SPA swaps re-inject page content — rescan after each swap. */
        document.addEventListener('page:swapped', rescan);
        /* throttled MutationObserver for dynamic cards (rendered lists) */
        if ('MutationObserver' in window) {
            var mt = null;
            var mo = new MutationObserver(function () {
                if (mt) return;
                mt = setTimeout(function () {
                    mt = null;
                    tagReveals();
                    collectSpotlight();
                }, 350);
            });
            mo.observe(document.body, { childList: true, subtree: true });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot, { once: true });
    } else {
        boot();
    }
})();

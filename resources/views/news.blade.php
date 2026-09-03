<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    @include('partials.alpha-head')
    <title>ALPHA AI — @yield('title')</title>
</head>
<body class="al-body">

@include('partials.alpha-nav', ['active' => 'news'])

<script type="application/json" id="kurdai-firebase-config">{!! json_encode(config('kurdai.firebase'), 15) !!}</script>
<script type="application/json" id="kurdai-imgbb-config">{!! json_encode(config('kurdai.imgbb.api_key'), 15) !!}</script>
<script src="/js/kai-firebase.js?v=1" data-kai-shared defer></script>

<main class="al-container al-section">

    <header style="margin-bottom: 26px">
        <span class="al-kicker lang-str" data-so="نوێ" data-ba="نوی">نوێ</span>
        <h1 style="font-size: 1.9rem" class="lang-str" data-so="هەواڵی تەکنەلۆژیا و AI" data-ba="نووچێن تەکنەلۆژیایێ و AI">هەواڵی تەکنەلۆژیا و AI</h1>
    </header>

    <div class="al-adminbar" id="al-adminbar" style="display:none">
        <span class="al-tag al-tag--accent lang-str" data-so="دەسەڵاتی ئەدمین" data-ba="دەسەڵاتا ئەدمین">دەسەڵاتی ئەدمین</span>
        <button type="button" id="al-add-open" class="al-btn al-btn--solid al-btn--sm lang-str" data-so="+ هەواڵی نوێ" data-ba="+ نووچێ نوی">+ هەواڵی نوێ</button>
    </div>

    <div id="al-news" style="display:grid; gap:22px"></div>

    {{-- ---------- add modal ---------- --}}
    <div class="al-modal" id="al-add-modal" hidden>
        <div class="al-modal__box">
            <div class="al-modal__head">
                <h3 class="lang-str" data-so="هەواڵی نوێ" data-ba="نووچێ نوی">هەواڵی نوێ</h3>
                <button type="button" class="al-iconbtn" data-al-close="al-add-modal">✕</button>
            </div>
            <form id="al-add-form" class="al-modal__body">
                <label class="al-field"><span class="al-field__label">Title (سۆرانی)</span>
                    <input type="text" id="news_title_so" required class="al-input"></label>
                <label class="al-field"><span class="al-field__label">Title (بادینی)</span>
                    <input type="text" id="news_title_ba" class="al-input"></label>
                <label class="al-field"><span class="al-field__label lang-str" data-so="ناوەڕۆک (سۆرانی)" data-ba="ناڤەرۆک (سۆرانی)">ناوەڕۆک (سۆرانی)</span>
                    <textarea id="news_content_so" rows="5" required class="al-textarea"></textarea></label>
                <label class="al-field"><span class="al-field__label lang-str" data-so="ناوەڕۆک (بادینی)" data-ba="ناڤەرۆک (بادینی)">ناوەڕۆک (بادینی)</span>
                    <textarea id="news_content_ba" rows="5" class="al-textarea"></textarea></label>
                <label class="al-field"><span class="al-field__label lang-str" data-so="بەش" data-ba="بەش">بەش</span>
                    <select id="news_category" class="al-select">
                        <option value="ai">AI</option>
                        <option value="tech">Tech</option>
                        <option value="security">Security</option>
                        <option value="startup">Startup</option>
                    </select></label>
                <label class="al-field"><span class="al-field__label">Tags</span>
                    <input type="text" id="news_tags" class="al-input" placeholder="ai, tech"></label>
                <label class="al-field"><span class="al-field__label lang-str" data-so="وێنە" data-ba="وێنە">وێنە</span>
                    <input type="file" id="news_image_input" accept="image/*" class="al-input"></label>
                <button type="submit" id="submit-form-btn" class="al-btn al-btn--solid" style="width:100%">
                    <span class="lang-str" data-so="بڵاوکردنەوە" data-ba="بڵاوکرنەوە">بڵاوکردنەوە</span></button>
            </form>
        </div>
    </div>

    {{-- ---------- comments modal ---------- --}}
    <div class="al-modal" id="al-comments-modal" hidden>
        <div class="al-modal__box">
            <div class="al-modal__head">
                <h3 class="lang-str" data-so="لێدوانەکان" data-ba="لێدوان">لێدوانەکان</h3>
                <button type="button" class="al-iconbtn" data-al-close="al-comments-modal">✕</button>
            </div>
            <div class="al-modal__body">
                <div id="al-comments-list" style="display:grid;gap:12px;margin-bottom:18px"></div>
                <form id="al-comment-form">
                    <input type="hidden" id="al-comment-news">
                    <label class="al-field"><span class="al-field__label lang-str" data-so="لێدوانەکەت" data-ba="لێدوانێ تە">لێدوانەکەت</span>
                        <textarea id="al-comment-text" rows="3" required class="al-textarea"></textarea></label>
                    <button type="submit" class="al-btn al-btn--solid" style="width:100%">
                        <span class="lang-str" data-so="ناردن" data-ba="ناردن">ناردن</span></button>
                </form>
            </div>
        </div>
    </div>

</main>

@include('partials.alpha-foot')

<script type="module">
    import { getDatabase, ref as dbRef, push, set, remove, onValue, get } from "/js/firebase10/firebase-database.js";

    const KaiF = window.KaiFirebase || {};
    let app = KaiF.app ? KaiF.app() : null;
    let db = app ? getDatabase(app) : null;
    const IMGBB_API_KEY = JSON.parse((document.getElementById('kurdai-imgbb-config') || {}).textContent || 'null');

    let currentLang = localStorage.getItem('site-lang') || 'so';
    let firebaseDataCache = {};
    let currentUserId = '';
    if (window.KaiTrack) window.KaiTrack.visit('news');

    function esc(s) { return String(s == null ? '' : s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }
    function T(obj, base) { return (obj && (obj[base + '_' + currentLang] || obj[base + '_so'])) || ''; }
    function whenUser(cb) {
        if (KaiF.whenReady) KaiF.whenReady(function (st) { cb(st && st.user ? st.user : null); });
        else if (KaiF.onAuthStateChanged) KaiF.onAuthStateChanged(cb);
    }

    whenUser(function (user) { currentUserId = user ? user.uid : ''; });

    const ADMIN_EMAILS = ["team@alpha-ai.com", "alphaaiteam@gmail.com"];
    window.isAdmin = false;
    whenUser(function (user) {
        if (user && ADMIN_EMAILS.includes(String(user.email || '').toLowerCase())) {
            window.isAdmin = true;
            document.getElementById('al-adminbar').style.display = '';
        }
    });

    function renderNews(data) {
        const box = document.getElementById('al-news');
        const items = Object.entries(data || {})
            .filter(([, n]) => (n.status || 'published') === 'published')
            .sort((a, b) => (b[1].timestamp || 0) - (a[1].timestamp || 0));
        if (!items.length) {
            box.innerHTML = `<div class="al-empty lang-str" data-so="هێشتا هیچ هەواڵێک نییە" data-ba="هێشتا چ نووچ نین">هێشتا هیچ هەواڵێک نییە</div>`;
            return;
        }
        const isAdmin = window.isAdmin === true;
        box.innerHTML = items.map(([id, n]) => {
            const date = n.published_at ? new Date(n.published_at).toLocaleDateString('ckb-IQ') : '';
            const tags = Array.isArray(n.tags) ? n.tags : [];
            return `
            <article class="al-card al-fade-in" style="display:grid;grid-template-columns:260px 1fr;gap:0">
                <div class="al-item__media" style="border-radius:var(--al-radius-lg) 0 0 var(--al-radius-lg);border-bottom:none;border-inline-end:1px solid var(--al-line)">
                    ${n.image_url ? `<img src="${esc(n.image_url)}" loading="lazy" alt="${esc(T(n,'title'))}">` : ''}
                </div>
                <div class="al-item__body">
                    <div class="al-flex" style="gap:8px;flex-wrap:wrap;margin-bottom:10px">
                        <span class="al-tag al-tag--accent">${esc(n.category || 'news')}</span>
                        ${date ? `<span class="al-tag">${esc(date)}</span>` : ''}
                    </div>
                    <h2 class="al-item__title" style="font-size:1.25rem">${esc(T(n,'title'))}</h2>
                    <p class="al-item__desc" style="-webkit-line-clamp:4">${esc(T(n,'content'))}</p>
                    ${tags.length ? `<div class="al-flex" style="gap:6px;margin-top:12px">${tags.map(t => `<span class="al-tag">#${esc(t)}</span>`).join('')}</div>` : ''}
                    <div style="display:flex;gap:8px;margin-top:16px;flex-wrap:wrap">
                        <button type="button" data-read="${esc(id)}" class="al-btn al-btn--ghost al-btn--sm">📖 <span class="lang-str" data-so="خوێندنەوە" data-ba="خوێندنەوە">خوێندنەوە</span></button>
                        <button type="button" data-comments="${esc(id)}" class="al-btn al-btn--ghost al-btn--sm">💬 <span class="lang-str" data-so="لێدوان" data-ba="لێدوان">لێدوان</span></button>
                        ${isAdmin ? `<button type="button" data-del="${esc(id)}" class="al-btn al-btn--danger al-btn--sm lang-str" data-so="سڕینەوە" data-ba="سڕینەوە">سڕینەوە</button>` : ''}
                    </div>
                </div>
            </article>`;
        }).join('');

        box.querySelectorAll('[data-del]').forEach(b => b.addEventListener('click', async () => {
            if (confirm('دڵنیایت لە سڕینەوە؟') && db) await remove(dbRef(db, 'news/' + b.dataset.del));
        }));
        box.querySelectorAll('[data-read]').forEach(b => b.addEventListener('click', () => {
            const n = firebaseDataCache[b.dataset.read];
            if (!n) return;
            alert((T(n, 'title')) + '\n\n' + (T(n, 'content')));
        }));
        box.querySelectorAll('[data-comments]').forEach(b => b.addEventListener('click', () => openComments(b.dataset.comments)));
    }

    /* ---------- comments ---------- */
    async function openComments(newsId) {
        document.getElementById('al-comment-news').value = newsId;
        document.getElementById('al-comments-modal').hidden = false;
        const list = document.getElementById('al-comments-list');
        list.innerHTML = '';
        if (!db) return;
        const snap = await get(dbRef(db, `news/${newsId}/comments`));
        const comments = Object.entries(snap.val() || {}).sort((a, b) => (a[1].timestamp || 0) - (b[1].timestamp || 0));
        list.innerHTML = comments.length ? comments.map(([cid, c]) => `
            <div class="al-card al-card--pad" style="padding:14px 16px">
                <div class="al-flex al-flex--between" style="margin-bottom:6px">
                    <strong style="font-size:0.85rem">${esc(c.author_name || 'بەکارهێنەر')}</strong>
                    ${(window.isAdmin || c.uid === currentUserId) ? `<button type="button" data-cdel="${esc(cid)}" class="al-btn al-btn--danger al-btn--sm">✕</button>` : ''}
                </div>
                <p style="font-size:0.88rem;line-height:1.7">${esc(c.text)}</p>
            </div>`).join('')
            : `<div class="al-empty" style="padding:20px">هێشتا لێدوان نییە</div>`;
        list.querySelectorAll('[data-cdel]').forEach(b => b.addEventListener('click', async () => {
            if (confirm('سڕینەوەی لێدوان؟') && db) {
                await remove(dbRef(db, `news/${newsId}/comments/${b.dataset.cdel}`));
                openComments(newsId);
            }
        }));
    }

    document.getElementById('al-comment-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const newsId = document.getElementById('al-comment-news').value;
        const text = document.getElementById('al-comment-text').value.trim();
        if (!newsId || !text || !db) return;
        await set(push(dbRef(db, `news/${newsId}/comments`)), {
            uid: currentUserId,
            author_name: window.KaiF && KaiF.user && KaiF.user.email ? KaiF.user.email.split('@')[0] : 'بەکارهێنەر',
            text: text,
            timestamp: Date.now()
        });
        document.getElementById('al-comment-text').value = '';
        openComments(newsId);
    });

    /* ---------- language ---------- */
    function applyLanguage() {
        const lt = document.getElementById('lang-text');
        if (lt) lt.textContent = currentLang === 'so' ? 'بادینی' : 'سۆرانی';
        document.querySelectorAll('.lang-str').forEach(el => { el.textContent = el.getAttribute('data-' + currentLang) || el.getAttribute('data-so'); });
        renderNews(firebaseDataCache);
    }
    document.getElementById('lang-toggle').addEventListener('click', () => {
        currentLang = currentLang === 'so' ? 'ba' : 'so';
        localStorage.setItem('site-lang', currentLang);
        applyLanguage();
    });

    function openModal(id) { document.getElementById(id).hidden = false; }
    function closeModal(id) { document.getElementById(id).hidden = true; }
    document.querySelectorAll('[data-al-close]').forEach(b => b.addEventListener('click', () => closeModal(b.dataset.alClose)));
    document.getElementById('al-add-open').addEventListener('click', () => openModal('al-add-modal'));

    /* ---------- subscribe ---------- */
    function subscribe(fdb) {
        onValue(dbRef(fdb, 'news'), (snapshot) => {
            firebaseDataCache = snapshot.val() || {};
            renderNews(firebaseDataCache);
        });
    }
    window.KaiPageReady(function () {
        if (db) subscribe(db);
        else if (KaiF.whenReady) KaiF.whenReady(function (S) { if (S && S.db) { db = S.db; subscribe(db); } });
    });

    /* ---------- add form (same contract) ---------- */
    let isUploading = false;
    document.getElementById('al-add-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        if (isUploading || !db) return;
        const btn = document.getElementById('submit-form-btn');
        isUploading = true; btn.disabled = true; btn.style.opacity = .6;
        try {
            let image_url = '';
            const file = document.getElementById('news_image_input').files[0];
            if (file) {
                const fd = new FormData(); fd.append('image', file);
                const res = await fetch(`https://api.imgbb.com/1/upload?key=${IMGBB_API_KEY}`, { method: 'POST', body: fd });
                const rData = await res.json();
                if (!rData.success) throw new Error('upload failed');
                image_url = rData.data.url;
            }
            const tags = (document.getElementById('news_tags').value || '').split(',').map(t => t.trim()).filter(Boolean).slice(0, 3);
            const now = Date.now();
            await set(push(dbRef(db, 'news')), {
                title_so: document.getElementById('news_title_so').value,
                title_ba: document.getElementById('news_title_ba').value,
                content_so: document.getElementById('news_content_so').value,
                content_ba: document.getElementById('news_content_ba').value,
                image_url: image_url,
                category: document.getElementById('news_category').value,
                tags: tags,
                status: 'published',
                published_at: new Date(now).toISOString(),
                timestamp: now
            });
            document.getElementById('al-add-form').reset();
            closeModal('al-add-modal');
        } catch (err) {
            alert('نەتوانرا بڵاو بکرێتەوە — دووبارە هەوڵ بدەرەوە');
        } finally {
            isUploading = false; btn.disabled = false; btn.style.opacity = 1;
        }
    });

    applyLanguage();
</script>
</body>
</html>

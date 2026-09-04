<!DOCTYPE html>
<html lang="ckb" dir="rtl" class="dark">
<head>
    @include('partials.a1-head')
    <title>ALPHA AI — @yield('title')</title>
</head>
<body class="a1">

@include('partials.a1-rail', ['active' => 'news'])


<div class="a1-main">
    <div class="a1-page">

        <div class="a1-strip"><span class="a1-strip__dot"></span><span class="a1-strip__crumb">ALPHA / NEWS</span></div>

        <div class="a1-section-head">
            <h2 class="lang-str" data-so="هەواڵ" data-ba="نووچە">هەواڵ</h2>
            <span class="a1-index" id="a1-count">—</span>
        </div>

        <div class="a1-hrow" style="margin-bottom:22px">
            <span></span>
            <button type="button" id="a1-add-open" class="a1-btn a1-btn--accent a1-btn--sm lang-str admin-only" data-so="+ هەواڵی نوێ" data-ba="+ نووچێ نوی" style="display:none">+ هەواڵی نوێ</button>
        </div>

        <div class="a1-rows" id="a1-news"></div>

        <div class="a1-sheet" id="a1-add-sheet" hidden>
            <div class="a1-sheet__box">
                <div class="a1-sheet__head">
                    <span class="lang-str" data-so="هەواڵی نوێ" data-ba="نووچێ نوی">هەواڵی نوێ</span>
                    <button type="button" class="a1-btn a1-btn--quiet a1-btn--sm" data-a1-close="a1-add-sheet">✕</button>
                </div>
                <form id="a1-add-form" class="a1-sheet__body">
                    <label class="a1-field"><span class="a1-field__label">TITLE — سۆرانی</span><input type="text" id="news_title_so" required class="a1-input"></label>
                    <label class="a1-field"><span class="a1-field__label">TITLE — بادینی</span><input type="text" id="news_title_ba" class="a1-input"></label>
                    <label class="a1-field"><span class="a1-field__label">BODY — سۆرانی</span><textarea id="news_content_so" rows="5" required class="a1-textarea"></textarea></label>
                    <label class="a1-field"><span class="a1-field__label">BODY — بادینی</span><textarea id="news_content_ba" rows="5" class="a1-textarea"></textarea></label>
                    <label class="a1-field"><span class="a1-field__label">CATEGORY</span>
                        <select id="news_category" class="a1-select">
                            <option value="ai">ai</option><option value="tech">tech</option>
                            <option value="security">security</option><option value="startup">startup</option>
                        </select></label>
                    <label class="a1-field"><span class="a1-field__label">TAGS</span><input type="text" id="news_tags" class="a1-input" placeholder="ai, tech"></label>
                    <label class="a1-field"><span class="a1-field__label">IMAGE</span><input type="file" id="news_image_input" accept="image/*" class="a1-input"></label>
                    <button type="submit" id="submit-form-btn" class="a1-btn a1-btn--accent" style="width:100%">
                        <span class="lang-str" data-so="بڵاوکردنەوە" data-ba="بڵاوکرنەوە">بڵاوکردنەوە</span></button>
                </form>
            </div>
        </div>

        {{-- comments sheet --}}
        <div class="a1-sheet" id="a1-comments-sheet" hidden>
            <div class="a1-sheet__box">
                <div class="a1-sheet__head">
                    <span class="lang-str" data-so="لێدوان" data-ba="لێدوان">لێدوان</span>
                    <button type="button" class="a1-btn a1-btn--quiet a1-btn--sm" data-a1-close="a1-comments-sheet">✕</button>
                </div>
                <div class="a1-sheet__body">
                    <div id="a1-comments-list" class="a1-stack" style="margin-bottom:20px"></div>
                    <form id="a1-comment-form">
                        <input type="hidden" id="a1-comment-news">
                        <label class="a1-field"><span class="a1-field__label lang-str" data-so="لێدوانەکەت" data-ba="لێدوانێ تە">لێدوانەکەت</span>
                            <textarea id="a1-comment-text" rows="3" required class="a1-textarea"></textarea></label>
                        <button type="submit" class="a1-btn a1-btn--accent" style="width:100%">
                            <span class="lang-str" data-so="ناردن" data-ba="ناردن">ناردن</span></button>
                    </form>
                </div>
            </div>
        </div>

        @include('partials.a1-foot')
    </div>
</div>

<script type="module">
    import { getDatabase, ref as dbRef, push, set, remove, onValue, get } from "/js/firebase10/firebase-database.js";

    const KaiF = window.KaiFirebase || {};
    let app = KaiF.app ? KaiF.app() : null;
    let db = app ? getDatabase(app) : null;
    const IMGBB_API_KEY = JSON.parse((document.getElementById('kurdai-imgbb-config') || {}).textContent || 'null');

    let currentLang = localStorage.getItem('site-lang') || 'so';
    let cache = {};
    let currentUserId = '';
    if (window.KaiTrack) window.KaiTrack.visit('news');

    function esc(s) { return String(s == null ? '' : s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }
    function T(o, b) { return (o && (o[b + '_' + currentLang] || o[b + '_so'])) || ''; }
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
            document.querySelectorAll('.admin-only').forEach(el => el.style.display = '');
        }
    });

    function render() {
        const box = document.getElementById('a1-news');
        const items = Object.entries(cache)
            .filter(([, n]) => (n.status || 'published') === 'published')
            .sort((a, b) => (b[1].timestamp || 0) - (a[1].timestamp || 0));
        document.getElementById('a1-count').textContent = items.length + ' ITEMS';
        if (!items.length) { box.innerHTML = `<div class="a1-empty">EMPTY</div>`; return; }
        const isAdmin = window.isAdmin === true;
        box.innerHTML = items.map(([id, n]) => {
            const date = n.published_at ? new Date(n.published_at).toISOString().slice(0, 10) : '';
            const tags = Array.isArray(n.tags) ? n.tags : [];
            return `
            <article class="a1-row">
                <div class="a1-row__glyph">${n.image_url ? `<img src="${esc(n.image_url)}" loading="lazy" alt="">` : 'N'}</div>
                <div>
                    <div class="a1-row__title">${esc(T(n,'title'))}</div>
                    <p class="a1-row__desc">${esc(T(n,'content'))}</p>
                    <div class="a1-row__meta">
                        <span class="a1-tag a1-tag--accent">${esc(n.category || 'news')}</span>
                        ${date ? `<span class="a1-tag">${esc(date)}</span>` : ''}
                        ${tags.map(t => `<span class="a1-tag">#${esc(t)}</span>`).join('')}
                    </div>
                </div>
                <div class="a1-row__actions">
                    <button type="button" data-read="${esc(id)}" class="a1-btn a1-btn--line a1-btn--sm">📖 <span class="lang-str" data-so="خوێندن" data-ba="خوێندن">خوێندن</span></button>
                    <button type="button" data-comments="${esc(id)}" class="a1-btn a1-btn--line a1-btn--sm">💬 <span class="lang-str" data-so="لێدوان" data-ba="لێدوان">لێدوان</span></button>
                    ${isAdmin ? `<button type="button" data-del="${esc(id)}" class="a1-btn a1-btn--quiet a1-btn--sm lang-str" data-so="سڕینەوە" data-ba="سڕینەوە">سڕینەوە</button>` : ''}
                </div>
            </article>`;
        }).join('');
        box.querySelectorAll('[data-del]').forEach(b => b.addEventListener('click', async () => {
            if (confirm('سڕینەوە؟') && db) await remove(dbRef(db, 'news/' + b.dataset.del));
        }));
        box.querySelectorAll('[data-read]').forEach(b => b.addEventListener('click', () => {
            const n = cache[b.dataset.read]; if (!n) return;
            alert(T(n, 'title') + '\n\n' + T(n, 'content'));
        }));
        box.querySelectorAll('[data-comments]').forEach(b => b.addEventListener('click', () => openComments(b.dataset.comments)));
    }

    async function openComments(newsId) {
        document.getElementById('a1-comment-news').value = newsId;
        document.getElementById('a1-comments-sheet').hidden = false;
        const list = document.getElementById('a1-comments-list');
        list.innerHTML = '';
        if (!db) return;
        const snap = await get(dbRef(db, `news/${newsId}/comments`));
        const comments = Object.entries(snap.val() || {}).sort((a, b) => (a[1].timestamp || 0) - (b[1].timestamp || 0));
        list.innerHTML = comments.length ? comments.map(([cid, c]) => `
            <div style="border:1px solid var(--a1-line);padding:14px 16px">
                <div class="a1-hrow" style="margin-bottom:6px">
                    <strong style="font-size:0.85rem">${esc(c.author_name || 'USER')}</strong>
                    ${(window.isAdmin || c.uid === currentUserId) ? `<button type="button" data-cdel="${esc(cid)}" class="a1-btn a1-btn--quiet a1-btn--sm">✕</button>` : ''}
                </div>
                <p style="font-size:0.88rem;line-height:1.8;color:var(--a1-dim);margin:0">${esc(c.text)}</p>
            </div>`).join('') : `<div class="a1-empty">NO COMMENTS</div>`;
        list.querySelectorAll('[data-cdel]').forEach(b => b.addEventListener('click', async () => {
            if (confirm('سڕینەوەی لێدوان؟') && db) {
                await remove(dbRef(db, `news/${newsId}/comments/${b.dataset.cdel}`));
                openComments(newsId);
            }
        }));
    }

    document.getElementById('a1-comment-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const newsId = document.getElementById('a1-comment-news').value;
        const text = document.getElementById('a1-comment-text').value.trim();
        if (!newsId || !text || !db) return;
        await set(push(dbRef(db, `news/${newsId}/comments`)), {
            uid: currentUserId,
            author_name: 'USER',
            text: text,
            timestamp: Date.now()
        });
        document.getElementById('a1-comment-text').value = '';
        openComments(newsId);
    });

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
        onValue(dbRef(fdb, 'news'), (snapshot) => { cache = snapshot.val() || {}; render(); });
    }
    window.KaiPageReady(function () {
        if (db) subscribe(db);
        else if (KaiF.whenReady) KaiF.whenReady(function (S) { if (S && S.db) { db = S.db; subscribe(db); } });
    });

    let busy = false;
    document.getElementById('a1-add-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        if (busy || !db) return;
        const btn = document.getElementById('submit-form-btn');
        busy = true; btn.disabled = true;
        try {
            let image_url = '';
            const file = document.getElementById('news_image_input').files[0];
            if (file) {
                const fd = new FormData(); fd.append('image', file);
                const res = await fetch(`https://api.imgbb.com/1/upload?key=${IMGBB_API_KEY}`, { method: 'POST', body: fd });
                const rData = await res.json();
                if (!rData.success) throw new Error('upload');
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
            document.getElementById('a1-add-form').reset();
            closeSheet('a1-add-sheet');
        } catch (err) { alert('نەمانتوانی بڵاو بکەین'); }
        finally { busy = false; btn.disabled = false; }
    });

    applyLanguage();
</script>
</body>
</html>

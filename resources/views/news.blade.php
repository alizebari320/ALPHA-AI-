@extends('layouts.app')

@section('title', 'هەواڵەکان — ALPHA/AI')

@section('content')
@include('partials.nav', ['active' => 'news'])
<div id="page-shell" style="display:none">


    

    <div class="tech-glow w-72 h-72 bg-gold -top-20 left-1/3"></div>

    <header class="relative z-10 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 py-16 md:py-20 text-center relative">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-gold/40 bg-gold/10 text-amber-800 dark:text-gold text-xs font-bold mb-5">
                <span class="w-2 h-2 rounded-full bg-gold animate-pulse"></span>
                نوێترین هەواڵەکان
            </div>
            <h1 class="text-4xl md:text-6xl font-black font-display tracking-tight mb-4 text-slate-900 dark:text-white">هەواڵ و <span class="glow-text">پێشهاتەکان</span></h1>
            <p class="text-lg text-slate-500 dark:text-slate-400">ئاگاداری نوێترین هەواڵەکانی تەکنەلۆژیا و ژیریی دەستکرد بە</p>
        </div>
    </header>

    <section class="admin-only hidden relative z-10 max-w-4xl mx-auto px-4 pb-12">
        <div class="card p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 left-0 h-1.5 bg-gradient-to-l from-amber-400 to-amber-600"></div>
            <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
                <h3 class="font-mega text-3xl tracking-wide gold-text">بڵاوکردنەوەی هەواڵی نوێ</h3>
                <span class="corner-tag">// ADMIN CONSOLE</span>
            </div>
            <form id="add-news-form">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="tech-label">سەردێڕ (سۆرانی)</label>
                        <input type="text" id="news_title_so" required class="tech-input">
                    </div>
                    <div>
                        <label class="tech-label">سەردێڕ (بادینی)</label>
                        <input type="text" id="news_title_ba" required class="tech-input">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="tech-label">ناوەرۆک (سۆرانی)</label>
                        <textarea id="news_content_so" required rows="4" class="tech-textarea resize-none"></textarea>
                    </div>
                    <div>
                        <label class="tech-label">ناوەرۆک (بادینی)</label>
                        <textarea id="news_content_ba" required rows="4" class="tech-textarea resize-none"></textarea>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="tech-label">وێنەی هەواڵ</label>
                    <div class="relative border-2 border-dashed border-slate-300 dark:border-white/15 rounded-xl p-4 hover:bg-gold/10 transition">
                        <input type="file" id="news_image" accept="image/*" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <p class="text-center text-sm font-bold text-slate-500 dark:text-slate-400 pointer-events-none">کلیک بکە بۆ هەڵبژاردنی وێنە</p>
                    </div>
                </div>
                <button type="submit" id="submit-news-btn" class="w-full btn btn-primary justify-center !py-3 text-base">بڵاوکردنەوە</button>
            </form>
        </div>
    </section>

    <section class="relative z-10 max-w-7xl mx-auto px-4 pb-24">
        <div id="news-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"></div>
    </section>

    <div id="newsModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center px-4 py-8">
        <div class="absolute inset-0 bg-slate-900/70 backdrop-blur-sm transition-opacity" onclick="window.closeNewsModal()"></div>
        <div class="card relative w-full max-w-4xl max-h-[90vh] rounded-2xl shadow-2xl flex flex-col overflow-hidden">
            <button onclick="window.closeNewsModal()" class="absolute top-4 right-4 z-20 p-2 bg-slate-900/50 text-white hover:bg-red-500 rounded-lg transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="overflow-y-auto">
                <div class="w-full h-64 md:h-80 relative bg-slate-200 dark:bg-slate-800">
                    <img id="modalImg" src="" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 to-transparent"></div>
                    <div class="absolute bottom-6 px-6 w-full">
                        <span id="modalDate" class="text-gold font-bold text-xs mb-2 block font-mono"></span>
                        <h2 id="modalTitle" class="text-2xl md:text-3xl font-black font-display text-white"></h2>
                    </div>
                </div>
                <div class="p-6 md:p-8">
                    <p id="modalBody" class="text-slate-600 dark:text-slate-300 leading-loose whitespace-pre-wrap"></p>
                </div>
                <div class="p-6 md:p-8 bg-slate-50 dark:bg-white/[.03] border-t border-slate-200/70 dark:border-white/10">
                    <h3 class="text-xl font-black font-display mb-6 flex items-center gap-2 text-slate-900 dark:text-white">
                        <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        بۆچوونەکان
                    </h3>
                    <div id="comments-list" class="space-y-4 mb-6 max-h-60 overflow-y-auto pl-2"></div>
                    <form id="comment-form" class="flex gap-3">
                        <input type="hidden" id="current_news_id">
                        <input type="text" id="comment_input" required class="flex-grow tech-input text-sm" placeholder="بۆچوونی خۆت بنووسە...">
                        <button type="submit" id="comment-btn" class="btn btn-primary">ناردن</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";
        import { getDatabase, ref as dbRef, push, set, remove, onValue } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";

        const firebaseConfig = { apiKey: "AIzaSyB-6_Ga6o3i3VYfjOX_UmKtI2qpsGHycJs", authDomain: "alphaai-d4f4c.firebaseapp.com", databaseURL: "https://alphaai-d4f4c-default-rtdb.firebaseio.com", projectId: "alphaai-d4f4c" };
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const db = getDatabase(app);
        const IMGBB_API_KEY = "947299981b43abca761315a1cd24c02a";

        let currentLang = localStorage.getItem('site-lang') || 'so';
        let newsData = {};
        window.isAdmin = false;
        let currentUser = null;

        const loc = (obj, key) => currentLang === 'ba' && obj[key + '_ba'] ? obj[key + '_ba'] : obj[key + '_so'] || obj[key];

        function formatDate(timestamp) {
            const date = new Date(timestamp);
            return date.toLocaleDateString('en-GB') + ' - ' + date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        }

        onValue(dbRef(db, 'news'), (s) => { newsData = s.val() || {}; renderNews(); });

        function renderNews() {
            const container = document.getElementById('news-container');
            if(!container) return;
            container.innerHTML = '';
            const newsKeys = Object.keys(newsData).sort((a,b) => newsData[b].timestamp - newsData[a].timestamp);
            if (newsKeys.length === 0) {
                container.innerHTML = `<div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-20 tech-card"><p class="text-slate-500 dark:text-slate-400 font-bold">هیچ هەواڵێک بوونی نییە.</p></div>`;
                return;
            }
            newsKeys.forEach(id => {
                const n = newsData[id];
                const title = loc(n, 'title');
                const content = loc(n, 'content');
                const dateStr = formatDate(n.timestamp);
                const safeTitle = (title || "").replace(/"/g, '&quot;').replace(/'/g, "\\'");
                const safeContent = (content || "").replace(/"/g, '&quot;').replace(/'/g, "\\'");
                const safeImg = (n.image_url || "").replace(/"/g, '&quot;');
                let adminBtn = '';
                if(window.isAdmin) {
                    adminBtn = `<button onclick="window.deleteNews('${id}')" class="w-full mt-2 py-2 bg-red-500/10 text-red-500 dark:text-red-400 font-bold rounded-lg text-xs border border-red-500/30 hover:bg-red-500/20 transition">سڕینەوەی هەواڵ</button>`;
                }
                container.innerHTML += `
                    <div class="card overflow-hidden flex flex-col group">
                        <div class="relative h-52 overflow-hidden bg-slate-200 dark:bg-slate-800 cursor-pointer" onclick="window.openNewsModal('${id}', '${safeTitle}', '${safeContent}', '${safeImg}', '${dateStr}')">
                            <img src="${n.image_url}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute bottom-3 right-3 bg-slate-900/70 text-white text-[10px] font-bold px-2.5 py-1 rounded-lg font-mono backdrop-blur">${dateStr}</div>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="font-black font-display text-xl mb-3 line-clamp-2 text-slate-900 dark:text-white">${title}</h3>
                            <p class="text-slate-500 dark:text-slate-400 text-sm mb-5 line-clamp-3 flex-grow">${content}</p>
                            <button onclick="window.openNewsModal('${id}', '${safeTitle}', '${safeContent}', '${safeImg}', '${dateStr}')" class="w-full btn btn-stone justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                خوێندنەوە و بۆچوون
                            </button>
                            ${adminBtn}
                        </div>
                    </div>
                `;
            });
        }

        let isUploading = false;
        document.getElementById('add-news-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const file = document.getElementById('news_image').files[0];
            const btn = document.getElementById('submit-news-btn');
            if(file && !isUploading) {
                isUploading = true;
                btn.innerText = "چاوەڕێ بکە..."; btn.classList.add('opacity-70', 'cursor-wait');
                try {
                    const fd = new FormData(); fd.append("image", file);
                    const res = await fetch(`https://api.imgbb.com/1/upload?key=${IMGBB_API_KEY}`, { method: 'POST', body: fd });
                    const rData = await res.json();
                    if(rData.success) {
                        await set(push(dbRef(db, 'news')), {
                            title_so: document.getElementById('news_title_so').value,
                            title_ba: document.getElementById('news_title_ba').value,
                            content_so: document.getElementById('news_content_so').value,
                            content_ba: document.getElementById('news_content_ba').value,
                            image_url: rData.data.url,
                            timestamp: Date.now()
                        });
                        alert("هەواڵەکە بڵاوکرایەوە!");
                        e.target.reset();
                    }
                } catch(err) { alert("کێشەیەک ڕوویدا"); }
                isUploading = false;
                btn.innerText = "بڵاوکردنەوە"; btn.classList.remove('opacity-70', 'cursor-wait');
            }
        });

        window.deleteNews = async function(id) {
            if(confirm('دڵنیایت لە سڕینەوەی ئەم هەواڵە؟')) { await remove(dbRef(db, `news/${id}`)); }
        };

        let activeCommentsListener = null;
        window.openNewsModal = function(id, title, content, imgUrl, dateStr) {
            document.getElementById('modalImg').src = imgUrl;
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalBody').innerText = content;
            document.getElementById('modalDate').innerText = dateStr;
            document.getElementById('current_news_id').value = id;
            const modal = document.getElementById('newsModal');
            modal.classList.remove('hidden');
            if(activeCommentsListener) activeCommentsListener();
            const commentsRef = dbRef(db, `news/${id}/comments`);
            const list = document.getElementById('comments-list');
            activeCommentsListener = onValue(commentsRef, (snapshot) => {
                list.innerHTML = '';
                const coms = snapshot.val();
                if(!coms) { list.innerHTML = `<p class="text-stone-500 text-sm text-center py-4">هیچ بۆچوونێک نییە.</p>`; return; }
                Object.keys(coms).sort((a,b) => coms[a].timestamp - coms[b].timestamp).forEach(cid => {
                    const c = coms[cid];
                    const cDate = new Date(c.timestamp).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
                    let delBtn = '';
                    if(window.isAdmin || (currentUser && currentUser.email === c.email)) {
                        delBtn = `<button onclick="window.deleteComment('${id}', '${cid}')" class="text-red-500 hover:text-red-700 text-xs">سڕینەوە</button>`;
                    }
                    list.innerHTML += `
                        <div class="bg-white/70 dark:bg-white/[.04] p-4 rounded-xl border border-slate-200/70 dark:border-white/10">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-bold text-amber-800 dark:text-gold text-sm">${c.name}</span>
                                <div class="flex items-center gap-3">
                                    <span class="text-xs text-slate-400">${cDate}</span>
                                    ${delBtn}
                                </div>
                            </div>
                            <p class="text-slate-600 dark:text-slate-300 text-sm">${c.text}</p>
                        </div>`;
                });
            });
        };

        window.closeNewsModal = function() {
            document.getElementById('newsModal').classList.add('hidden');
            if(activeCommentsListener) { activeCommentsListener(); activeCommentsListener = null; }
        };

        document.getElementById('comment-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            if(!currentUser) return alert("بۆ نووسینی کۆمێنت پێویستە هەژمارت هەبێت.");
            const newsId = document.getElementById('current_news_id').value;
            const textInput = document.getElementById('comment_input');
            const text = textInput.value.trim();
            if(text && newsId) {
                try {
                    await set(push(dbRef(db, `news/${newsId}/comments`)), {
                        name: currentUser.displayName || currentUser.email.split('@')[0],
                        email: currentUser.email,
                        text: text,
                        timestamp: Date.now()
                    });
                    textInput.value = '';
                } catch(err) { alert("هەڵەیەک ڕوویدا"); }
            }
        });

        window.deleteComment = async function(newsId, commentId) {
            if(confirm("دڵنیایت لە سڕینەوەی ئەم کۆمێنتە؟")) { await remove(dbRef(db, `news/${newsId}/comments/${commentId}`)); }
        };

        onAuthStateChanged(auth, (user) => {
            if(!user) window.location.href = "/login";
            else {
                document.getElementById('page-shell').style.display = 'block';
                currentUser = user;
                if((user && ["alphaaiteam@gmail.com"].includes(user.email))) {
                    window.isAdmin = true;
                    document.querySelector('.admin-only').classList.remove('hidden');
                }
            }
        });
    </script>

@include('partials.footer')
</div>
@endsection
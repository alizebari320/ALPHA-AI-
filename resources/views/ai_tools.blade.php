@extends('layouts.app')

@section('title', 'تووڵەکانی AI — ALPHA/AI')

@section('content')
@include('partials.nav', ['active' => 'tools'])
<div id="page-shell" style="display:none">


    

    <div class="tech-glow w-72 h-72 bg-amber-600 -top-20 left-1/3"></div>

    <header class="relative z-10 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 py-16 md:py-20 relative">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-gold/40 bg-gold/10 text-amber-800 dark:text-gold text-xs font-bold mb-5">
                <span class="w-2 h-2 rounded-full bg-gold animate-pulse"></span>
                گەنجینەی ئامرازەکان
            </div>
            <h1 class="text-4xl md:text-6xl font-black font-display text-slate-900 dark:text-white mb-3">تووڵەکانی <span class="glow-text">AI</span></h1>
            <p class="text-slate-500 dark:text-slate-400 text-lg">باشترین ئامرازەکانی ژیریی دەستکرد لە شوێنێکدا</p>
        </div>
    </header>

    <section class="relative z-10 max-w-7xl mx-auto px-4 py-8">
        <div id="cat-filters" class="flex flex-wrap gap-2 mb-8"></div>
        <div id="tools-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"></div>
    </section>

    <section id="admin-section" class="hidden relative z-10 max-w-7xl mx-auto px-4 pb-12">
        <div class="card p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 left-0 h-1.5 bg-gradient-to-l from-amber-400 to-amber-600"></div>
            <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
                <h2 class="font-mega text-3xl tracking-wide gold-text">زیادکردنی تووڵ</h2>
                <span class="corner-tag">// ADMIN CONSOLE</span>
            </div>
            <form id="upload-form" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" id="title_so" placeholder="ناو (سۆرانی)" required class="tech-input">
                <input type="text" id="title_ba" placeholder="ناو (بادینی)" required class="tech-input">
                <textarea id="desc_so" placeholder="وەسف (سۆرانی)" required rows="3" class="tech-textarea resize-none"></textarea>
                <textarea id="desc_ba" placeholder="وەسف (بادینی)" required rows="3" class="tech-textarea resize-none"></textarea>
                <select id="tool_category" class="tech-select">
                    <option value="چات بۆت (Chatbot)">چات بۆت</option>
                    <option value="وێنە (Image)">وێنە</option>
                    <option value="ڤیدیۆ (Video)">ڤیدیۆ</option>
                    <option value="کۆدکردن (Coding)">کۆدکردن</option>
                    <option value="دەنگ (Audio)">دەنگ</option>
                    <option value="بەرهەمهێنان (Productivity)">بەرهەمهێنان</option>
                    <option value="پێشکەشکردن (Presentation)">پێشکەشکردن</option>
                    <option value="بیرکاری (Math)">بیرکاری</option>
                    <option value="نووسین (Content)">نووسین</option>
                    <option value="تر (Other)">تر</option>
                </select>
                <input type="url" id="tool_url" placeholder="لینک" required dir="ltr" class="tech-input">
                <div class="md:col-span-2">
                    <input type="file" id="tool_image_input" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gold/10 file:text-amber-800 dark:file:text-amber-700 hover:file:bg-gold/20">
                </div>
                <div class="md:col-span-2">
                    <button type="submit" id="submit-form-btn" class="btn btn-primary w-full justify-center">زیادکردنی تووڵ</button>
                </div>
            </form>
        </div>
    </section>

    @include('partials.footer')

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";
        import { getDatabase, ref as dbRef, push, set, onValue } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";

        const firebaseConfig = { apiKey: "AIzaSyB-6_Ga6o3i3VYfjOX_UmKtI2qpsGHycJs", authDomain: "alphaai-d4f4c.firebaseapp.com", databaseURL: "https://alphaai-d4f4c-default-rtdb.firebaseio.com", projectId: "alphaai-d4f4c", storageBucket: "alphaai-d4f4c.firebasestorage.app", messagingSenderId: "518050080770", appId: "1:518050080770:web:c00d17cdbbbacb8ddd1f1b", measurementId: "G-ESXRFB9QZW" };
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const db = getDatabase(app);
        const IMGBB_API_KEY = "947299981b43abca761315a1cd24c02a";

        let cache = {}, activeCat = 'all';

        const catMeta = {
            'چات بۆت (Chatbot)': { icon: '💬', label: 'چات بۆت', color: 'border-l-gold' },
            'وێنە (Image)': { icon: '🎨', label: 'وێنە', color: 'border-l-amber-500' },
            'ڤیدیۆ (Video)': { icon: '🎬', label: 'ڤیدیۆ', color: 'border-l-red-500' },
            'کۆدکردن (Coding)': { icon: '💻', label: 'کۆدکردن', color: 'border-l-blue-500' },
            'دەنگ (Audio)': { icon: '🎵', label: 'دەنگ', color: 'border-l-amber-600' },
            'بەرهەمهێنان (Productivity)': { icon: '⚡', label: 'بەرهەمهێنان', color: 'border-l-yellow-500' },
            'پێشکەشکردن (Presentation)': { icon: '📊', label: 'پێشکەشکردن', color: 'border-l-indigo-500' },
            'بیرکاری (Math)': { icon: '🔢', label: 'بیرکاری', color: 'border-l-teal-500' },
            'نووسین (Content)': { icon: '✍️', label: 'نووسین', color: 'border-l-orange-500' },
            'تر (Other)': { icon: '🔧', label: 'تر', color: 'border-l-stone-500' }
        };

        function render(data) {
            const container = document.getElementById('tools-container');
            const filters = document.getElementById('cat-filters');
            if (!container) return;
            container.innerHTML = ''; filters.innerHTML = '';

            if (!data || Object.keys(data).length === 0) {
                container.innerHTML = '<div class="col-span-full text-center py-20 text-slate-400 dark:text-slate-500 font-bold tech-card">هێشتا هیچ تووڵێک زیاد نەکراوە</div>';
                return;
            }

            const grouped = {};
            for (let id in data) {
                const t = data[id]; const cat = t.category || 'تر (Other)';
                if (!grouped[cat]) grouped[cat] = [];
                grouped[cat].push({id, ...t});
            }

            const cats = Object.keys(grouped).sort();
            let allCount = Object.keys(data).length;
            filters.innerHTML = `<div class="tab-btn ${activeCat==='all'?'active':''}" data-cat="all">هەموو (${allCount})</div>`;
            cats.forEach(cat => {
                filters.innerHTML += `<div class="tab-btn ${activeCat===cat?'active':''}" data-cat="${cat}">${catMeta[cat]?.icon||'🔧'} ${catMeta[cat]?.label||cat} (${grouped[cat].length})</div>`;
            });

            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    activeCat = btn.dataset.cat;
                    render(cache);
                });
            });

            const shown = activeCat === 'all' ? cats : [activeCat];
            shown.forEach(cat => {
                grouped[cat].forEach(t => {
                    const title = t.title_so || t.title;
                    const desc = t.desc_so || t.desc || '';
                    container.innerHTML += `
                        <div class="card p-6 flex flex-col anim-card relative overflow-hidden group">
                            <div class="absolute -top-8 -left-8 w-24 h-24 rounded-full bg-gold/10 blur-xl group-hover:bg-gold/20 transition"></div>
                            <div class="flex items-center gap-3 mb-4 relative">
                                ${t.image_url ? `<img src="${t.image_url}" class="w-11 h-11 rounded-xl object-contain bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 p-1.5">` : `<div class="w-11 h-11 rounded-xl bg-gradient-to-br from-gold/20 to-amber-600/20 border border-white/10 flex items-center justify-center text-lg">${catMeta[cat]?.icon||'🔧'}</div>`}
                                <span class="text-[11px] font-bold font-mono uppercase tracking-wide text-slate-400 dark:text-slate-500">${catMeta[cat]?.label||cat}</span>
                            </div>
                            <h3 class="font-black font-display text-lg mb-2 text-slate-900 dark:text-white group-hover:glow-text transition">${title}</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mb-6 flex-grow line-clamp-2 leading-relaxed">${desc}</p>
                            <a href="${t.tool_url}" target="_blank" class="btn btn-primary w-full justify-center">کردنەوە</a>
                        </div>`;
                });
            });
        }

        onValue(dbRef(db, 'ai_tools'), (snap) => { cache = snap.val() || {}; render(cache); });

        document.getElementById('upload-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const file = document.getElementById('tool_image_input').files[0];
            if (!file) return;
            const btn = document.getElementById('submit-form-btn');
            btn.disabled = true; btn.textContent = 'خەریکە...';
            try {
                const fd = new FormData(); fd.append('image', file);
                const res = await fetch(`https://api.imgbb.com/1/upload?key=${IMGBB_API_KEY}`, { method: 'POST', body: fd });
                const d = await res.json();
                if (d.success) {
                    await set(push(dbRef(db, 'ai_tools')), {
                        title_so: document.getElementById('title_so').value,
                        title_ba: document.getElementById('title_ba').value,
                        desc_so: document.getElementById('desc_so').value,
                        desc_ba: document.getElementById('desc_ba').value,
                        tool_url: document.getElementById('tool_url').value,
                        image_url: d.data.url,
                        category: document.getElementById('tool_category').value
                    });
                    alert('زیادکرا!');
                    document.getElementById('upload-form').reset();
                }
            } catch(e) { alert('هەڵە ڕوویدا'); }
            btn.disabled = false; btn.textContent = 'زیادکردنی تووڵ';
        });

        onAuthStateChanged(auth, (user) => {
            if(!user) window.location.href = "/login";
            else {
                document.getElementById('page-shell').style.display = 'block';
                if((user && user.email === "alphaaiteam@gmail.com")) document.getElementById('admin-section').classList.remove('hidden');
            }
        });
    </script>

</div>
@endsection
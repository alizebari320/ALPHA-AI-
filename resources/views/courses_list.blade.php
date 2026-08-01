@extends('layouts.app')

@section('title', 'کۆرسەکان — ALPHA/AI')

@section('content')
@include('partials.nav', ['active' => 'courses'])
<div id="page-shell" style="display:none">


    

    <div class="tech-glow w-72 h-72 bg-gold -top-20 right-1/3"></div>

    <header class="relative z-10 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 py-20 md:py-24 text-center relative">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-gold/40 bg-gold/10 text-amber-800 dark:text-gold text-xs font-bold mb-5">
                <span class="w-2 h-2 rounded-full bg-gold animate-pulse"></span>
                کۆرسی ڤیدیۆیی
            </div>
            <h1 class="text-4xl md:text-6xl font-black font-display tracking-tight mb-4 text-slate-900 dark:text-white">کۆرسەکانی <span class="glow-text">ئێمە</span></h1>
            <p class="text-lg text-slate-500 dark:text-slate-400 max-w-xl mx-auto">پەرە بە تواناکانت بدە لەگەڵ باشترین کۆرسەکانی ژیریی دەستکرد و پرۆگرامسازی</p>
        </div>
    </header>

    <section class="relative z-10 max-w-7xl mx-auto px-4 pb-12">
        <div class="flex flex-wrap items-center justify-center gap-3 mb-10">
            <button onclick="window.filterCourses('all')" class="filter-btn px-5 py-2.5 rounded-xl font-bold text-sm transition-all bg-gradient-to-r from-amber-400 to-amber-600 text-white shadow-lg shadow-amber-700/30" data-target="all">هەمووی</button>
            <button onclick="window.filterCourses('sorani')" class="filter-btn px-5 py-2.5 rounded-xl font-bold text-sm transition-all tech-card hover:-translate-y-0.5" data-target="sorani">سۆرانی</button>
            <button onclick="window.filterCourses('badini')" class="filter-btn px-5 py-2.5 rounded-xl font-bold text-sm transition-all tech-card hover:-translate-y-0.5" data-target="badini">بادینی</button>
            <button onclick="window.filterCourses('arabic')" class="filter-btn px-5 py-2.5 rounded-xl font-bold text-sm transition-all tech-card hover:-translate-y-0.5" data-target="arabic">عەرەبی</button>
            <button onclick="window.filterCourses('english')" class="filter-btn px-5 py-2.5 rounded-xl font-bold text-sm transition-all tech-card hover:-translate-y-0.5" data-target="english">ئینگلیزی</button>
        </div>

        <div id="courses-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto"></div>
    </section>

    <section class="admin-only hidden relative z-10 max-w-4xl mx-auto px-4 pb-24">
        <div class="card p-8 md:p-10 relative overflow-hidden">
            <div class="absolute top-0 right-0 left-0 h-1.5 bg-gradient-to-l from-amber-400 to-amber-600"></div>
            <div class="flex items-center justify-between mb-8 flex-wrap gap-3">
                <h3 class="font-mega text-3xl tracking-wide gold-text">زیادکردنی کۆرسی نوێ</h3>
                <span class="corner-tag">// ADMIN CONSOLE</span>
            </div>
            <form id="upload-form">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="tech-label">ناونیشان (سۆرانی)</label>
                        <input type="text" id="title_so" required class="tech-input">
                    </div>
                    <div>
                        <label class="tech-label">ناونیشان (بادینی)</label>
                        <input type="text" id="title_ba" required class="tech-input">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="tech-label">کورتە (سۆرانی)</label>
                        <textarea id="desc_so" required rows="4" class="tech-textarea resize-none"></textarea>
                    </div>
                    <div>
                        <label class="tech-label">کورتە (بادینی)</label>
                        <textarea id="desc_ba" required rows="4" class="tech-textarea resize-none"></textarea>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="tech-label">بەستەری ڤیدیۆ</label>
                        <input type="url" id="video_url" required dir="ltr" class="tech-input">
                    </div>
                    <div>
                        <label class="tech-label">نرخ بە دۆلار (بۆ خۆڕایی 0)</label>
                        <input type="number" id="price" required class="tech-input">
                    </div>
                </div>
                <div class="mb-6">
                    <label class="tech-label">هاوپۆلی زمانی کۆرس (بۆ فلتەرکردن)</label>
                    <select id="course_category" class="tech-select font-bold">
                        <option value="sorani">سۆرانی</option>
                        <option value="badini">بادینی</option>
                        <option value="arabic">عەرەبی</option>
                        <option value="english">ئینگلیزی</option>
                    </select>
                </div>
                <div class="mb-8">
                    <label class="tech-label">وێنەی کۆرس</label>
                    <div class="relative border-2 border-dashed border-slate-300 dark:border-white/15 rounded-xl p-4 hover:bg-gold/10 transition">
                        <input type="file" id="course_image_input" accept="image/*" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <p class="text-center text-sm font-bold text-slate-500 dark:text-slate-400 pointer-events-none">کلیک بکە یان وێنەکە ڕابکێشە بۆ ئێرە</p>
                    </div>
                </div>
                <button type="submit" id="submit-form-btn" class="w-full btn btn-primary justify-center !py-3 text-base">زیادکردنی کۆرس</button>
            </form>
        </div>
    </section>

    <div id="courseModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-slate-900/70 backdrop-blur-sm transition-opacity" onclick="window.closeCourseModal()"></div>
        <div class="card relative w-full max-w-2xl rounded-2xl p-6 md:p-8 shadow-2xl">
            <button onclick="window.closeCourseModal()" class="absolute top-4 left-4 p-2 bg-white/10 text-slate-400 hover:text-red-400 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="mt-2">
                <span id="modalBadge" class="inline-block bg-gradient-to-r from-gold/15 to-amber-600/15 text-amber-800 dark:text-gold text-xs font-black px-3 py-1 rounded-full mb-4 border border-gold/30">زمان</span>
                <h3 id="modalTitle" class="text-2xl font-black font-display mb-4 text-slate-900 dark:text-white">ناوی کۆرس</h3>
                <div class="max-h-[50vh] overflow-y-auto pl-2">
                    <p id="modalDesc" class="text-slate-600 dark:text-slate-300 leading-loose text-sm md:text-base">تەواوی زانیارییەکە لێرە دەردەکەوێت...</p>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-200/70 dark:border-white/10 text-left flex gap-3 justify-end">
                <button onclick="window.closeCourseModal()" class="btn btn-stone">داخستن</button>
            </div>
        </div>
    </div>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";
        import { getDatabase, ref as dbRef, push, set, remove, onValue } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";

        const firebaseConfig = { apiKey: "AIzaSyB-6_Ga6o3i3VYfjOX_UmKtI2qpsGHycJs", authDomain: "alphaai-d4f4c.firebaseapp.com", databaseURL: "https://alphaai-d4f4c-default-rtdb.firebaseio.com", projectId: "alphaai-d4f4c", storageBucket: "alphaai-d4f4c.firebasestorage.app", messagingSenderId: "518050080770", appId: "1:518050080770:web:c00d17cdbbbacb8ddd1f1b" };
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const db = getDatabase(app);
        const IMGBB_API_KEY = "947299981b43abca761315a1cd24c02a";

        let currentLang = localStorage.getItem('site-lang') || 'so';
        let firebaseDataCache = {};
        window.isAdmin = false;

        window.openCourseModal = function(title, desc, badgeTxt) {
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalDesc').innerText = desc;
            document.getElementById('modalBadge').innerText = badgeTxt;
            document.getElementById('courseModal').classList.remove('hidden');
        };

        window.closeCourseModal = function() { document.getElementById('courseModal').classList.add('hidden'); };

        window.filterCourses = function(lang) {
            const activeClasses = ['bg-gradient-to-r', 'from-amber-400', 'to-amber-600', 'text-white', 'shadow-lg', 'shadow-amber-700/30'];
            const inactiveClasses = ['tech-card'];
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove(...activeClasses, ...inactiveClasses);
                if (btn.getAttribute('data-target') === lang) btn.classList.add(...activeClasses);
                else btn.classList.add(...inactiveClasses);
            });
            const items = document.querySelectorAll('.course-item');
            items.forEach(item => {
                if (lang === 'all' || item.getAttribute('data-lang') === lang) { item.style.display = 'flex'; }
                else { item.style.display = 'none'; }
            });
        };

        window.deleteCourse = async function(id) {
            if(confirm('دڵنیایت؟')) { try { await remove(dbRef(db, 'courses/' + id)); alert('کۆرسەکە سڕایەوە'); } catch(e) { alert('هەڵەیەک ڕوویدا'); } }
        };

        function renderCourses(data) {
            const container = document.getElementById('courses-container');
            if (!container) return;
            container.innerHTML = "";
            if (!data || Object.keys(data).length === 0) {
                container.innerHTML = `<div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-20 tech-card"><p class="text-slate-500 dark:text-slate-400 font-bold">هێشتا هیچ کۆرسێک زیاد نەکراوە</p></div>`;
                return;
            }
            for (let id in data) {
                const c = data[id];
                const title = currentLang === 'ba' && c.title_ba ? c.title_ba : c.title_so || c.title;
                const desc = currentLang === 'ba' && c.desc_ba ? c.desc_ba : c.desc_so || c.description;
                const freeText = 'خۆڕایی';
                const seeMoreText = 'زیاتر ببینە';
                const priceBadge = c.price && c.price != 0 ? `$${c.price}` : freeText;
                let catText = 'سۆرانی';
                if(c.course_category === 'badini') catText = 'بادینی';
                if(c.course_category === 'arabic') catText = 'عەرەبی';
                if(c.course_category === 'english') catText = 'ئینگلیزی';
                const safeTitle = (title || "").replace(/"/g, '&quot;').replace(/'/g, "\\'");
                const safeDesc = (desc || "").replace(/"/g, '&quot;').replace(/'/g, "\\'");
                let adminButtonsHtml = '';
                if(window.isAdmin) {
                    adminButtonsHtml = `
                        <div class="flex items-center gap-2 pt-4 border-t border-stone-200 dark:border-stone-700 mt-4">
                            <button class="flex-1 flex justify-center items-center gap-2 py-2.5 bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400 hover:bg-amber-100 rounded-lg font-bold text-xs transition border border-amber-200 dark:border-amber-800/50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                دەستکاری
                            </button>
                            <button onclick="window.deleteCourse('${id}')" class="flex-1 flex justify-center items-center gap-2 py-2.5 bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400 hover:bg-red-100 rounded-lg font-bold text-xs transition border border-red-200 dark:border-red-800/50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                سڕینەوە
                            </button>
                        </div>`;
                }
                container.innerHTML += `
                    <div class="card overflow-hidden flex flex-col group course-item transition-all duration-300" data-lang="${c.course_category || 'sorani'}">
                        <div class="relative h-52 overflow-hidden bg-slate-200 dark:bg-slate-800">
                            <img src="${c.image_url}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-4 right-4 bg-gradient-to-r from-amber-400 to-amber-600 text-white text-xs font-black px-3 py-1.5 rounded-full shadow-lg shadow-amber-700/30">${catText}</div>
                            <div class="absolute top-4 left-4 bg-white/90 dark:bg-neutral-900/95 backdrop-blur text-slate-900 dark:text-white px-3 py-1.5 rounded-full font-black text-xs shadow border border-slate-200 dark:border-white/10">${priceBadge}</div>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="font-black font-display text-2xl mb-2 line-clamp-1 text-slate-900 dark:text-white">${title}</h3>
                            <p class="text-slate-500 dark:text-slate-400 text-sm mb-4 flex-grow line-clamp-3">${desc}</p>
                            <button onclick="window.openCourseModal('${safeTitle}', '${safeDesc}', '${catText}')" class="text-amber-800 dark:text-gold font-bold text-sm flex items-center gap-1 hover:text-amber-700 dark:hover:text-amber-700 transition w-max mb-4">
                                <span>${seeMoreText}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <a href="${c.video_url}" target="_blank" class="w-full btn btn-primary justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664zM21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                دەستپێکردن
                            </a>
                            ${adminButtonsHtml}
                        </div>
                    </div>`;
            }
        }

        onValue(dbRef(db, 'courses'), (snapshot) => {
            firebaseDataCache = snapshot.val() || {};
            renderCourses(firebaseDataCache);
        });

        let isUploading = false;
        document.getElementById('upload-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const file = document.getElementById('course_image_input').files[0];
            const submitBtn = document.getElementById('submit-form-btn');
            if(file && !isUploading) {
                isUploading = true;
                submitBtn.innerText = "خەریکە ئەپڵۆد دەکرێت..."; submitBtn.classList.add('opacity-70', 'cursor-wait');
                try {
                    const formData = new FormData(); formData.append("image", file);
                    const response = await fetch(`https://api.imgbb.com/1/upload?key=${IMGBB_API_KEY}`, { method: 'POST', body: formData });
                    const resData = await response.json();
                    if(resData.success) {
                        await set(push(dbRef(db, 'courses')), {
                            title_so: document.getElementById('title_so').value, title_ba: document.getElementById('title_ba').value,
                            desc_so: document.getElementById('desc_so').value, desc_ba: document.getElementById('desc_ba').value,
                            course_category: document.getElementById('course_category').value,
                            video_url: document.getElementById('video_url').value, price: document.getElementById('price').value,
                            image_url: resData.data.url
                        });
                        alert("بە سەرکەوتوویی زیادکرا!");
                        document.getElementById('upload-form').reset();
                    } else { throw new Error("Upload failed"); }
                } catch(error) { alert("نەتوانرا زیاد بکرێت"); }
                submitBtn.innerText = "زیادکردنی کۆرس"; submitBtn.classList.remove('opacity-70', 'cursor-wait');
                isUploading = false;
            }
        });

        onAuthStateChanged(auth, (user) => {
            if(!user) window.location.href = "/login";
            else {
                document.getElementById('page-shell').style.display = 'block';
                if((user && ["alphaaiteam@gmail.com"].includes(user.email))) {
                    window.isAdmin = true;
                    document.querySelectorAll('.admin-only').forEach(el => el.classList.remove('hidden'));
                    renderCourses(firebaseDataCache);
                }
            }
        });
    </script>

@include('partials.footer')
</div>
@endsection
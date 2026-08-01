@extends('layouts.app')

@section('title', 'ڕێنیشاندەری ئەکادیمی — ALPHA/AI')

@section('content')
@include('partials.nav', ['active' => 'guide'])
<div id="page-shell" style="display:none">


    

    <div class="tech-glow w-72 h-72 bg-gold -top-20 left-1/3"></div>

    <header class="relative z-10 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 py-16 md:py-20 text-center relative">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-gold/40 bg-gold/10 text-amber-800 dark:text-gold text-xs font-bold mb-5">
                <span class="w-2 h-2 rounded-full bg-gold animate-pulse"></span>
                ڕێنمایی قوتابیان
            </div>
            <h1 class="text-4xl md:text-6xl font-black font-display tracking-tight mb-4 text-slate-900 dark:text-white">ڕێنیشاندەری <span class="glow-text">ئەکادیمی</span></h1>
            <p class="text-lg text-slate-500 dark:text-slate-400 mb-8 max-w-xl mx-auto">هەموو ئەو زانیارییانەی پێویستتە بۆ سەرکەوتن لە پرۆسەی خوێندنت لێرە بدۆزەرەوە.</p>
            <div class="max-w-xl mx-auto relative">
                <input type="text" id="search-input" placeholder="گەڕان بەناو پرسیار و ڕێنیشاندەرەکاندا..." class="tech-input pr-11 pl-4 shadow-lg shadow-gold/5">
                <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
        </div>
    </header>

    <section class="relative z-10 max-w-4xl mx-auto px-4 pb-12">
        <div id="guide-container" class="space-y-4"></div>
    </section>

    <section class="admin-only hidden relative z-10 max-w-4xl mx-auto px-4 pb-24" id="admin-form-section">
        <div class="card p-8 md:p-10 relative overflow-hidden">
            <div class="absolute top-0 right-0 left-0 h-1.5 bg-gradient-to-l from-amber-400 to-amber-600"></div>
            <div class="flex items-center justify-between mb-8 flex-wrap gap-3">
                <h3 class="font-mega text-3xl tracking-wide gold-text">بەشی بەڕێوەبردنی ڕێنیشاندەر</h3>
                <span class="corner-tag">// ADMIN CONSOLE</span>
            </div>
            <form id="upload-form" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <input type="text" id="question_so" placeholder="پرسیار (سۆرانی)" required class="tech-input">
                    <input type="text" id="question_ba" placeholder="پرسیار (بادینی)" required class="tech-input">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <textarea id="answer_so" placeholder="وەڵام (سۆرانی)" required rows="5" class="tech-textarea"></textarea>
                    <textarea id="answer_ba" placeholder="وەڵام (بادینی)" required rows="5" class="tech-textarea"></textarea>
                </div>
                <button type="submit" id="submit-form-btn" class="w-full btn btn-primary justify-center !py-3 text-base">پاشەکەوتکردنی زانیارییەکان</button>
            </form>
        </div>
    </section>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";
        import { getDatabase, ref, push, set, onValue, remove, update } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";

        const firebaseConfig = { apiKey: "AIzaSyB-6_Ga6o3i3VYfjOX_UmKtI2qpsGHycJs", authDomain: "alphaai-d4f4c.firebaseapp.com", databaseURL: "https://alphaai-d4f4c-default-rtdb.firebaseio.com", projectId: "alphaai-d4f4c" };
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const db = getDatabase(app);

        let firebaseDataCache = {};
        let isAdmin = false;
        let editId = null;
        let currentLang = localStorage.getItem('site-lang') || 'so';
        let searchQuery = '';

        function renderGuide(data) {
            const container = document.getElementById('guide-container');
            if (!container) return;
            container.innerHTML = "";
            let hasItems = false;
            for (let id in data) {
                const item = data[id];
                const q = (currentLang === 'so' ? item.question_so : item.question_ba) || item.question_so;
                const a = (currentLang === 'so' ? item.answer_so : item.answer_ba) || item.answer_so;
                if (searchQuery && !q.toLowerCase().includes(searchQuery.toLowerCase()) && !a.toLowerCase().includes(searchQuery.toLowerCase())) continue;
                hasItems = true;
                container.innerHTML += `
                    <div class="card overflow-hidden border-s-4 border-s-gold">
                        <button onclick="window.toggleAccordion('${id}')" class="w-full p-6 text-right flex justify-between items-center gap-4 focus:outline-none">
                            <h3 class="font-black font-display text-xl md:text-2xl text-slate-900 dark:text-white">${q}</h3>
                            <div class="w-8 h-8 rounded-lg bg-gold/10 text-amber-800 dark:text-gold flex items-center justify-center shrink-0 transition-transform duration-300" id="icon-${id}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </button>
                        <div id="content-${id}" class="hidden px-6 pb-6 pt-2 border-t border-slate-200/70 dark:border-white/10">
                            <p class="text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-line">${a}</p>
                            ${isAdmin ? `
                                <div class="mt-6 flex gap-4 pt-4 border-t border-slate-200/70 dark:border-white/10">
                                    <button onclick="window.editGuide('${id}')" class="btn btn-amber !py-2">دەستکاری</button>
                                    <button onclick="window.deleteGuide('${id}')" class="btn !py-2 bg-red-500/10 text-red-500 border border-red-500/30 hover:bg-red-500/20">سڕینەوە</button>
                                </div>` : ''}
                        </div>
                    </div>`;
            }
            if (!hasItems) {
                container.innerHTML = `<div class="card p-12 text-center"><p class="text-slate-500 dark:text-slate-400 font-bold">هیچ زانیارییەک نەدۆزراوەتەوە.</p></div>`;
            }
        }

        window.toggleAccordion = (id) => {
            const content = document.getElementById(`content-${id}`);
            const icon = document.getElementById(`icon-${id}`);
            content.classList.toggle('hidden');
            icon.style.transform = content.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
        };

        window.deleteGuide = async (id) => { if(confirm("دڵنیایت؟")) await remove(ref(db, 'academic_guide/' + id)); };

        window.editGuide = (id) => {
            const item = firebaseDataCache[id];
            document.getElementById('question_so').value = item.question_so || '';
            document.getElementById('question_ba').value = item.question_ba || '';
            document.getElementById('answer_so').value = item.answer_so || '';
            document.getElementById('answer_ba').value = item.answer_ba || '';
            editId = id;
            document.getElementById('submit-form-btn').innerText = "نوێکردنەوەی زانیارییەکان";
            window.scrollTo({ top: document.getElementById('admin-form-section').offsetTop - 50, behavior: 'smooth' });
        };

        document.getElementById('search-input').addEventListener('input', (e) => {
            searchQuery = e.target.value;
            renderGuide(firebaseDataCache);
        });

        onValue(ref(db, 'academic_guide'), (s) => { firebaseDataCache = s.val() || {}; renderGuide(firebaseDataCache); });

        document.getElementById('upload-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const data = {
                question_so: document.getElementById('question_so').value,
                question_ba: document.getElementById('question_ba').value,
                answer_so: document.getElementById('answer_so').value,
                answer_ba: document.getElementById('answer_ba').value
            };
            if(editId) { await update(ref(db, 'academic_guide/' + editId), data); editId = null; document.getElementById('submit-form-btn').innerText = "پاشەکەوتکردنی زانیارییەکان"; }
            else { await push(ref(db, 'academic_guide'), data); }
            e.target.reset();
            alert("بە سەرکەوتوویی جێبەجێکرا!");
        });

        onAuthStateChanged(auth, (user) => {
            if(!user) window.location.href = "/login";
            document.getElementById('page-shell').style.display = 'block';
            if((user && ["alphaaiteam@gmail.com"].includes(user.email))) {
                isAdmin = true;
                document.querySelector('.admin-only').classList.remove('hidden');
            }
            renderGuide(firebaseDataCache);
        });
    </script>

@include('partials.footer')
</div>
@endsection
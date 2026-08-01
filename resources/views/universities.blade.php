@extends('layouts.app')

@section('title', 'زانکۆکان — ALPHA/AI')

@section('content')
@include('partials.nav', ['active' => 'universities'])
<div id="page-shell" style="display:none">

<style>
        details > summary { list-style: none; cursor: pointer; }
        details > summary::-webkit-details-marker { display: none; }
    </style>


    

    <div class="tech-glow w-72 h-72 bg-amber-600 -top-20 left-1/3"></div>

    <header class="relative z-10 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 py-16 md:py-20 text-center relative">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-gold/40 bg-gold/10 text-amber-800 dark:text-gold text-xs font-bold mb-5">
                <span class="w-2 h-2 rounded-full bg-gold animate-pulse"></span>
                خوێندنی باڵا
            </div>
            <h1 class="text-4xl md:text-6xl font-black font-display tracking-tight mb-4 text-slate-900 dark:text-white">زانکۆکانی <span class="glow-text">زیرەکی دەستکرد</span></h1>
            <p class="text-lg text-slate-500 dark:text-slate-400">بەدوای ئەو زانکۆیانەدا بگەڕێ کە بەشی ژیریی دەستکردیان هەیە</p>
        </div>
    </header>

    <section class="relative z-10 max-w-7xl mx-auto px-4 pb-12">
        <div id="uni-container" class="columns-1 md:columns-2 gap-8"></div>
    </section>

    <section class="admin-only hidden relative z-10 max-w-5xl mx-auto px-4 pb-24" id="admin-form-section">
        <div class="card p-8 md:p-10 relative overflow-hidden">
            <div class="absolute top-0 right-0 left-0 h-1.5 bg-gradient-to-l from-amber-400 to-amber-600"></div>
            <div class="flex items-center justify-between mb-8 flex-wrap gap-3">
                <h3 class="font-mega text-3xl tracking-wide gold-text">دەستکاریکردنی زانکۆکان</h3>
                <span class="corner-tag">// ADMIN CONSOLE</span>
            </div>

            <div class="flex flex-wrap gap-3 mb-8 border-b border-slate-200/70 dark:border-white/10 pb-6">
                <button id="tab-btn-uni" onclick="switchAdminTab('uni')" class="btn btn-primary">1. زانکۆ</button>
                <button id="tab-btn-subject" onclick="switchAdminTab('subject')" class="btn btn-stone">2. خشتەی وانەکان</button>
                <button id="tab-btn-manage" onclick="switchAdminTab('manage')" class="btn btn-stone">3. بەڕێوەبردن</button>
            </div>

            <form id="form-uni" class="admin-form">
                <input type="hidden" id="edit_uni_id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="tech-label">ناوی زانکۆ (سۆرانی)</label>
                        <input type="text" id="uni_name_so" required class="tech-input">
                    </div>
                    <div>
                        <label class="tech-label">ناوی زانکۆ (بادینی)</label>
                        <input type="text" id="uni_name_ba" required class="tech-input">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="tech-label">جۆری بڕوانامە (سۆرانی)</label>
                        <input type="text" id="uni_degree_so" required class="tech-input">
                    </div>
                    <div>
                        <label class="tech-label">جۆری بڕوانامە (بادینی)</label>
                        <input type="text" id="uni_degree_ba" required class="tech-input">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="tech-label">کورتەیەک (سۆرانی)</label>
                        <textarea id="uni_desc_so" required rows="4" class="tech-textarea resize-none"></textarea>
                    </div>
                    <div>
                        <label class="tech-label">کورتەیەک (بادینی)</label>
                        <textarea id="uni_desc_ba" required rows="4" class="tech-textarea resize-none"></textarea>
                    </div>
                </div>
                <div class="mb-8">
                    <label class="tech-label">لۆگۆی زانکۆ</label>
                    <div class="relative border-2 border-dashed border-slate-300 dark:border-white/15 rounded-xl p-4 hover:bg-gold/10 transition">
                        <input type="file" id="uni_logo_file" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <p class="text-center text-sm text-slate-500 dark:text-slate-400 pointer-events-none">کلیک بکە بۆ هەڵبژاردنی وێنە</p>
                    </div>
                </div>
                <button type="submit" id="btn-submit-uni" class="w-full btn btn-primary justify-center !py-3 text-base">سەیڤکردنی زانکۆ</button>
            </form>

            <form id="form-subject" class="admin-form hidden">
                <div class="mb-6">
                    <label class="tech-label !text-base">یەکەمجار زانکۆکە هەڵبژێرە:</label>
                    <select id="subject_uni_select" required class="tech-select font-bold cursor-pointer">
                    </select>
                </div>
                <div class="bg-gold/10 border border-gold/20 rounded-xl p-4 mb-6 flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-700 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm text-amber-800 dark:text-gold">وێنەی خشتەی وانەکانی هەر سمستەرێک ئەپڵۆد بکە. ئەو سمستەرانەی پێشتر وێنەیان بۆ دانراوە بە <span class="text-amber-800 dark:text-gold font-bold">شینی</span> دیاری کراون.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 border border-slate-200/70 dark:border-white/10 rounded-xl bg-slate-50/70 dark:bg-white/[.03]">
                    <div class="space-y-4">
                        <h4 class="font-black font-display text-lg flex items-center gap-2 text-slate-900 dark:text-white"><span class="w-7 h-7 rounded bg-gradient-to-br from-amber-400 to-amber-600 text-white flex items-center justify-center text-sm">١</span> قۆناغی یەکەم</h4>
                        <div><label id="sem1_label" class="tech-label">سمستەری ١</label><input type="file" id="sem1_file" accept="image/*" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gold/10 file:text-amber-800 dark:file:text-amber-700 hover:file:bg-gold/20 cursor-pointer"></div>
                        <div><label id="sem2_label" class="tech-label">سمستەری ٢</label><input type="file" id="sem2_file" accept="image/*" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gold/10 file:text-amber-800 dark:file:text-amber-700 hover:file:bg-gold/20 cursor-pointer"></div>
                    </div>
                    <div class="space-y-4">
                        <h4 class="font-black font-display text-lg flex items-center gap-2 text-slate-900 dark:text-white"><span class="w-7 h-7 rounded bg-gradient-to-br from-amber-400 to-amber-600 text-white flex items-center justify-center text-sm">٢</span> قۆناغی دووەم</h4>
                        <div><label id="sem3_label" class="tech-label">سمستەری ٣</label><input type="file" id="sem3_file" accept="image/*" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gold/10 file:text-amber-800 dark:file:text-amber-700 hover:file:bg-gold/20 cursor-pointer"></div>
                        <div><label id="sem4_label" class="tech-label">سمستەری ٤</label><input type="file" id="sem4_file" accept="image/*" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gold/10 file:text-amber-800 dark:file:text-amber-700 hover:file:bg-gold/20 cursor-pointer"></div>
                    </div>
                    <div class="space-y-4">
                        <h4 class="font-black font-display text-lg flex items-center gap-2 text-slate-900 dark:text-white"><span class="w-7 h-7 rounded bg-gradient-to-br from-amber-400 to-amber-600 text-white flex items-center justify-center text-sm">٣</span> قۆناغی سێیەم</h4>
                        <div><label id="sem5_label" class="tech-label">سمستەری ٥</label><input type="file" id="sem5_file" accept="image/*" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gold/10 file:text-amber-800 dark:file:text-amber-700 hover:file:bg-gold/20 cursor-pointer"></div>
                        <div><label id="sem6_label" class="tech-label">سمستەری ٦</label><input type="file" id="sem6_file" accept="image/*" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gold/10 file:text-amber-800 dark:file:text-amber-700 hover:file:bg-gold/20 cursor-pointer"></div>
                    </div>
                    <div class="space-y-4">
                        <h4 class="font-black font-display text-lg flex items-center gap-2 text-slate-900 dark:text-white"><span class="w-7 h-7 rounded bg-gradient-to-br from-amber-400 to-amber-600 text-white flex items-center justify-center text-sm">٤</span> قۆناغی چوارەم</h4>
                        <div><label id="sem7_label" class="tech-label">سمستەری ٧</label><input type="file" id="sem7_file" accept="image/*" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gold/10 file:text-amber-800 dark:file:text-amber-700 hover:file:bg-gold/20 cursor-pointer"></div>
                        <div><label id="sem8_label" class="tech-label">سمستەری ٨</label><input type="file" id="sem8_file" accept="image/*" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gold/10 file:text-amber-800 dark:file:text-amber-700 hover:file:bg-gold/20 cursor-pointer"></div>
                    </div>
                </div>
                <button type="submit" id="btn-submit-subject" class="w-full btn btn-primary justify-center !py-3 text-base mt-6">سەیڤکردنی خشتە بۆ ئەم زانکۆیە</button>
            </form>

            <div id="form-manage" class="admin-form hidden">
                <div id="manage-list" class="space-y-4 max-h-[500px] overflow-y-auto pl-2 pb-2"></div>
            </div>
        </div>
    </section>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";
        import { getDatabase, ref as dbRef, push, set, update, remove, onValue } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";

        const firebaseConfig = { apiKey: "AIzaSyB-6_Ga6o3i3VYfjOX_UmKtI2qpsGHycJs", authDomain: "alphaai-d4f4c.firebaseapp.com", databaseURL: "https://alphaai-d4f4c-default-rtdb.firebaseio.com", projectId: "alphaai-d4f4c" };
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const db = getDatabase(app);
        const IMGBB_API_KEY = "947299981b43abca761315a1cd24c02a";

        let currentLang = localStorage.getItem('site-lang') || 'so';
        let unisData = {};

        const loc = (obj, key) => currentLang === 'ba' && obj[key + '_ba'] ? obj[key + '_ba'] : obj[key + '_so'] || obj[key];

        onValue(dbRef(db, 'universities'), (s) => { unisData = s.val() || {}; renderUniversities(); updateAdminSelects(); renderManageList(); });

        function renderUniversities() {
            const container = document.getElementById('uni-container');
            if(!container) return;
            container.innerHTML = '';
            if (Object.keys(unisData).length === 0) {
                container.innerHTML = `<div class="text-center py-20 tech-card break-inside-avoid"><p class="text-slate-500 dark:text-slate-400 font-bold">هیچ زانکۆیەک نەدۆزرایەوە</p></div>`;
                return;
            }
            const langDict = {
                planTitle: 'خشتەی وانەکان بکەرەوە', notExist: 'بوونی نییە',
                stage1: 'قۆناغی یەکەم', stage2: 'قۆناغی دووەم', stage3: 'قۆناغی سێیەم', stage4: 'قۆناغی چوارەم',
                semPrefix: 'سمستەری'
            };
            for (let id in unisData) {
                const u = unisData[id];
                const name = loc(u, 'name');
                const degree = loc(u, 'degree');
                const desc = loc(u, 'desc');
                const renderStage = (img1, img2, stageName, sem1Num, sem2Num) => {
                    if (!img1 && !img2) return `<div class="border-b border-slate-200/70 dark:border-white/10 pb-4"><h5 class="font-black mb-2 flex items-center gap-2 text-slate-900 dark:text-white"><span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>${stageName}</h5><p class="text-slate-400 text-sm pr-4">${langDict.notExist}</p></div>`;
                    return `
                        <div class="border-b border-slate-200/70 dark:border-white/10 pb-6 last:border-0 last:pb-0">
                            <h5 class="font-black font-display text-lg mb-4 flex items-center gap-2 text-slate-900 dark:text-white"><span class="w-2 h-2 rounded-full bg-gold"></span>${stageName}</h5>
                            <div class="grid grid-cols-1 gap-4 pr-4 border-r-2 border-gold/40 dark:border-gold/30">
                                ${img1 ? `<div class="bg-white/70 dark:bg-white/[.04] rounded-xl p-3 border border-slate-200/70 dark:border-white/10"><p class="mb-2 text-sm font-black text-amber-800 dark:text-gold bg-gold/10 inline-block px-3 py-1 rounded">${langDict.semPrefix} ${sem1Num}</p><img src="${img1}" class="w-full h-auto rounded object-contain max-h-96 cursor-pointer hover:opacity-90 transition-opacity"></div>` : ''}
                                ${img2 ? `<div class="bg-white/70 dark:bg-white/[.04] rounded-xl p-3 border border-slate-200/70 dark:border-white/10"><p class="mb-2 text-sm font-black text-amber-800 dark:text-gold bg-gold/10 inline-block px-3 py-1 rounded">${langDict.semPrefix} ${sem2Num}</p><img src="${img2}" class="w-full h-auto rounded object-contain max-h-96 cursor-pointer hover:opacity-90 transition-opacity"></div>` : ''}
                            </div>
                        </div>`;
                };
                container.innerHTML += `
                    <div class="card p-6 md:p-8 flex flex-col break-inside-avoid mb-8 w-full inline-block">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-20 h-20 rounded-xl overflow-hidden bg-white dark:bg-white/[.04] flex-shrink-0 flex items-center justify-center p-2 shadow border border-slate-200/70 dark:border-white/10">
                                <img src="${u.logo_url || 'https://i.ibb.co/placeholder.png'}" class="w-full h-full object-contain">
                            </div>
                            <div>
                                <h3 class="font-black font-display text-xl md:text-2xl mb-1 text-slate-900 dark:text-white">${name}</h3>
                                <span class="inline-block bg-gradient-to-r from-gold/15 to-amber-600/15 text-amber-800 dark:text-gold font-bold px-3 py-1 rounded text-sm border border-gold/30">${degree}</span>
                            </div>
                        </div>
                        <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">${desc}</p>
                        <details class="group mt-6">
                            <summary class="flex justify-between items-center font-bold p-4 text-amber-800 dark:text-gold bg-gold/10 border border-gold/25 rounded-xl hover:border-gold/50 transition cursor-pointer">
                                <span>${langDict.planTitle}</span>
                                <span class="transition-transform duration-300 group-open:rotate-180 bg-white/80 dark:bg-white/[.06] rounded-full p-1 shadow-sm">
                                    <svg fill="none" height="20" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="20"><polyline points="6 9 12 15 18 9"/></svg>
                                </span>
                            </summary>
                            <div class="p-4 mt-2 bg-slate-50/70 dark:bg-white/[.03] rounded-xl border border-slate-200/70 dark:border-white/10 space-y-4">
                                ${renderStage(u.sem1, u.sem2, langDict.stage1, '١', '٢')}
                                ${renderStage(u.sem3, u.sem4, langDict.stage2, '٣', '٤')}
                                ${renderStage(u.sem5, u.sem6, langDict.stage3, '٥', '٦')}
                                ${renderStage(u.sem7, u.sem8, langDict.stage4, '٧', '٨')}
                            </div>
                        </details>
                    </div>`;
            }
        }

        const tabs = ['uni', 'subject', 'manage'];
        window.switchAdminTab = function(tabName) {
            tabs.forEach(x => {
                const btn = document.getElementById(`tab-btn-${x}`);
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-stone');
                document.getElementById(`form-${x}`)?.classList.add('hidden');
            });
            const activeBtn = document.getElementById(`tab-btn-${tabName}`);
            activeBtn.classList.remove('btn-stone');
            activeBtn.classList.add('btn-primary');
            document.getElementById(`form-${tabName}`)?.classList.remove('hidden');
            if(tabName === 'uni') { document.getElementById(`form-uni`).reset(); document.getElementById(`edit_uni_id`).value = ''; document.getElementById(`btn-submit-uni`).innerText = 'سەیڤکردنی زانکۆ'; }
        };

        function updateAdminSelects() {
            const select = document.getElementById('subject_uni_select');
            select.innerHTML = '<option value="">-- هەڵبژێرە --</option>';
            for (let id in unisData) select.innerHTML += `<option value="${id}">${unisData[id].name_so || '?'}</option>`;
        }

        document.getElementById('subject_uni_select').addEventListener('change', (e) => {
            const id = e.target.value;
            for(let i=1; i<=8; i++) {
                const label = document.getElementById(`sem${i}_label`);
                if (id && unisData[id] && unisData[id][`sem${i}`]) {
                    label.innerHTML = `سمستەری ${i} <span class="bg-gold/10 text-amber-800 dark:text-gold px-2 py-0.5 rounded text-xs mr-2 font-black inline-flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg> وێنە دانراوە</span>`;
                } else { label.innerHTML = `سمستەری ${i}`; }
            }
        });

        async function uploadImage(file) {
            const formData = new FormData(); formData.append("image", file);
            const res = await fetch(`https://api.imgbb.com/1/upload?key=${IMGBB_API_KEY}`, { method: 'POST', body: formData });
            return (await res.json()).data.url;
        }

        document.getElementById('form-uni').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('btn-submit-uni'); btn.disabled = true; btn.innerText = "خەریکە..."; btn.classList.add('opacity-70', 'cursor-wait');
            const editId = document.getElementById('edit_uni_id').value;
            try {
                let logoUrl = editId && unisData[editId] ? unisData[editId].logo_url : '';
                const file = document.getElementById('uni_logo_file').files[0];
                if(file) logoUrl = await uploadImage(file);
                const data = { name_so: document.getElementById('uni_name_so').value, name_ba: document.getElementById('uni_name_ba').value, degree_so: document.getElementById('uni_degree_so').value, degree_ba: document.getElementById('uni_degree_ba').value, desc_so: document.getElementById('uni_desc_so').value, desc_ba: document.getElementById('uni_desc_ba').value, logo_url: logoUrl };
                if(editId) await update(dbRef(db, 'universities/' + editId), data);
                else await set(push(dbRef(db, 'universities')), data);
                alert("بە سەرکەوتوویی جێبەجێکرا!"); e.target.reset(); document.getElementById('edit_uni_id').value = '';
            } catch(err) { alert("هەڵە ڕوویدا"); }
            btn.disabled = false; btn.innerText = "سەیڤکردنی زانکۆ"; btn.classList.remove('opacity-70', 'cursor-wait');
            switchAdminTab('manage');
        });

        document.getElementById('form-subject').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('subject_uni_select').value;
            if(!id) return alert('تکایە سەرەتا زانکۆیەک هەڵبژێرە');
            const btn = document.getElementById('btn-submit-subject'); btn.disabled = true; btn.innerText = "خەریکە..."; btn.classList.add('opacity-70', 'cursor-wait');
            try {
                const data = {};
                for(let i=1; i<=8; i++) {
                    const fileInput = document.getElementById(`sem${i}_file`);
                    if(fileInput.files.length > 0) data[`sem${i}`] = await uploadImage(fileInput.files[0]);
                }
                if (Object.keys(data).length > 0) { await update(dbRef(db, 'universities/' + id), data); alert("خشتەی وانەکان نوێکرایەوە!"); }
                else { alert("هیچ وێنەیەکی نوێ هەڵنەبژێردراوە."); }
                for(let i=1; i<=8; i++) document.getElementById(`sem${i}_file`).value = '';
            } catch(err) { alert("هەڵە ڕوویدا"); }
            btn.disabled = false; btn.innerText = "سەیڤکردنی خشتە بۆ ئەم زانکۆیە"; btn.classList.remove('opacity-70', 'cursor-wait');
        });

        window.renderManageList = function() {
            const listObj = document.getElementById('manage-list');
            listObj.innerHTML = '';
            for(let id in unisData) {
                const item = unisData[id];
                listObj.innerHTML += `
                    <div class="flex justify-between items-center bg-white/70 dark:bg-white/[.04] p-4 rounded-xl border border-slate-200/70 dark:border-white/10">
                        <div class="flex items-center gap-3">
                            <img src="${item.logo_url || 'https://i.ibb.co/placeholder.png'}" class="w-10 h-10 rounded object-contain border border-slate-200/70 dark:border-white/10 bg-white p-1">
                            <div><span class="block font-black text-slate-900 dark:text-white">${item.name_so || item.name_ba}</span><span class="text-xs font-bold text-slate-400">${item.degree_so || ''}</span></div>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="editUni('${id}')" class="bg-gold/10 text-amber-800 dark:text-gold px-3 py-2 rounded-lg text-sm hover:bg-gold/20 font-bold transition">دەستکاری</button>
                            <button onclick="deleteUni('${id}')" class="bg-red-500/10 text-red-500 px-3 py-2 rounded-lg text-sm hover:bg-red-500/20 font-bold transition">سڕینەوە</button>
                        </div>
                    </div>`;
            }
        };

        window.deleteUni = async function(id) { if(confirm('دڵنیایت؟')) { await remove(dbRef(db, `universities/${id}`)); alert('سڕایەوە'); } };

        window.editUni = function(id) {
            const d = unisData[id];
            document.getElementById('edit_uni_id').value = id;
            document.getElementById('uni_name_so').value = d.name_so || ''; document.getElementById('uni_name_ba').value = d.name_ba || '';
            document.getElementById('uni_degree_so').value = d.degree_so || ''; document.getElementById('uni_degree_ba').value = d.degree_ba || '';
            document.getElementById('uni_desc_so').value = d.desc_so || ''; document.getElementById('uni_desc_ba').value = d.desc_ba || '';
            document.getElementById('btn-submit-uni').innerText = "نوێکردنەوەی زانکۆ";
            switchAdminTab('uni');
        };

        onAuthStateChanged(auth, (user) => {
            if(!user) window.location.href = "/login";
            else {
                document.getElementById('page-shell').style.display = 'block';
                if((user && ["alphaaiteam@gmail.com"].includes(user.email))) { document.querySelector('.admin-only').classList.remove('hidden'); }
            }
        });
    </script>

@include('partials.footer')
</div>
@endsection
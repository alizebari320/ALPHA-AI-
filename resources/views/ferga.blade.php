@extends('layouts.app')

@section('title', 'فێرگە — ALPHA/AI')

@section('content')
@include('partials.nav', ['active' => 'ferga'])
<div id="page-shell" style="display:none">

<script src="https://cdn.jsdelivr.net/pyodide/v0.23.4/full/pyodide.js"></script>

<script src="https://cdn.jsdelivr.net/npm/skulpt@1.2.0/dist/skulpt.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/skulpt@1.2.0/dist/skulpt-stdlib.js"></script>


    

    <div class="tech-glow w-72 h-72 bg-gold -top-20 right-1/4"></div>

    <!-- HOME VIEW -->
    <div id="home-view" class="relative z-10">
        <header class="relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 py-16 md:py-20 relative">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-gold/40 bg-gold/10 text-amber-800 dark:text-gold text-xs font-bold mb-5">
                    <span class="w-2 h-2 rounded-full bg-gold animate-pulse"></span>
                    سەکۆی فێربوون
                </div>
                <h1 class="text-4xl md:text-6xl font-black font-display text-slate-900 dark:text-white mb-3">فێرگە</h1>
                <p class="text-slate-500 dark:text-slate-400 text-lg">زمانێکی پرۆگرامسازی هەڵبژێرە و دەستبکە بە فێربوون</p>
            </div>
        </header>
        <section class="max-w-7xl mx-auto px-4 py-10">
            <div id="languages-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"></div>
        </section>
    </div>

    <!-- LEARNING VIEW -->
    <div id="learning-view" class="hidden relative z-10" style="height:calc(100vh - 57px)">
        <div class="flex h-full">
            <aside class="w-80 bg-white/80 dark:bg-neutral-900/95 border-l border-slate-200/70 dark:border-white/10 overflow-y-auto p-4 flex-shrink-0 hidden md:block backdrop-blur-xl">
                <button onclick="goBackToHome()" class="btn btn-stone w-full mb-4 justify-center">&larr; گەڕانەوە</button>
                <div id="sidebar-content"></div>
            </aside>
            <main class="flex-1 flex flex-col overflow-y-auto">
                <div class="flex-1 p-6 md:p-10 overflow-y-auto">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h2 id="display-title" class="text-2xl md:text-3xl font-black font-display text-slate-900 dark:text-white"></h2>
                            <p class="text-xs text-slate-400 mt-1 font-mono"><span id="code-filename-label">main.py</span> &middot; دەتوانیت کۆدەکە تاقیبکەیتەوە</p>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="openTryItYourself()" class="btn btn-amber">تاقیکردنەوە</button>
                        </div>
                    </div>
                    <div id="display-content" class="text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-wrap"></div>
                </div>
                <div id="display-code-box" class="hidden border-t border-slate-200/70 dark:border-white/10">
                    <div class="bg-[#0a0e17] text-slate-400 text-xs px-6 py-2 font-mono flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-gold/80"></span>
                        نمونەی کۆد
                    </div>
                    <pre id="display-code" class="code-block text-amber-300 font-mono text-sm p-6 overflow-x-auto" dir="ltr"></pre>
                </div>
                <div class="border-t border-slate-200/70 dark:border-white/10 bg-white/70 dark:bg-neutral-900/90 px-6 py-4 flex justify-between backdrop-blur-xl">
                    <button id="btn-prev" class="btn btn-stone" disabled>&larr; پێشتر</button>
                    <button id="btn-action" class="btn btn-primary" onclick="handleNextAction()">تەواوکردنی وانە ✓</button>
                </div>
            </main>
        </div>
    </div>

    <!-- COMPILER MODAL -->
    <div id="compiler-modal" class="hidden fixed inset-0 z-[100] bg-slate-900/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="card w-full max-w-4xl max-h-[90vh] flex flex-col overflow-hidden">
            <div class="flex justify-between items-center p-4 border-b border-slate-200/70 dark:border-white/10">
                <h3 class="font-black font-display text-slate-900 dark:text-white">سەکۆی کۆدکردن</h3>
                <button onclick="closeTryItYourself()" class="text-slate-400 hover:text-red-500 text-xl transition">&times;</button>
            </div>
            <div class="flex-1 p-4">
                <textarea id="user-code" class="w-full h-64 code-block text-amber-300 font-mono text-sm p-4 rounded-lg border border-white/10 focus:outline-none focus:border-gold/60 resize-none" dir="ltr"></textarea>
            </div>
            <div class="flex gap-3 px-4 pb-4">
                <button onclick="runCode()" class="btn btn-primary">جێبەجێکردن</button>
                <button onclick="closeTryItYourself()" class="btn btn-stone">داخستن</button>
            </div>
            <div class="border-t border-slate-200/70 dark:border-white/10">
                <div class="bg-[#0a0e17] text-slate-400 text-xs px-4 py-2 font-mono">دەرکەوتن</div>
                <pre id="code-output" class="code-block text-amber-300 font-mono text-sm p-4 overflow-y-auto max-h-40" dir="ltr">ئامادەیە...</pre>
            </div>
        </div>
    </div>

    <!-- QUIZ MODAL -->
    <div id="quiz-modal" class="hidden fixed inset-0 z-[120] bg-slate-900/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="card w-full max-w-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-black font-display text-lg text-slate-900 dark:text-white">تاقیکردنەوە</h3>
                <span id="quiz-counter" class="text-sm font-bold text-amber-800 dark:text-gold"></span>
            </div>
            <div id="quiz-content">
                <h4 id="quiz-question-text" class="font-bold mb-4 text-lg text-slate-900 dark:text-white"></h4>
                <div id="quiz-options" class="space-y-3"></div>
            </div>
            <div id="quiz-result" class="hidden text-center py-6">
                <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-amber-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-amber-700/40">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h4 class="font-black text-xl mb-2 text-slate-900 dark:text-white">ئافەرین!</h4>
                <p id="quiz-score-text" class="text-slate-500 dark:text-slate-400 mb-6"></p>
                <button onclick="finishQuizAndContinue()" class="btn btn-primary w-full justify-center">بەردەوامبە</button>
            </div>
            <div id="quiz-footer" class="mt-6 flex justify-end">
                <button id="btn-next-question" class="btn btn-stone opacity-50 cursor-not-allowed" disabled>دواتر</button>
            </div>
        </div>
    </div>

    <!-- ADMIN PANEL -->
    <div id="admin-section" class="hidden relative z-10 max-w-7xl mx-auto px-4 pb-12">
        <div class="card p-6 mt-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 left-0 h-1.5 bg-gradient-to-l from-amber-400 to-amber-600"></div>
            <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
                <h2 class="font-mega text-3xl tracking-wide gold-text">بەڕێوەبردنی فێرگە</h2>
                <span class="corner-tag">// ADMIN CONSOLE</span>
            </div>
            <div class="flex gap-2 mb-6 flex-wrap">
                <button onclick="switchAdminTab('lang')" class="btn btn-stone">زمان</button>
                <button onclick="switchAdminTab('lesson')" class="btn btn-stone">وانە</button>
                <button onclick="switchAdminTab('quiz')" class="btn btn-stone">پرسیار</button>
                <button onclick="switchAdminTab('manage')" class="btn btn-stone">بەڕێوەبردن</button>
            </div>

            <form id="form-lang" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="hidden" id="edit_lang_id">
                <input id="lang_name_so" placeholder="ناوی زمان (سۆرانی)" class="tech-input">
                <input id="lang_name_ba" placeholder="ناوی زمان (بادینی)" class="tech-input">
                <textarea id="lang_desc_so" placeholder="وەسف (سۆرانی)" rows="2" class="tech-textarea"></textarea>
                <textarea id="lang_desc_ba" placeholder="وەسف (بادینی)" rows="2" class="tech-textarea"></textarea>
                <input id="lang_color" placeholder="ڕەنگ (مثال: bg-blue-100)" class="tech-input">
                <input id="lang_logo_file" type="file" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-gold/10 file:text-amber-800 dark:file:text-amber-700">
                <div class="md:col-span-2"><button type="submit" id="btn-submit-lang" class="btn btn-primary w-full justify-center">سەیڤکردن</button></div>
            </form>

            <form id="form-lesson" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="hidden" id="edit_lesson_id">
                <select id="lesson_lang_select" class="tech-select"><option value="">-- زمان --</option></select>
                <input id="lesson_level_so" placeholder="ئاست (سۆرانی)" class="tech-input">
                <input id="lesson_level_ba" placeholder="ئاست (بادینی)" class="tech-input">
                <input id="lesson_title_so" placeholder="ناونیشان (سۆرانی)" class="tech-input">
                <input id="lesson_title_ba" placeholder="ناونیشان (بادینی)" class="tech-input">
                <textarea id="lesson_content_so" placeholder="ناوەڕۆک (سۆرانی)" rows="4" class="tech-textarea md:col-span-2"></textarea>
                <textarea id="lesson_content_ba" placeholder="ناوەڕۆک (بادینی)" rows="4" class="tech-textarea md:col-span-2"></textarea>
                <textarea id="lesson_code" placeholder="کۆد (ئارەزوومەندانە)" rows="5" class="code-block text-amber-300 font-mono text-sm border border-white/10 rounded-lg md:col-span-2 p-4" dir="ltr"></textarea>
                <div class="md:col-span-2"><button type="submit" id="btn-submit-lesson" class="btn btn-primary w-full justify-center">سەیڤکردن</button></div>
            </form>

            <form id="form-quiz" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="hidden" id="edit_quiz_id">
                <select id="quiz_lesson_select" class="tech-select"><option value="">-- وانە --</option></select>
                <input id="quiz_question_so" placeholder="پرسیار (سۆرانی)" class="tech-input">
                <input id="quiz_question_ba" placeholder="پرسیار (بادینی)" class="tech-input">
                <input id="quiz_opt0_so" placeholder="بەژار 1 (سۆرانی)" class="tech-input">
                <input id="quiz_opt1_so" placeholder="بەژار 2 (سۆرانی)" class="tech-input">
                <input id="quiz_opt2_so" placeholder="بەژار 3 (سۆرانی)" class="tech-input">
                <input id="quiz_opt3_so" placeholder="بەژار 4 (سۆرانی)" class="tech-input">
                <input id="quiz_opt0_ba" placeholder="بەژار 1 (بادینی)" class="tech-input">
                <input id="quiz_opt1_ba" placeholder="بەژار 2 (بادینی)" class="tech-input">
                <input id="quiz_opt2_ba" placeholder="بەژار 3 (بادینی)" class="tech-input">
                <input id="quiz_opt3_ba" placeholder="بەژار 4 (بادینی)" class="tech-input">
                <select id="quiz_correct" class="tech-select">
                    <option value="0">بەژاری ڕاست 0</option><option value="1">بەژاری ڕاست 1</option><option value="2">بەژاری ڕاست 2</option><option value="3">بەژاری ڕاست 3</option>
                </select>
                <div class="md:col-span-2"><button type="submit" id="btn-submit-quiz" class="btn btn-primary w-full justify-center">سەیڤکردن</button></div>
            </form>

            <div id="form-manage" class="mt-4">
                <select id="manage_category" onchange="renderManageList()" class="tech-select mb-4">
                    <option value="langs">زمانەکان</option><option value="lessons">وانەکان</option><option value="quizzes">پرسیارەکان</option>
                </select>
                <div id="manage-list"></div>
            </div>
        </div>
    </div>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";
        import { getDatabase, ref as dbRef, push, set, update, remove, onValue } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";

        const firebaseConfig = { apiKey: "AIzaSyB-6_Ga6o3i3VYfjOX_UmKtI2qpsGHycJs", authDomain: "alphaai-d4f4c.firebaseapp.com", databaseURL: "https://alphaai-d4f4c-default-rtdb.firebaseio.com", projectId: "alphaai-d4f4c" };
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const db = getDatabase(app);
        const IMGBB_API_KEY = "947299981b43abca761315a1cd24c02a";

        let pyodide = null;
        async function initPyodide() { if (!pyodide) pyodide = await loadPyodide(); }

        let currentLangExt = 'py';
        async function runPythonCode() {
            const out = document.getElementById('code-output');
            const code = document.getElementById('user-code').value;
            out.innerText = "چاوەڕێ بکە...";
            try {
                await initPyodide();
                pyodide.runPython("import sys\nfrom io import StringIO\nsys.stdout = StringIO()");
                await pyodide.runPythonAsync(code);
                out.innerText = pyodide.runPython("sys.stdout.getvalue()");
            } catch (err) { out.innerText = "هەڵە:\n" + err; }
        }

        async function runCppCode() {
            const out = document.getElementById('code-output');
            const code = document.getElementById('user-code').value;
            out.innerText = "چاوەڕێ بکە...";
            try {
                const res = await fetch("https://godbolt.org/api/compiler/g142/compile", {
                    method: "POST",
                    headers: { "Content-Type": "application/json", "Accept": "application/json" },
                    body: JSON.stringify({ source: code, compiler: "g142", options: { userArguments: "-std=c++17 -O2", filters: { execute: true, binary: false } } })
                });
                const data = await res.json();
                let output = "";
                if (data.execResult?.stdout) output = data.execResult.stdout.map(o=>o.text).join("");
                if (data.execResult?.stderr?.length) output += "\n" + data.execResult.stderr.map(o=>o.text).join("");
                out.innerText = output || "(بێ دەرکەوتن)";
            } catch (err) { out.innerText = "هەڵە:\n" + err; }
        }

        function runCode() { currentLangExt === 'cpp' ? runCppCode() : runPythonCode(); }
        window.runCode = runCode;

        let currentLang = localStorage.getItem('site-lang') || 'so';
        let languagesData = {}, lessonsData = {}, quizzesData = {};
        let currentActiveLanguage = null, currentLessonArray = [], currentLessonIndex = 0;
        let completedLessons = JSON.parse(localStorage.getItem('ferga_completed_lessons') || '[]');
        const loc = (obj, key) => currentLang === 'ba' && obj[key+'_ba'] ? obj[key+'_ba'] : obj[key+'_so'] || obj[key];

        onValue(dbRef(db, 'ferga_languages'), (s) => { languagesData = s.val() || {}; renderLanguagesGrid(); updateAdminSelects(); renderManageList(); });
        onValue(dbRef(db, 'ferga_lessons'), (s) => { lessonsData = s.val() || {}; updateAdminSelects(); renderManageList(); });
        onValue(dbRef(db, 'ferga_quizzes'), (s) => { quizzesData = s.val() || {}; renderManageList(); });

        function renderLanguagesGrid() {
            const grid = document.getElementById('languages-grid');
            if(!grid) return;
            grid.innerHTML = '';
            for (let id in languagesData) {
                const l = languagesData[id];
                const name = loc(l, 'name');
                grid.innerHTML += `
                    <div onclick="openLanguage('${id}')" class="lang-card anim-up">
                        <div class="w-16 h-16 ${l.color||'bg-gold/20'} rounded-xl flex items-center justify-center mb-4 text-2xl font-black">
                            ${l.logo_url ? `<img src="${l.logo_url}" class="w-full h-full object-contain p-2">` : name.charAt(0)}
                        </div>
                        <h3 class="font-bold text-lg text-stone-900 dark:text-white">${name}</h3>
                        <p class="text-sm text-stone-500 dark:text-stone-400 mt-1 line-clamp-2">${loc(l, 'desc')}</p>
                    </div>`;
            }
        }

        window.openLanguage = function(langId, forcedIndex = null) {
            currentActiveLanguage = { id: langId, ...languagesData[langId] };
            document.getElementById('home-view').classList.add('hidden');
            document.getElementById('learning-view').classList.remove('hidden');

            let langLessons = [];
            for (let lid in lessonsData) { if (lessonsData[lid].langId === langId) langLessons.push({id: lid, ...lessonsData[lid]}); }

            const grouped = {};
            langLessons.forEach(l => { const level = loc(l, 'level'); if(!grouped[level]) grouped[level]=[]; grouped[level].push(l); });

            currentLessonArray = [];
            const sidebar = document.getElementById('sidebar-content');
            const langName = loc(currentActiveLanguage, 'name');
            sidebar.innerHTML = `<div class="flex items-center gap-2 mb-6"><div class="w-8 h-8 rounded-lg bg-amber-600 flex items-center justify-center text-white font-bold text-sm">${langName.charAt(0)}</div><h3 class="font-black text-lg">${langName}</h3></div>`;

            const ext = langName.includes('++') ? 'cpp' : 'py';
            currentLangExt = ext;
            document.getElementById('code-filename-label').textContent = 'main.' + ext;

            for (let level in grouped) {
                sidebar.innerHTML += `<div class="text-xs font-bold text-stone-400 uppercase mb-2 mt-4 px-2">${level}</div>`;
                grouped[level].forEach(lesson => {
                    const idx = currentLessonArray.length;
                    currentLessonArray.push(lesson);
                    const done = completedLessons.includes(lesson.id);
                    const check = done ? '<svg class="w-4 h-4 text-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>' : '';
                    sidebar.innerHTML += `<button id="sidebar-btn-${idx}" onclick="loadLesson(${idx})" class="sidebar-btn flex justify-between items-center"><span class="truncate">${loc(lesson, 'title')}</span>${check}</button>`;
                });
            }
            if (currentLessonArray.length > 0) loadLesson(forcedIndex !== null ? forcedIndex : 0);
            else {
                document.getElementById('display-title').innerText = langName;
                document.getElementById('display-content').innerText = loc(currentActiveLanguage, 'desc') + "\n\nهیچ وانەیەک نییە.";
                document.getElementById('display-code-box').classList.add('hidden');
            }
        };

        window.loadLesson = function(index) {
            currentLessonIndex = index;
            const lesson = currentLessonArray[index];
            document.querySelectorAll('[id^="sidebar-btn-"]').forEach(el => el.classList.remove('active'));
            document.getElementById(`sidebar-btn-${index}`)?.classList.add('active');
            document.getElementById('display-title').innerText = loc(lesson, 'title');
            document.getElementById('display-content').innerText = loc(lesson, 'content');
            if (lesson.code?.trim()) {
                document.getElementById('display-code-box').classList.remove('hidden');
                document.getElementById('display-code').innerText = lesson.code;
            } else document.getElementById('display-code-box').classList.add('hidden');

            const prev = document.getElementById('btn-prev');
            prev.disabled = index === 0;
            prev.style.opacity = index === 0 ? '0.3' : '1';
            prev.onclick = () => { if(index > 0) loadLesson(index - 1); };

            const btn = document.getElementById('btn-action');
            const done = completedLessons.includes(lesson.id);
            btn.textContent = done ? 'بەردەوام &raquo;' : 'تەواوکردنی وانە ✓';
            btn.className = done ? 'btn-primary' : 'btn-amber';
        };

        window.handleNextAction = function() {
            const lessonId = currentLessonArray[currentLessonIndex].id;
            if (!completedLessons.includes(lessonId)) {
                let qs = [];
                for(let qid in quizzesData) { if(quizzesData[qid].lessonId === lessonId) qs.push(quizzesData[qid]); }
                if (qs.length > 0) startQuiz(qs, lessonId);
                else markDone(lessonId);
            } else if(currentLessonIndex < currentLessonArray.length - 1) loadLesson(currentLessonIndex + 1);
        };

        function markDone(lessonId) {
            if(!completedLessons.includes(lessonId)) { completedLessons.push(lessonId); localStorage.setItem('ferga_completed_lessons', JSON.stringify(completedLessons)); }
            openLanguage(currentActiveLanguage.id, currentLessonIndex);
            if(currentLessonIndex < currentLessonArray.length - 1) loadLesson(currentLessonIndex + 1);
        }

        let quizQuestions = [], quizIdx = 0, quizScore = 0, quizLessonId = null, selectedOpt = null;

        function startQuiz(qs, lessonId) {
            quizQuestions = qs; quizIdx = 0; quizScore = 0; quizLessonId = lessonId;
            document.getElementById('quiz-modal').classList.remove('hidden');
            renderQuestion();
        }

        function renderQuestion() {
            const q = quizQuestions[quizIdx];
            selectedOpt = null;
            document.getElementById('quiz-counter').innerText = `${quizIdx+1}/${quizQuestions.length}`;
            document.getElementById('quiz-question-text').innerText = q.question_so;
            const container = document.getElementById('quiz-options');
            container.innerHTML = '';
            (q.options_so||[]).forEach((opt, i) => {
                container.innerHTML += `
                    <div onclick="selectOpt(${i})" id="qopt-${i}" class="cursor-pointer border border-stone-200 dark:border-stone-700 bg-stone-50 dark:bg-stone-800/50 rounded-lg p-4 font-semibold text-stone-700 dark:text-stone-300 hover:border-gold transition-all flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full border-2 border-stone-300 dark:border-stone-600 flex items-center justify-center shrink-0"></div>
                        ${opt}
                    </div>`;
            });
            const next = document.getElementById('btn-next-question');
            next.disabled = true; next.className = 'btn-stone opacity-50 cursor-not-allowed';
        }

        window.selectOpt = function(idx) {
            selectedOpt = idx;
            document.querySelectorAll('[id^="qopt-"]').forEach(el => {
                el.classList.remove('border-gold', 'bg-gold/10');
                el.querySelector('div').innerHTML = '';
            });
            const el = document.getElementById(`qopt-${idx}`);
            el.classList.add('border-gold', 'bg-gold/10');
            el.querySelector('div').innerHTML = '<svg class="w-3 h-3 text-amber-800" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>';
            const next = document.getElementById('btn-next-question');
            next.disabled = false; next.className = 'btn-primary';
        };

        window.nextQuestion = function() {
            if(selectedOpt === null) return;
            if(parseInt(selectedOpt) === parseInt(quizQuestions[quizIdx].correct)) quizScore++;
            quizIdx++;
            if(quizIdx < quizQuestions.length) renderQuestion();
            else showQuizResult();
        };
        document.getElementById('btn-next-question').addEventListener('click', nextQuestion);

        function showQuizResult() {
            document.getElementById('quiz-content').classList.add('hidden');
            document.getElementById('quiz-footer').classList.add('hidden');
            document.getElementById('quiz-result').classList.remove('hidden');
            const pct = Math.round((quizScore/quizQuestions.length)*100);
            document.getElementById('quiz-score-text').innerText = `${quizScore}/${quizQuestions.length} (${pct}%)`;
            if(!completedLessons.includes(quizLessonId)) { completedLessons.push(quizLessonId); localStorage.setItem('ferga_completed_lessons', JSON.stringify(completedLessons)); }
        }

        window.finishQuizAndContinue = function() {
            document.getElementById('quiz-modal').classList.add('hidden');
            openLanguage(currentActiveLanguage.id, currentLessonIndex);
            if(currentLessonIndex < currentLessonArray.length - 1) loadLesson(currentLessonIndex + 1);
        };

        window.openTryItYourself = function() {
            document.getElementById('user-code').value = document.getElementById('display-code').innerText;
            document.getElementById('code-output').innerText = 'ئامادەیە...';
            document.getElementById('compiler-modal').classList.remove('hidden');
        };
        window.closeTryItYourself = function() { document.getElementById('compiler-modal').classList.add('hidden'); };
        window.goBackToHome = function() {
            document.getElementById('learning-view').classList.add('hidden');
            document.getElementById('home-view').classList.remove('hidden');
        };

        // Admin
        window.switchAdminTab = function(tab) {
            ['lang','lesson','quiz','manage'].forEach(x => {
                document.getElementById(`form-${x}`).classList.add('hidden');
            });
            document.getElementById(`form-${tab}`).classList.remove('hidden');
            if(tab !== 'manage') document.getElementById(`form-${tab}`).reset();
        };

        function updateAdminSelects() {
            const ls = document.getElementById('lesson_lang_select');
            ls.innerHTML = '<option value="">-- زمان --</option>';
            for(let id in languagesData) ls.innerHTML += `<option value="${id}">${languagesData[id].name_so}</option>`;
            const qs = document.getElementById('quiz_lesson_select');
            qs.innerHTML = '<option value="">-- وانە --</option>';
            for(let id in lessonsData) qs.innerHTML += `<option value="${id}">${lessonsData[id].title_so||'?'}</option>`;
        }

        async function uploadImg(file) {
            const fd = new FormData(); fd.append('image', file);
            const r = await fetch(`https://api.imgbb.com/1/upload?key=${IMGBB_API_KEY}`, { method: 'POST', body: fd });
            const d = await r.json();
            return d.data.url;
        }

        document.getElementById('form-lang').addEventListener('submit', async (e) => {
            e.preventDefault();
            const editId = document.getElementById('edit_lang_id').value;
            let logoUrl = '';
            const file = document.getElementById('lang_logo_file').files[0];
            if(file) logoUrl = await uploadImg(file);
            const data = { name_so: document.getElementById('lang_name_so').value, name_ba: document.getElementById('lang_name_ba').value, desc_so: document.getElementById('lang_desc_so').value, desc_ba: document.getElementById('lang_desc_ba').value, color: document.getElementById('lang_color').value, logo_url: logoUrl };
            if(editId) await update(dbRef(db, 'ferga_languages/'+editId), data); else await set(push(dbRef(db, 'ferga_languages')), data);
            alert('زیادکرا!'); document.getElementById('form-lang').reset(); switchAdminTab('manage');
        });

        document.getElementById('form-lesson').addEventListener('submit', async (e) => {
            e.preventDefault();
            const editId = document.getElementById('edit_lesson_id').value;
            const data = { langId: document.getElementById('lesson_lang_select').value, level_so: document.getElementById('lesson_level_so').value, level_ba: document.getElementById('lesson_level_ba').value, title_so: document.getElementById('lesson_title_so').value, title_ba: document.getElementById('lesson_title_ba').value, content_so: document.getElementById('lesson_content_so').value, content_ba: document.getElementById('lesson_content_ba').value, code: document.getElementById('lesson_code').value };
            if(editId) await update(dbRef(db, 'ferga_lessons/'+editId), data); else await set(push(dbRef(db, 'ferga_lessons')), data);
            alert('زیادکرا!'); document.getElementById('form-lesson').reset(); switchAdminTab('manage');
        });

        document.getElementById('form-quiz').addEventListener('submit', async (e) => {
            e.preventDefault();
            const editId = document.getElementById('edit_quiz_id').value;
            const data = { lessonId: document.getElementById('quiz_lesson_select').value, question_so: document.getElementById('quiz_question_so').value, question_ba: document.getElementById('quiz_question_ba').value, options_so: [0,1,2,3].map(i=>document.getElementById(`quiz_opt${i}_so`).value), options_ba: [0,1,2,3].map(i=>document.getElementById(`quiz_opt${i}_ba`).value), correct: document.getElementById('quiz_correct').value };
            if(editId) await update(dbRef(db, 'ferga_quizzes/'+editId), data); else await set(push(dbRef(db, 'ferga_quizzes')), data);
            alert('زیادکرا!'); document.getElementById('form-quiz').reset(); switchAdminTab('manage');
        });

        window.renderManageList = function() {
            const cat = document.getElementById('manage_category').value;
            const list = document.getElementById('manage-list');
            list.innerHTML = '';
            const data = cat === 'langs' ? languagesData : (cat === 'lessons' ? lessonsData : quizzesData);
            for(let id in data) {
                const item = data[id];
                let title = cat === 'langs' ? (item.name_so||'') : (cat === 'lessons' ? (item.title_so||'') : (item.question_so||''));
                list.innerHTML += `
                    <div class="flex justify-between items-center card p-4 mb-2">
                        <span class="font-semibold truncate">${title}</span>
                        <div class="flex gap-2">
                            <button onclick="editItem('${cat}','${id}')" class="px-3 py-1.5 bg-gold/20 text-amber-800 rounded-lg text-xs font-bold hover:bg-gold/30">دەستکاری</button>
                            <button onclick="deleteItem('${cat}','${id}')" class="px-3 py-1.5 bg-red-100 text-red-600 rounded-lg text-xs font-bold hover:bg-red-200">سڕینەوە</button>
                        </div>
                    </div>`;
            }
        };

        window.deleteItem = async function(cat, id) {
            if(!confirm('دڵنیایت؟')) return;
            const path = cat === 'langs' ? 'ferga_languages' : (cat === 'lessons' ? 'ferga_lessons' : 'ferga_quizzes');
            await remove(dbRef(db, `${path}/${id}`));
        };

        window.editItem = function(cat, id) {
            if(cat === 'langs') {
                const d = languagesData[id];
                document.getElementById('edit_lang_id').value = id;
                document.getElementById('lang_name_so').value = d.name_so||'';
                document.getElementById('lang_name_ba').value = d.name_ba||'';
                document.getElementById('lang_desc_so').value = d.desc_so||'';
                document.getElementById('lang_desc_ba').value = d.desc_ba||'';
                document.getElementById('lang_color').value = d.color||'';
                switchAdminTab('lang');
            } else if(cat === 'lessons') {
                const d = lessonsData[id];
                document.getElementById('edit_lesson_id').value = id;
                document.getElementById('lesson_lang_select').value = d.langId||'';
                document.getElementById('lesson_level_so').value = d.level_so||'';
                document.getElementById('lesson_level_ba').value = d.level_ba||'';
                document.getElementById('lesson_title_so').value = d.title_so||'';
                document.getElementById('lesson_title_ba').value = d.title_ba||'';
                document.getElementById('lesson_content_so').value = d.content_so||'';
                document.getElementById('lesson_content_ba').value = d.content_ba||'';
                document.getElementById('lesson_code').value = d.code||'';
                document.getElementById('btn-submit-lesson').innerText = 'نوێکردنەوە';
                switchAdminTab('lesson');
            } else if(cat === 'quizzes') {
                const d = quizzesData[id];
                document.getElementById('edit_quiz_id').value = id;
                document.getElementById('quiz_lesson_select').value = d.lessonId||'';
                document.getElementById('quiz_question_so').value = d.question_so||'';
                document.getElementById('quiz_question_ba').value = d.question_ba||'';
                const so = d.options_so||['','','','']; const ba = d.options_ba||['','','',''];
                [0,1,2,3].forEach(i => {
                    document.getElementById(`quiz_opt${i}_so`).value = so[i]||'';
                    document.getElementById(`quiz_opt${i}_ba`).value = ba[i]||'';
                });
                document.getElementById('quiz_correct').value = d.correct||'0';
                document.getElementById('btn-submit-quiz').innerText = 'نوێکردنەوە';
                switchAdminTab('quiz');
            }
        };

        onAuthStateChanged(auth, (user) => {
            if(!user) window.location.href = "/login";
            else {
                document.getElementById('page-shell').style.display = 'block';
                if((user && user.email === "alphaaiteam@gmail.com")) document.getElementById('admin-section').classList.remove('hidden');
            }
        });
    </script>

@include('partials.footer')
</div>
@endsection
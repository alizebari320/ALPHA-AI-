@extends('layouts.app')

@section('title', 'پڕۆفایل — ALPHA/AI')

@section('content')
@include('partials.nav', ['active' => 'profile'])
<div id="page-shell" style="display:none">


    

    <div class="tech-glow w-72 h-72 top-0 left-1/4"></div>

    <section class="relative z-10 max-w-5xl mx-auto py-12 px-4">
        <div class="card overflow-hidden mb-8">
            <div class="h-32 bg-gradient-to-l from-amber-700 via-amber-600 to-neutral-950 relative">
                <div class="absolute inset-0" style="background: repeating-linear-gradient(-45deg, rgba(240,180,41,.12) 0 2px, transparent 2px 22px);"></div>
            </div>
            <div class="px-8 pb-8 relative flex flex-col md:flex-row items-center md:items-end justify-between -mt-16 gap-6">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div id="profile-avatar" class="w-32 h-32 bg-gradient-to-br from-amber-400 to-amber-600 border-4 border-white dark:border-neutral-900 flex items-center justify-center text-neutral-950 text-4xl font-black shadow-[6px_6px_0_rgba(0,0,0,.35)]">-</div>
                    <div class="text-center md:text-right mt-4 md:mt-16">
                        <h2 id="profile-name" class="font-mega text-4xl tracking-wide text-stone-900 dark:text-cream mb-1">...</h2>
                        <p id="profile-email" class="font-mono text-xs text-stone-500 dark:text-stone-400" dir="ltr">...</p>
                    </div>
                </div>
                <div class="admin-only hidden bg-gold/10 text-amber-800 dark:text-gold px-4 py-2 font-mono text-xs font-bold tracking-widest border-2 border-gold/50 mb-2">سەرپەرشتیار (ئەدمین)</div>
            </div>
        </div>

        <div class="admin-only hidden mb-8">
            <div class="border-2 border-gold/60 bg-gold/5 dark:bg-neutral-900 p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-full h-1.5 bg-gradient-to-l from-amber-400 to-amber-600"></div>
                <div class="text-center mb-8">
                    <span class="corner-tag mb-3">// ADMIN CONSOLE</span>
                    <h3 class="font-mega text-3xl tracking-wide gold-text mt-2 mb-2">پەنێڵی بەڕێوەبردن</h3>
                    <p class="text-stone-500 dark:text-stone-400 text-sm">دەستگەیشتنی خێرا بۆ بەشەکانی زیادکردنی داتا</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="/courses" class="bg-gold/10 text-amber-800 dark:text-gold font-mono font-bold py-4 px-6 text-center hover:bg-gold/20 transition border-2 border-gold/40">بەڕێوەبردنی کۆرسەکان</a>
                    <a href="/ai-tools" class="bg-gold/10 text-amber-800 dark:text-gold font-mono font-bold py-4 px-6 text-center hover:bg-gold/20 transition border-2 border-gold/40">بەڕێوەبردنی ئامرازەکان</a>
                    <a href="/academic-guide" class="bg-gold/10 text-amber-800 dark:text-gold font-mono font-bold py-4 px-6 text-center hover:bg-gold/20 transition border-2 border-gold/40">بەڕێوەبردنی ڕێنیشاندەر</a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 card p-8">
                <h3 class="font-mega text-2xl tracking-wide text-center mb-6 text-stone-900 dark:text-cream">چالاکییەکانی من</h3>
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-stone-100 dark:bg-graphite p-6 text-center border-2 border-stone-300 dark:border-neutral-800">
                        <div class="text-3xl font-mega tracking-wider gold-text mb-1">٠</div>
                        <div class="text-xs font-mono text-stone-500 dark:text-stone-400 tracking-widest">کۆرسی تەواوکراو</div>
                    </div>
                    <div class="bg-stone-100 dark:bg-graphite p-6 text-center border-2 border-stone-300 dark:border-neutral-800">
                        <div class="text-3xl font-mega tracking-wider gold-text mb-1">٠</div>
                        <div class="text-xs font-mono text-stone-500 dark:text-stone-400 tracking-widest">ئامرازی دڵخواز</div>
                    </div>
                </div>
                <p class="text-center text-sm text-stone-400 dark:text-stone-500 font-mono">لەم بەشەدا لە داهاتوودا چالاکییەکانت پیشان دەدرێت</p>
            </div>

            <div class="card p-8 flex flex-col justify-center">
                <h3 class="font-mega text-2xl tracking-wide text-center mb-6 text-stone-900 dark:text-cream">زانیارییە کەسییەکان</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center border-b-2 border-stone-300 dark:border-neutral-800 pb-4">
                        <span class="text-stone-500 dark:text-stone-400 font-mono text-xs font-bold tracking-widest">جۆری هەژمار</span>
                        <span id="account-type" class="font-bold text-stone-900 dark:text-cream">بەکارهێنەر</span>
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <span class="text-stone-500 dark:text-stone-400 font-mono text-xs font-bold tracking-widest">بەشداریکردن</span>
                        <span class="font-bold text-stone-900 dark:text-cream">خۆڕایی (چالاکە)</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";

        const firebaseConfig = { apiKey: "AIzaSyB-6_Ga6o3i3VYfjOX_UmKtI2qpsGHycJs", authDomain: "alphaai-d4f4c.firebaseapp.com", databaseURL: "https://alphaai-d4f4c-default-rtdb.firebaseio.com", projectId: "alphaai-d4f4c", storageBucket: "alphaai-d4f4c.firebasestorage.app", messagingSenderId: "518050080770", appId: "1:518050080770:web:c00d17cdbbbacb8ddd1f1b" };
        const auth = getAuth(initializeApp(firebaseConfig));

        let currentLang = localStorage.getItem('site-lang') || 'so';
        let isAdmin = false;

        function applyLanguage() {
            const langBtnText = document.getElementById('lang-text');
            if (langBtnText) langBtnText.innerText = currentLang === 'so' ? 'Badini' : 'سۆرانی';
            document.querySelectorAll('.lang-str').forEach(el => {
                el.innerText = el.getAttribute(`data-${currentLang}`) || el.getAttribute('data-so');
            });
            const typeEl = document.getElementById('account-type');
            if(isAdmin && typeEl) {
                typeEl.innerText = 'ئەدمین (تایبەت)';
                typeEl.classList.add('text-amber-700', 'dark:text-gold');
            }
        }

        function getInitials(name) {
            if(!name) return 'U';
            const parts = name.split(' ');
            return parts.length > 1 ? (parts[0][0] + parts[1][0]).toUpperCase() : name.substring(0, 2).toUpperCase();
        }

        onAuthStateChanged(auth, (user) => {
            if(!user) { window.location.href = "/login"; }
            else {
                document.getElementById('page-shell').style.display = 'block';
                let displayName = (user && (user.displayName || user.email.split('@')[0])) || 'Admin';
                document.getElementById('profile-name').innerText = displayName;
                document.getElementById('profile-email').innerText = (user && user.email) || 'alphaaiteam@gmail.com';
                document.getElementById('profile-avatar').innerText = getInitials(displayName);
                if((user && ["alphaaiteam@gmail.com"].includes(user.email))) {
                    isAdmin = true;
                    document.querySelectorAll('.admin-only').forEach(el => el.classList.remove('hidden'));
                }
                applyLanguage();
            }
        });
    </script>

</div>
@endsection
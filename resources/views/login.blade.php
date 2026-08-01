@extends('layouts.app')

@section('title', 'چوونەژوورەوە — ALPHA/AI')

@section('content')


    <div class="tech-glow w-72 h-72 top-0 right-1/4"></div>

    <div class="card relative z-10 p-10 w-full max-w-md !shadow-[8px_8px_0_rgba(0,0,0,.3)]">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-amber-600 border-2 border-amber-700 flex items-center justify-center shadow-[3px_3px_0_rgba(0,0,0,.35)] text-neutral-950 font-black text-2xl mx-auto mb-4 font-mega">A</div>
            <h2 class="font-mega text-4xl tracking-wide text-stone-900 dark:text-cream mb-1">بەخێربێیت <span class="gold-text">بۆوە</span></h2>
            <p class="text-stone-500 dark:text-stone-400 mt-2 font-mono text-xs tracking-widest">تکایە فۆرمەکە پڕبکەرەوە</p>
        </div>

        <div id="error-message" class="hidden bg-red-500/10 text-red-600 dark:text-red-400 text-sm font-bold p-3 mb-6 text-center border-2 border-red-500/40"></div>
        <div id="success-message" class="hidden bg-gold/10 text-amber-800 dark:text-gold text-sm font-bold p-4 mb-6 text-center border-2 border-gold/40"></div>

        <div class="space-y-4">
            <div>
                <label class="tech-label">ئیمێڵ</label>
                <input type="email" id="email" placeholder="ئیمێڵەکەت بنووسە" class="tech-input text-left" dir="ltr">
            </div>
            <div>
                <label class="tech-label">وشەی نهێنی</label>
                <input type="password" id="password" placeholder="وشەی نهێنی (لانی کەم ٦ پیت)" class="tech-input text-left" dir="ltr">
                <div class="text-left mt-2">
                    <button id="forgot-password-btn" type="button" class="text-xs font-mono font-bold tracking-wide text-stone-500 dark:text-stone-400 hover:text-amber-700 dark:hover:text-gold transition">وشەی نهێنیت بیرچووە؟</button>
                </div>
            </div>

            <div class="pt-2 space-y-3">
                <button id="email-login-btn" class="w-full btn btn-primary justify-center !py-3.5 !text-sm btn-glow">
                    چوونەژوورەوە
                </button>
                <button id="email-signup-btn" class="w-full btn btn-outline justify-center !py-3.5 !text-sm">
                    دروستکردنی هەژماری نوێ
                </button>
            </div>
        </div>

        <div class="mt-8 flex items-center justify-between">
            <hr class="w-full border-stone-300 dark:border-neutral-800">
            <span class="px-3 text-stone-400 text-xs font-mono tracking-widest whitespace-nowrap">یان بەکارهێنانی</span>
            <hr class="w-full border-stone-300 dark:border-neutral-800">
        </div>

        <div class="mt-8">
            <button id="google-login-btn" class="w-full flex items-center justify-center gap-3 btn btn-stone !py-3.5 !text-sm">
                <svg class="w-6 h-6" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 15.02 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                بەردەوامبوون لەگەڵ گووگڵ
            </button>
        </div>
    </div>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, signInWithEmailAndPassword, createUserWithEmailAndPassword, GoogleAuthProvider, signInWithPopup, sendEmailVerification, signOut, sendPasswordResetEmail } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";

        const firebaseConfig = { apiKey: "AIzaSyB-6_Ga6o3i3VYfjOX_UmKtI2qpsGHycJs", authDomain: "alphaai-d4f4c.firebaseapp.com", databaseURL: "https://alphaai-d4f4c-default-rtdb.firebaseio.com", projectId: "alphaai-d4f4c", storageBucket: "alphaai-d4f4c.firebasestorage.app", messagingSenderId: "518050080770", appId: "1:518050080770:web:c00d17cdbbbacb8ddd1f1b" };
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        auth.useDeviceLanguage();

        const adminEmails = ["alphaaiteam@gmail.com"];

        const errorMsg = document.getElementById('error-message');
        const successMsg = document.getElementById('success-message');

        function showError(text) { errorMsg.innerText = text; errorMsg.classList.remove('hidden'); successMsg.classList.add('hidden'); }
        function showSuccess(text) { successMsg.innerText = text; successMsg.classList.remove('hidden'); errorMsg.classList.add('hidden'); }

        document.getElementById('email-login-btn').addEventListener('click', () => {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            if(!email || !password) { showError("تکایە ئیمێڵ و وشەی نهێنی پڕبکەرەوە."); return; }


            signInWithEmailAndPassword(auth, email, password)
                .then((userCredential) => {
                    const user = userCredential.user;
                    if (!user.emailVerified && !adminEmails.includes(user.email)) {
                        signOut(auth).then(() => showError("تکایە سەرەتا سەردانی ئیمێڵەکەت بکە و هەژمارەکەت پشتڕاست بکەرەوە."));
                    } else {
                        user.getIdToken().then((idToken) => syncFirebase(idToken, "/"));
                    }
                })
                .catch((error) => {
                    if (error.code === 'auth/invalid-credential') showError("ئیمێڵ یان وشەی نهێنی هەڵەیە.");
                    else showError("کێشەیەک ڕوویدا: " + error.message);
                });
        });

        document.getElementById('email-signup-btn').addEventListener('click', () => {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            if(email && password) {
                createUserWithEmailAndPassword(auth, email, password)
                .then((userCredential) => {
                    const user = userCredential.user;
                    sendEmailVerification(user).then(() => {
                        signOut(auth).then(() => {
                            showSuccess("هەژمارەکەت سەرکەوتوویانە دروستکرا! نامەیەکی دڵنیاییمان نارد بۆ ئیمێڵەکەت.");
                            document.getElementById('email').value = '';
                            document.getElementById('password').value = '';
                        });
                    });
                })
                .catch((error) => {
                    if(error.code === 'auth/email-alive-in-use') showError("ئەم ئیمێڵە پێشتر بەکارهاتووە.");
                    else if (error.code === 'auth/weak-password') showError("وشەی نهێنی لاوازە، دەبێت لانی کەم ٦ پیت بێت.");
                    else showError("کێشەیەک ڕوویدا: " + error.message);
                });
            } else showError("تکایە سەرەتا ئیمێڵ و وشەی نهێنی پڕبکەرەوە.");
        });

        function syncFirebase(idToken, redirectUrl) {
            fetch('/api/firebase-auth-sync', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ id_token: idToken })
            }).then((res) => {
                if (res.ok) window.location.href = redirectUrl;
                else showError("کێشەیەک ڕوویدا لە چوونەژوورەوە (کۆدی " + res.status + ").");
            }).catch(() => showError("کێشەیەک ڕوویدا لە چوونەژوورەوە."));
        }

        const provider = new GoogleAuthProvider();
        document.getElementById('google-login-btn').addEventListener('click', () => {
            signInWithPopup(auth, provider)
            .then((result) => { result.user.getIdToken().then((idToken) => syncFirebase(idToken, "/")); })
            .catch((error) => { if (error.code !== 'auth/popup-closed-by-user') showError("کێشەیەک ڕوویدا لە گووگڵ: " + error.message); });
        });

        document.getElementById('forgot-password-btn').addEventListener('click', () => {
            const email = document.getElementById('email').value;
            if(!email) { showError("تکایە سەرەتا ئیمێڵەکەت بنووسە."); return; }
            sendPasswordResetEmail(auth, email)
            .then(() => showSuccess("لینکی گۆڕینی وشەی نهێنی نێردرا بۆ ئیمێڵەکەت!"))
            .catch((error) => showError("کێشەیەک ڕوویدا: " + error.message));
        });
    </script>

@include('partials.footer')
@endsection
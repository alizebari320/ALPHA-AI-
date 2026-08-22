@extends('layouts.app')

@section('title', 'چوونەژوورەوە — ALPHA/AI')

@section('content')
    @include('partials.auth-background')

    @component('partials.auth-card')
        @slot('header')
            <div class="w-14 h-14 mx-auto mb-4 rounded-xl bg-gradient-to-br from-cyan-400 to-violet-600 border-2 border-cyan-400/50 flex items-center justify-center shadow-[0_0_30px_rgba(34,229,255,0.4)] text-neutral-950 font-black text-xl font-mega">A</div>
            <h2 class="font-mega text-3xl tracking-wide text-zinc-100 mb-1">بەخێربێیت <span class="neon-text">بۆوە</span></h2>
            <p class="text-zinc-500 font-mono text-xs tracking-widest mt-2">تکایە فۆرمەکە پڕبکەرەوە</p>
        @endslot

        @slot('body')
            <div id="error-message" class="hidden mb-6 p-3 rounded-lg bg-rose-500/10 text-rose-400 text-sm font-medium text-center border border-rose-500/30"></div>
            <div id="success-message" class="hidden mb-6 p-3 rounded-lg bg-lime-500/10 text-lime-400 text-sm font-medium text-center border border-lime-500/30"></div>

            <div class="space-y-4" x-data="authForm()">
                <div>
                    <label for="email" class="label">ئیمێڵ</label>
                    <input type="email" id="email" x-model="email" placeholder="ئیمێڵەکەت بنووسە" class="field text-left" dir="ltr" autocomplete="email" @keydown.enter="login">
                </div>
                <div>
                    <label for="password" class="label">وشەی نهێنی</label>
                    <div class="relative">
                        <input type="password" id="password" x-model="password" placeholder="وشەی نهێنی (لانی کەم ٦ پیت)" class="field text-left pr-12" dir="ltr" autocomplete="current-password" @keydown.enter="login">
                        <button type="button" @click="togglePassword" class="absolute inset-y-0 right-3 flex items-center text-zinc-500 hover:text-cyan-400 transition-colors" aria-label="Show password">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.955 9.955 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                    <div class="mt-2 text-left">
                        <button type="button" @click="forgotPassword" class="text-xs font-mono font-medium tracking-wider text-zinc-500 hover:text-cyan-400 dark:hover:text-cyan-300 transition-colors">وشەی نهێنیت بیرچووە؟</button>
                    </div>
                </div>

                <div class="pt-2 space-y-3">
                    <button @click="login" class="w-full btn btn-primary justify-center py-3.5 text-sm" :disabled="loading">
                        <span x-show="!loading">چوونەژوورەوە</span>
                        <span x-show="loading" class="flex items-center justify-center gap-2">
                            <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
                            چاوەڕوان بە...
                        </span>
                    </button>
                    <button @click="switchToRegister" class="w-full btn btn-ghost justify-center py-3.5 text-sm">
                        دروستکردنی هەژماری نوێ
                    </button>
                </div>
            </div>

            <div class="mt-8 flex items-center justify-center gap-3">
                <hr class="w-full border-zinc-800">
                <span class="px-3 text-zinc-500 text-xs font-mono tracking-widest whitespace-nowrap">یان بەکارهێنانی</span>
                <hr class="w-full border-zinc-800">
            </div>

            <div class="mt-6">
                <button id="google-login-btn" class="w-full flex items-center justify-center gap-3 btn btn-quiet py-3.5 text-sm" @click="googleLogin" :disabled="loading">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 15.02 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    بەردەوامبوون لەگەڵ گووگڵ
                </button>
            </div>
        @endslot
    @endcomponent

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, signInWithEmailAndPassword, createUserWithEmailAndPassword, GoogleAuthProvider, signInWithPopup, sendEmailVerification, signOut, sendPasswordResetEmail } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";

        const firebaseConfig = { apiKey: "AIzaSyB-6_Ga6o3i3VYfjOX_UmKtI2qpsGHycJs", authDomain: "alphaai-d4f4c.firebaseapp.com", databaseURL: "https://alphaai-d4f4c-default-rtdb.firebaseio.com", projectId: "alphaai-d4f4c", storageBucket: "alphaai-d4f4c.firebasestorage.app", messagingSenderId: "518050080770", appId: "1:518050080770:web:c00d17cdbbbacb8ddd1f1b" };
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        auth.useDeviceLanguage();

        const adminEmails = ["alphaaiteam@gmail.com"];

        document.addEventListener('alpine:init', () => {
            Alpine.data('authForm', () => ({
                email: '',
                password: '',
                showPassword: false,
                loading: false,

                togglePassword() {
                    this.showPassword = !this.showPassword;
                    const input = document.getElementById('password');
                    input.type = this.showPassword ? 'text' : 'password';
                },

                showError(text) {
                    const el = document.getElementById('error-message');
                    const success = document.getElementById('success-message');
                    el.innerText = text;
                    el.classList.remove('hidden');
                    success.classList.add('hidden');
                },

                showSuccess(text) {
                    const el = document.getElementById('success-message');
                    const error = document.getElementById('error-message');
                    el.innerText = text;
                    el.classList.remove('hidden');
                    error.classList.add('hidden');
                },

                async login() {
                    if (!this.email || !this.password) {
                        this.showError("تکایە ئیمێڵ و وشەی نهێنی پڕبکەرەوە.");
                        return;
                    }
                    this.loading = true;
                    try {
                        const userCredential = await signInWithEmailAndPassword(auth, this.email, this.password);
                        const user = userCredential.user;
                        if (!user.emailVerified && !adminEmails.includes(user.email)) {
                            await signOut(auth);
                            this.showError("تکایە سەرەتا سەردانی ئیمێڵەکەت بکە و هەژمارەکەت پشتڕاست بکەرەوە.");
                        } else {
                            const idToken = await user.getIdToken();
                            await this.syncFirebase(idToken, "/");
                        }
                    } catch (error) {
                        if (error.code === 'auth/invalid-credential' || error.code === 'auth/wrong-password' || error.code === 'auth/user-not-found') {
                            this.showError("ئیمێڵ یان وشەی نهێنی هەڵەیە.");
                        } else {
                            this.showError("کێشەیەک ڕوویدا: " + error.message);
                        }
                    } finally {
                        this.loading = false;
                    }
                },

                async register() {
                    if (!this.email || !this.password) {
                        this.showError("تکایە سەرەتا ئیمێڵ و وشەی نهێنی پڕبکەرەوە.");
                        return;
                    }
                    this.loading = true;
                    try {
                        const userCredential = await createUserWithEmailAndPassword(auth, this.email, this.password);
                        const user = userCredential.user;
                        await sendEmailVerification(user);
                        await signOut(auth);
                        this.showSuccess("هەژمارەکەت سەرکەوتوویانە دروستکرا! نامەیەکی دڵنیاییمان نارد بۆ ئیمێڵەکەت.");
                        this.email = '';
                        this.password = '';
                    } catch (error) {
                        if (error.code === 'auth/email-already-in-use') {
                            this.showError("ئەم ئیمێڵە پێشتر بەکارهاتووە.");
                        } else if (error.code === 'auth/weak-password') {
                            this.showError("وشەی نهێنی لاوازە، دەبێت لانی کەم ٦ پیت بێت.");
                        } else {
                            this.showError("کێشەیەک ڕوویدا: " + error.message);
                        }
                    } finally {
                        this.loading = false;
                    }
                },

                async forgotPassword() {
                    if (!this.email) {
                        this.showError("تکایە سەرەتا ئیمێڵەکەت بنووسە.");
                        return;
                    }
                    this.loading = true;
                    try {
                        await sendPasswordResetEmail(auth, this.email);
                        this.showSuccess("لینکی گۆڕینی وشەی نهێنی نێردرا بۆ ئیمێڵەکەت!");
                    } catch (error) {
                        this.showError("کێشەیەک ڕوویدا: " + error.message);
                    } finally {
                        this.loading = false;
                    }
                },

                async googleLogin() {
                    this.loading = true;
                    const provider = new GoogleAuthProvider();
                    try {
                        const result = await signInWithPopup(auth, provider);
                        const idToken = await result.user.getIdToken();
                        await this.syncFirebase(idToken, "/");
                    } catch (error) {
                        if (error.code !== 'auth/popup-closed-by-user') {
                            this.showError("کێشەیەک ڕوویدا لە گووگڵ: " + error.message);
                        }
                    } finally {
                        this.loading = false;
                    }
                },

                async syncFirebase(idToken, redirectUrl) {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    try {
                        const res = await fetch('/api/firebase-auth-sync', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ id_token: idToken })
                        });
                        if (res.ok) {
                            window.location.href = redirectUrl;
                        } else {
                            this.showError("کێشەیەک ڕوویدا لە چوونەژوورەوە (کۆدی " + res.status + ").");
                        }
                    } catch {
                        this.showError("کێشەیەک ڕوویدا لە چوونەژوورەوە.");
                    }
                },

                switchToRegister() {
                    window.location.href = "{{ route('register') }}";
                }
            }));
        });
    </script>

    @stack('scripts')
@endsection

@extends('layouts.app')

@section('title', 'دروستکردنی هەژمار — ALPHA/AI')

@section('content')
    @include('partials.auth-background')

    @component('partials.auth-card')
        @slot('header')
            <div class="w-14 h-14 mx-auto mb-4 rounded-xl bg-gradient-to-br from-cyan-400 to-violet-600 border-2 border-cyan-400/50 flex items-center justify-center shadow-[0_0_30px_rgba(34,229,255,0.4)] text-neutral-950 font-black text-xl font-mega">A</div>
            <h2 class="font-mega text-3xl tracking-wide text-zinc-100 mb-1">دروستکردنی هەژمار</h2>
            <p class="text-zinc-500 font-mono text-xs tracking-widest mt-2">بە بەشداریکردن لە کۆمەڵگەکەمان بۆوە</p>
        @endslot

        @slot('body')
            <form method="POST" action="{{ route('register') }}" x-data="registerForm()" @submit.prevent="submit">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label for="name" class="label">ناو</label>
                        <input type="text" id="name" name="name" x-model="name" class="field" value="{{ old('name') }}" required autofocus autocomplete="name">
                        <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-sm text-rose-400" />
                    </div>

                    <div>
                        <label for="email" class="label">ئیمێڵ</label>
                        <input type="email" id="email" name="email" x-model="email" class="field text-left" dir="ltr" value="{{ old('email') }}" required autocomplete="email">
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-sm text-rose-400" />
                    </div>

                    <div>
                        <label for="password" class="label">وشەی نهێنی</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" x-model="password" class="field text-left pr-12" dir="ltr" required autocomplete="new-password" @keydown.enter="submit">
                            <button type="button" @click="togglePassword" class="absolute inset-y-0 right-3 flex items-center text-zinc-500 hover:text-cyan-400 transition-colors" aria-label="Show password">
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.955 9.955 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-sm text-rose-400" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="label">دووبارە کردنەوەی وشەی نهێنی</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="field text-left" dir="ltr" required autocomplete="new-password" @keydown.enter="submit">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-sm text-rose-400" />
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <a href="{{ route('login') }}" class="text-sm text-zinc-500 hover:text-cyan-400 transition-colors font-mono tracking-wider">پێشتر تۆمارکراووە؟</a>

                    <button type="submit" class="btn btn-primary py-3 px-6 text-sm" :disabled="loading">
                        <span x-show="!loading">دروستکردنی هەژمار</span>
                        <span x-show="loading" class="flex items-center justify-center gap-2">
                            <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
                            چاوەڕوان بە...
                        </span>
                    </button>
                </div>
            </form>
        @endslot
    @endcomponent

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('registerForm', () => ({
                name: '',
                email: '',
                password: '',
                showPassword: false,
                loading: false,

                togglePassword() {
                    this.showPassword = !this.showPassword;
                    const input = document.getElementById('password');
                    input.type = this.showPassword ? 'text' : 'password';
                },

                async submit() {
                    this.loading = true;
                    try {
                        // Form will submit naturally via Laravel
                        this.$el.submit();
                    } catch (error) {
                        this.loading = false;
                    }
                }
            }));
        });
    </script>

    @stack('scripts')
@endsection

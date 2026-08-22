@extends('layouts.app')

@section('title', 'وشەی نهێنی بیرچووە؟ — ALPHA/AI')

@section('content')
    @include('partials.auth-background')

    @component('partials.auth-card')
        @slot('header')
            <div class="w-14 h-14 mx-auto mb-4 rounded-xl bg-gradient-to-br from-cyan-400 to-violet-600 border-2 border-cyan-400/50 flex items-center justify-center shadow-[0_0_30px_rgba(34,229,255,0.4)] text-neutral-950 font-black text-xl font-mega">A</div>
            <h2 class="font-mega text-3xl tracking-wide text-zinc-100 mb-1">وشەی نهێنی بیرچووە؟</h2>
            <p class="text-zinc-500 font-mono text-xs tracking-widest mt-2">ئیمێڵەکەت بنووسە، لینکی گۆڕین بۆت ناردن</p>
        @endslot

        @slot('body')
            <div class="mb-6 text-sm text-zinc-400 text-center leading-relaxed">
                وشەی نهێنیت بیرچووە؟ کێشەیەک نییە. تەنها ئیمێڵەکەت بنووسە، ئێمە لینکی گۆڕینی وشەی نهێنی بۆت ناردن کە دەتوانیت وشەیەکی نوێ هەڵبژێرێت.
            </div>

            <x-auth-session-status class="mb-6" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" x-data="forgotForm()" @submit.prevent="submit">
                @csrf

                <div>
                    <label for="email" class="label">ئیمێڵ</label>
                    <input type="email" id="email" name="email" x-model="email" class="field text-left" dir="ltr" value="{{ old('email') }}" required autofocus autocomplete="email">
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-sm text-rose-400" />
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full btn btn-primary py-3.5 text-sm" :disabled="loading">
                        <span x-show="!loading">ناردنی لینکی گۆڕین</span>
                        <span x-show="loading" class="flex items-center justify-center gap-2">
                            <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
                            چاوەڕوان بە...
                        </span>
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm text-zinc-500 hover:text-cyan-400 transition-colors font-mono tracking-wider">گەڕانەوە بۆ چوونەژوورەوە</a>
            </div>
        @endslot
    @endcomponent

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('forgotForm', () => ({
                email: '',
                loading: false,

                async submit() {
                    this.loading = true;
                    try {
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

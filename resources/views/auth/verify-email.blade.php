@extends('layouts.app')

@section('title', 'پشتڕاستکردنەوەی ئیمێڵ — ALPHA/AI')

@section('content')
    @include('partials.auth-background')

    @component('partials.auth-card')
        @slot('header')
            <div class="w-14 h-14 mx-auto mb-4 rounded-xl bg-gradient-to-br from-cyan-400 to-violet-600 border-2 border-cyan-400/50 flex items-center justify-center shadow-[0_0_30px_rgba(34,229,255,0.4)] text-neutral-950 font-black text-xl font-mega">A</div>
            <h2 class="font-mega text-3xl tracking-wide text-zinc-100 mb-1">پشتڕاستکردنەوەی ئیمێڵ</h2>
            <p class="text-zinc-500 font-mono text-xs tracking-widest mt-2">پێش لە دەستپێکردن، ئیمێڵەکەت پشتڕاست بکەرەوە</p>
        @endslot

        @slot('body')
            <div class="mb-6 text-sm text-zinc-400 text-center leading-relaxed">
                سوپاس بۆ تۆمارکردن! پێش لە دەستپێکردن، تکایە ئیمێڵەکەت پشتڕاست بکەرەوە بە کلیککردن لەسەر لینکەکەی ناردوومان بۆت. ئەگەر نامەکە نەوەردووە، دەتوانین یەکێکی تر بۆت ناردن.
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 p-3 rounded-lg bg-cyan-500/10 text-cyan-400 text-sm font-medium text-center border border-cyan-500/30">
                    لینکی نوێی پشتڕاستکردنەوە نێردرا بۆ ئیمێڵەکەت کە لە کاتی تۆمارکردندا ناردووە.
                </div>
            @endif

            <div class="flex flex-col sm:flex-row gap-3">
                <form method="POST" action="{{ route('verification.send') }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full btn btn-primary py-3.5 text-sm" x-data="{loading: false}" @click="loading = true">
                        <span x-show="!loading">دووبارە ناردنی ئیمێڵی پشتڕاستکردنەوە</span>
                        <span x-show="loading" class="flex items-center justify-center gap-2">
                            <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
                            چاوەڕوان بە...
                        </span>
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full btn btn-ghost py-3.5 text-sm">
                        چوونەدەرەوە
                    </button>
                </form>
            </div>
        @endslot
    @endcomponent

    @stack('scripts')
@endsection

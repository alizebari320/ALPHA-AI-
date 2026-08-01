@extends('layouts.app')

@section('title', 'زیادکردنی کۆرس — ALPHA/AI')

@section('content')
@include('partials.nav', ['active' => 'courses'])
<div id="page-shell" style="display:none">


    <div class="tech-glow w-96 h-96 bg-gold/20 -top-20 right-1/4"></div>

    <div class="card p-8 w-full max-w-md relative z-10 anim-slide-up" style="display: block;">
        <div class="text-center mb-8">
            <div class="w-14 h-14 mx-auto mb-4 bg-gradient-to-br from-amber-400 to-amber-600 rounded-2xl flex items-center justify-center shadow-lg shadow-amber-700/30">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
            <h2 class="text-2xl font-black font-display glow-text mb-1">زیادکردنی کۆرسی نوێ</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">زانیاری کۆرسەکە پڕبکەرەوە و بیارژێنە بۆ داتابەیس</p>
        </div>

        @if(session('success'))
            <div class="bg-gold/10 border border-gold/30 text-amber-800 dark:text-gold px-4 py-3 rounded-xl mb-4 text-center font-bold text-sm anim-fade-in">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('store.course') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="tech-label">ناوی کۆرس</label>
                <input type="text" name="title" required placeholder="نموونە: کۆرسی فڵەتەر" class="tech-input">
            </div>

            <div class="mb-4">
                <label class="tech-label">بەستەری ڤیدیۆ (URL)</label>
                <input type="url" name="video_url" required placeholder="https://youtube.com/..." class="tech-input" dir="ltr">
            </div>

            <div class="mb-6">
                <label class="tech-label">نرخ (بە دۆلار)</label>
                <input type="number" name="price" required placeholder="بۆ خۆڕایی بنووسە 0" class="tech-input" dir="ltr">
            </div>

            <button type="submit" class="btn btn-primary w-full !py-3.5">
                ناردن بۆ فایەربەیس
            </button>
        </form>
    </div>

@include('partials.footer')
</div>
@endsection
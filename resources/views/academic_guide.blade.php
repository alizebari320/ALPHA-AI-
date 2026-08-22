@extends('layouts.app')

@section('title', 'ڕێنیشاندەر — ALPHA/AI')

@section('content')
<div class="min-h-screen bg-void text-zinc-100 overflow-hidden">

    {{-- Hero --}}
    <section class="relative overflow-hidden border-b-2 border-edge">
        <div class="absolute -top-28 -start-1/3 w-[500px] h-[500px] rounded-full bg-emerald-400/10 blur-[160px] pointer-events-none"></div>
        <div class="absolute -bottom-20 -end-1/3 w-[400px] h-[400px] rounded-full bg-cyan-400/10 blur-[140px] pointer-events-none"></div>
        <div class="relative max-w-7xl mx-auto px-4 py-20 sm:py-28 lg:py-32">
            <p class="font-mono text-[11px] uppercase tracking-[0.3em] text-emerald-400 mb-4">// {{ __('Academic Guide') }}</p>
            <h1 class="font-mega text-5xl sm:text-7xl lg:text-8xl tracking-tight leading-[0.92] mb-6">
                <span class="text-white">ڕێنیشاندەری</span><br>
                <span class="bg-gradient-to-r from-emerald-400 via-cyan-400 to-violet-400 bg-clip-text text-transparent animate-gradient-x">{{ __('AI Studies') }}</span>
            </h1>
            <p class="max-w-2xl text-zinc-400 text-lg leading-relaxed">{{ __('University programs, FAQs, and career guidance for AI studies. Curated for Kurdish students worldwide.') }}</p>
        </div>
    </section>

    {{-- Filter Bar --}}
    <section class="sticky top-16 z-30 bg-void/80 backdrop-blur-xl border-b-2 border-edge">
        <div class="max-w-7xl mx-auto px-4 py-4 flex flex-wrap items-center gap-3 overflow-x-auto">
            <span class="font-mono text-[10px] uppercase tracking-widest text-zinc-600 shrink-0">{{ __('Topic') }}</span>
            <button onclick="filterGuide('all', this)" class="guide-filter px-4 py-2 rounded-lg border-2 border-emerald-400 bg-emerald-400/15 text-emerald-300 font-mono text-[11px] uppercase tracking-wider transition-all hover:-translate-y-0.5 shrink-0">{{ __('All') }}</button>
            <button onclick="filterGuide('faq', this)" class="guide-filter px-4 py-2 rounded-lg border-2 border-edge bg-surface text-zinc-400 font-mono text-[11px] uppercase tracking-wider transition-all hover:border-violet-400/50 hover:text-violet-300 hover:-translate-y-0.5 shrink-0">{{ __('FAQ') }}</button>
            <button onclick="filterGuide('career', this)" class="guide-filter px-4 py-2 rounded-lg border-2 border-edge bg-surface text-zinc-400 font-mono text-[11px] uppercase tracking-wider transition-all hover:border-cyan-400/50 hover:text-cyan-300 hover:-translate-y-0.5 shrink-0">{{ __('Career') }}</button>
            <button onclick="filterGuide('program', this)" class="guide-filter px-4 py-2 rounded-lg border-2 border-edge bg-surface text-zinc-400 font-mono text-[11px] uppercase tracking-wider transition-all hover:border-pink-400/50 hover:text-pink-300 hover:-translate-y-0.5 shrink-0">{{ __('Programs') }}</button>
        </div>
    </section>

    {{-- Guide Cards --}}
    <main class="max-w-7xl mx-auto px-4 py-12">
        <div id="guide-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $guides = [
                    ['title'=>'What is AI?', 'cat'=>'faq', 'tag'=>'FAQ'],
                    ['title'=>'AI Career Paths', 'cat'=>'career', 'tag'=>'Career'],
                    ['title'=>'Best AI Degrees', 'cat'=>'program', 'tag'=>'Program'],
                    ['title'=>'Scholarships Guide', 'cat'=>'program', 'tag'=>'Program'],
                    ['title'=>'AI vs ML Difference', 'cat'=>'faq', 'tag'=>'FAQ'],
                    ['title'=>'Remote AI Jobs', 'cat'=>'career', 'tag'=>'Career'],
                ];
            @endphp
            @foreach ($guides as $g)
            <article data-category="{{ $g['cat'] }}" class="group relative bg-card/60 border-2 border-edge rounded-2xl overflow-hidden transition-all duration-500 hover:border-emerald-400/50 hover:-translate-y-1.5 hover:shadow-[0_20px_50px_-12px_rgba(163,255,60,0.12)]">
                <div class="p-7">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-2.5 py-1 rounded-md border border-emerald-400/30 bg-emerald-400/10 text-emerald-300 font-mono text-[10px] uppercase tracking-wider">{{ $g['tag'] }}</span>
                    </div>
                    <h3 class="font-mega text-xl tracking-wide text-white mb-3 group-hover:text-emerald-300 transition-colors">{{ $g['title'] }}</h3>
                    <p class="text-zinc-400 text-sm leading-relaxed mb-5">{{ __('Detailed guidance and curated resources to help you navigate AI studies with confidence.') }}</p>
                    <a href="#" class="inline-flex items-center gap-2 text-emerald-300 text-sm font-display font-semibold hover:text-emerald-200 transition-colors">
                        {{ __('Read guide') }} <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-emerald-400/60 via-cyan-400/60 to-violet-400/60 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            </article>
            @endforeach
        </div>
    </main>
</div>

@push('styles')
<style>
    @keyframes gradientX { 0%,100%{background-position:0% 50%} 50%{background-position:100% 50%} }
    .animate-gradient-x { background-size:200% 200%; animation:gradientX 8s ease infinite; }
</style>
@endpush

@push('scripts')
<script>
    function filterGuide(category, btn) {
        document.querySelectorAll('.guide-filter').forEach(b => {
            b.classList.remove('border-emerald-400','bg-emerald-400/15','text-emerald-300');
            b.classList.add('border-edge','bg-surface','text-zinc-400');
        });
        btn.classList.remove('border-edge','bg-surface','text-zinc-400');
        btn.classList.add('border-emerald-400','bg-emerald-400/15','text-emerald-300');
        document.querySelectorAll('#guide-grid > article').forEach(card => {
            const match = category === 'all' || card.dataset.category === category;
            card.style.display = match ? '' : 'none';
        });
    }
</script>
@endpush
@endsection

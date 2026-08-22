@extends('layouts.app')

@section('title', 'زانکۆکان — ALPHA/AI')

@section('content')
<div class="min-h-screen bg-void text-zinc-100 overflow-hidden">

    {{-- Hero --}}
    <section class="relative overflow-hidden border-b-2 border-edge">
        <div class="absolute -top-24 start-1/4 w-[500px] h-[500px] rounded-full bg-lime-400/10 blur-[150px] pointer-events-none"></div>
        <div class="absolute -bottom-20 -end-1/3 w-[500px] h-[500px] rounded-full bg-cyan-400/10 blur-[140px] pointer-events-none"></div>
        <div class="relative max-w-7xl mx-auto px-4 py-20 sm:py-28 lg:py-32">
            <p class="font-mono text-[11px] uppercase tracking-[0.3em] text-lime-400 mb-4">// {{ __('Academic Guide') }}</p>
            <h1 class="font-mega text-5xl sm:text-7xl lg:text-8xl tracking-tight leading-[0.92] mb-6">
                <span class="text-white">زانکۆکانی</span><br>
                <span class="bg-gradient-to-r from-lime-400 via-cyan-400 to-violet-400 bg-clip-text text-transparent animate-gradient-x">{{ __('AI Programs') }}</span>
            </h1>
            <p class="max-w-2xl text-zinc-400 text-lg leading-relaxed">{{ __('Explore universities offering AI and computer science degrees, with guidance tailored for Kurdish students.') }}</p>
        </div>
    </section>

    {{-- Search & Filter --}}
    <section class="sticky top-16 z-30 bg-void/80 backdrop-blur-xl border-b-2 border-edge">
        <div class="max-w-7xl mx-auto px-4 py-4 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[260px]">
                <input id="uni-search" type="search" placeholder="{{ __('Search universities...') }}" class="w-full ps-4 pe-4 py-2.5 rounded-lg bg-card border-2 border-edge text-zinc-100 placeholder:text-zinc-600 focus:border-cyan-400 focus:outline-none transition-all text-sm" oninput="searchUniversities(this.value)">
            </div>
            <div class="flex gap-2 overflow-x-auto pb-1">
                <button onclick="filterUni('all', this)" class="uni-filter px-3 py-2 rounded-lg border-2 border-cyan-400 bg-cyan-400/15 text-cyan-300 font-mono text-[11px] uppercase tracking-wider transition-all hover:-translate-y-0.5 shrink-0">{{ __('All') }}</button>
                <button onclick="filterUni('kurdistan', this)" class="uni-filter px-3 py-2 rounded-lg border-2 border-edge bg-surface text-zinc-400 font-mono text-[11px] uppercase tracking-wider transition-all hover:border-lime-400/50 hover:text-lime-300 hover:-translate-y-0.5 shrink-0">{{ __('Kurdistan') }}</button>
                <button onclick="filterUni('europe', this)" class="uni-filter px-3 py-2 rounded-lg border-2 border-edge bg-surface text-zinc-400 font-mono text-[11px] uppercase tracking-wider transition-all hover:border-violet-400/50 hover:text-violet-300 hover:-translate-y-0.5 shrink-0">{{ __('Europe') }}</button>
                <button onclick="filterUni('north_america', this)" class="uni-filter px-3 py-2 rounded-lg border-2 border-edge bg-surface text-zinc-400 font-mono text-[11px] uppercase tracking-wider transition-all hover:border-pink-400/50 hover:text-pink-300 hover:-translate-y-0.5 shrink-0">{{ __('N. America') }}</button>
            </div>
        </div>
    </section>

    {{-- University Cards --}}
    <main class="max-w-7xl mx-auto px-4 py-12">
        <div id="uni-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $unis = [
                    ['name'=>'Salahaddin University', 'region'=>'kurdistan', 'program'=>'BS AI & Data Science', 'desc'=>'Top-rated AI program in Erbil with research partnerships across Europe.'],
                    ['name'=>'University of Duhok', 'region'=>'kurdistan', 'program'=>'MS Machine Learning', 'desc'=>'Graduate-level machine learning with Kurdish-language data applications.'],
                    ['name'=>'TU Berlin', 'region'=>'europe', 'program'=>'MSc Artificial Intelligence', 'desc'=>'World-leading AI research with scholarship tracks for international students.'],
                    ['name'=>'University of Oxford', 'region'=>'europe', 'program'=>'BA Computer Science & AI', 'desc'=>'Rigorous theoretical and applied AI curriculum with industry placement.'],
                    ['name'=>'MIT', 'region'=>'north_america', 'program'=>'BS Computer Science & AI', 'desc'=>'Pioneering AI lab and interdisciplinary AI ethics and policy studies.'],
                    ['name'=>'Stanford University', 'region'=>'north_america', 'program'=>'MS AI Systems', 'desc'=>'Systems-focused AI engineering with Silicon Valley industry integration.'],
                ];
            @endphp
            @foreach ($unis as $uni)
            <article data-region="{{ $uni['region'] }}" class="group relative bg-card/60 border-2 border-edge rounded-2xl overflow-hidden transition-all duration-500 hover:border-cyan-400/50 hover:-translate-y-1.5 hover:shadow-[0_20px_50px_-12px_rgba(34,229,255,0.12)]">
                <div class="p-7">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-cyan-500/20 to-violet-500/20 border border-cyan-400/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                        </div>
                        <span class="font-mono text-[10px] uppercase tracking-widest text-zinc-500">{{ $uni['region'] }}</span>
                    </div>
                    <h3 class="font-mega text-xl tracking-wide text-white mb-2 group-hover:text-cyan-300 transition-colors">{{ $uni['name'] }}</h3>
                    <span class="inline-block mb-3 px-2.5 py-0.5 rounded-md border border-violet-400/30 bg-violet-400/10 text-violet-300 font-mono text-[10px] uppercase tracking-wider">{{ $uni['program'] }}</span>
                    <p class="text-zinc-400 text-sm leading-relaxed">{{ $uni['desc'] }}</p>
                </div>
                <a href="#" class="absolute bottom-0 left-0 right-0 px-7 py-4 bg-gradient-to-t from-card/90 to-transparent border-t border-edge/40 text-cyan-300 font-display text-sm font-semibold hover:text-cyan-200 transition-colors flex items-center gap-2 opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 duration-300">
                    {{ __('View details') }} <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
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
    function filterUni(region, btn) {
        document.querySelectorAll('.uni-filter').forEach(b => {
            b.classList.remove('border-cyan-400','bg-cyan-400/15','text-cyan-300');
            b.classList.add('border-edge','bg-surface','text-zinc-400');
        });
        btn.classList.remove('border-edge','bg-surface','text-zinc-400');
        btn.classList.add('border-cyan-400','bg-cyan-400/15','text-cyan-300');
        applyUniFilters();
    }
    function searchUniversities(query) {
        query = query.toLowerCase();
        document.querySelectorAll('#uni-grid > article').forEach(card => {
            const region = card.dataset.region;
            const text = card.innerText.toLowerCase();
            const visible = (region === 'all' || region === document.querySelector('.uni-filter.border-cyan-400')?.dataset?.region || 'all') && (query === '' || text.includes(query));
            card.style.display = visible ? '' : 'none';
        });
    }
    function applyUniFilters() {
        const active = document.querySelector('.uni-filter.border-cyan-400');
        const region = active ? (active.innerText.toLowerCase() === 'all' ? 'all' : active.innerText.toLowerCase().replace(/[^a-z_]/g,'')) : 'all';
        document.querySelectorAll('#uni-grid > article').forEach(card => {
            const match = region === 'all' || card.dataset.region === (region === 'north_america' ? 'north_america' : region === 'kurdistan' ? 'kurdistan' : region === 'europe' ? 'europe' : region);
            card.style.display = match ? '' : 'none';
        });
    }
</script>
@endpush
@endsection

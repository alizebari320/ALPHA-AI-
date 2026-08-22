@extends('layouts.app')

@section('title', 'هەواڵەکان — ALPHA/AI')

@section('content')
<div class="min-h-screen bg-void text-zinc-100 overflow-hidden">

    {{-- Hero --}}
    <section class="relative overflow-hidden border-b-2 border-edge">
        <div class="absolute -top-20 start-1/3 w-[600px] h-[600px] rounded-full bg-violet-400/10 blur-[180px] pointer-events-none"></div>
        <div class="absolute top-10 end-10 w-[300px] h-[300px] rounded-full bg-pink-400/10 blur-[120px] pointer-events-none"></div>
        <div class="relative max-w-7xl mx-auto px-4 py-20 sm:py-28 lg:py-32">
            <p class="font-mono text-[11px] uppercase tracking-[0.3em] text-violet-400 mb-4">// {{ __('Latest Insights') }}</p>
            <h1 class="font-mega text-5xl sm:text-7xl lg:text-8xl tracking-tight leading-[0.92] mb-6">
                <span class="text-white">هەواڵەکانی</span><br>
                <span class="bg-gradient-to-r from-violet-400 via-pink-400 to-cyan-400 bg-clip-text text-transparent animate-gradient-x">{{ __('AI Intelligence') }}</span>
            </h1>
            <p class="max-w-2xl text-zinc-400 text-lg leading-relaxed">{{ __('Curated news from the frontier of artificial intelligence — breakthroughs, releases, and analysis.') }}</p>
        </div>
    </section>

    {{-- Filter Bar --}}
    <section class="sticky top-16 z-30 bg-void/80 backdrop-blur-xl border-b-2 border-edge">
        <div class="max-w-7xl mx-auto px-4 py-4 flex flex-wrap items-center gap-3 overflow-x-auto">
            <span class="font-mono text-[10px] uppercase tracking-widest text-zinc-600 shrink-0">{{ __('Filter') }}</span>
            <button onclick="filterNews('all', this)" class="filter-btn px-4 py-2 rounded-lg border-2 border-cyan-400 bg-cyan-400/15 text-cyan-300 font-mono text-[11px] uppercase tracking-wider transition-all hover:-translate-y-0.5">{{ __('All') }}</button>
            <button onclick="filterNews('research', this)" class="filter-btn px-4 py-2 rounded-lg border-2 border-edge bg-surface text-zinc-400 font-mono text-[11px] uppercase tracking-wider transition-all hover:border-violet-400/50 hover:text-violet-300 hover:-translate-y-0.5">{{ __('Research') }}</button>
            <button onclick="filterNews('industry', this)" class="filter-btn px-4 py-2 rounded-lg border-2 border-edge bg-surface text-zinc-400 font-mono text-[11px] uppercase tracking-wider transition-all hover:border-pink-400/50 hover:text-pink-300 hover:-translate-y-0.5">{{ __('Industry') }}</button>
            <button onclick="filterNews('tools', this)" class="filter-btn px-4 py-2 rounded-lg border-2 border-edge bg-surface text-zinc-400 font-mono text-[11px] uppercase tracking-wider transition-all hover:border-cyan-400/50 hover:text-cyan-300 hover:-translate-y-0.5">{{ __('Tools') }}</button>
        </div>
    </section>

    {{-- News Grid --}}
    <main class="max-w-7xl mx-auto px-4 py-12">
        <div id="news-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $demoNews = [
                    ['title'=>'GPT-5 Architecture Revealed', 'cat'=>'research', 'date'=>'2026-08-01', 'tag'=>'OpenAI'],
                    ['title'=>'New Kurdish NLP Model Released', 'cat'=>'tools', 'date'=>'2026-07-28', 'tag'=>'Local AI'],
                    ['title'=>'EU AI Act Compliance Guide', 'cat'=>'industry', 'date'=>'2026-07-15', 'tag'=>'Policy'],
                    ['title'=>'Multimodal Learning Breakthrough', 'cat'=>'research', 'date'=>'2026-07-10', 'tag'=>'Science'],
                    ['title'=>'Alpha/AI Launches Tool Directory', 'cat'=>'tools', 'date'=>'2026-07-05', 'tag'=>'Product'],
                    ['title'=>'AI Safety Summit 2026 Summary', 'cat'=>'industry', 'date'=>'2026-06-22', 'tag'=>'Policy'],
                ];
            @endphp
            @foreach ($demoNews as $item)
            <article data-category="{{ $item['cat'] }}" class="group relative bg-card/60 border-2 border-edge rounded-2xl overflow-hidden transition-all duration-500 hover:border-violet-400/50 hover:-translate-y-1.5 hover:shadow-[0_20px_50px_-12px_rgba(139,92,255,0.15)]">
                <div class="p-7">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-2.5 py-1 rounded-md border border-violet-400/30 bg-violet-400/10 text-violet-300 font-mono text-[10px] uppercase tracking-wider">{{ $item['tag'] }}</span>
                        <span class="font-mono text-[10px] text-zinc-500">{{ $item['date'] }}</span>
                    </div>
                    <h3 class="font-mega text-xl tracking-wide text-white mb-3 group-hover:text-violet-300 transition-colors">{{ $item['title'] }}</h3>
                    <p class="text-zinc-400 text-sm leading-relaxed mb-5">{{ __('Read the full analysis and discover how this update affects the AI landscape in the region.') }}</p>
                    <a href="#" class="inline-flex items-center gap-2 text-violet-400 text-sm font-display font-semibold hover:text-violet-300 transition-colors">
                        {{ __('Read more') }} <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-violet-400/60 via-pink-400/60 to-cyan-400/60 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
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
    function filterNews(category, btn) {
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('border-cyan-400','bg-cyan-400/15','text-cyan-300','border-violet-400/50','text-violet-300','border-pink-400/50','text-pink-300');
            b.classList.add('border-edge','bg-surface','text-zinc-400');
        });
        btn.classList.remove('border-edge','bg-surface','text-zinc-400');
        btn.classList.add('border-cyan-400','bg-cyan-400/15','text-cyan-300');

        document.querySelectorAll('#news-grid > article').forEach(card => {
            const match = category === 'all' || card.dataset.category === category;
            card.style.display = match ? '' : 'none';
            if (match) {
                card.classList.remove('animate-card-in');
                void card.offsetWidth;
                card.classList.add('animate-card-in');
            }
        });
    }
</script>
@endpush
@endsection

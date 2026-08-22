@extends('layouts.app')

@section('title', 'تووڵەکان — ALPHA/AI')

@section('content')
<div class="min-h-screen bg-void text-zinc-100 overflow-hidden">

    {{-- Hero --}}
    <section class="relative overflow-hidden border-b-2 border-edge">
        <div class="absolute -top-20 start-1/3 w-[500px] h-[500px] rounded-full bg-pink-400/10 blur-[180px] pointer-events-none"></div>
        <div class="absolute -bottom-16 -end-1/3 w-[400px] h-[400px] rounded-full bg-cyan-400/10 blur-[140px] pointer-events-none"></div>
        <div class="relative max-w-7xl mx-auto px-4 py-20 sm:py-28 lg:py-32">
            <p class="font-mono text-[11px] uppercase tracking-[0.3em] text-pink-400 mb-4">// {{ __('AI Tools') }}</p>
            <h1 class="font-mega text-5xl sm:text-7xl lg:text-8xl tracking-tight leading-[0.92] mb-6">
                <span class="text-white">ئامرازەکانی</span><br>
                <span class="bg-gradient-to-r from-pink-400 via-violet-400 to-cyan-400 bg-clip-text text-transparent animate-gradient-x">{{ __('Artificial Intelligence') }}</span>
            </h1>
            <p class="max-w-2xl text-zinc-400 text-lg leading-relaxed">{{ __('A curated selection of AI tools for development, design, writing, and research.') }}</p>
        </div>
    </section>

    {{-- Filter Bar --}}
    <section class="sticky top-16 z-30 bg-void/80 backdrop-blur-xl border-b-2 border-edge">
        <div class="max-w-7xl mx-auto px-4 py-4 flex flex-wrap items-center gap-3 overflow-x-auto">
            <span class="font-mono text-[10px] uppercase tracking-widest text-zinc-600 shrink-0">{{ __('Category') }}</span>
            <button onclick="filterAi('all', this)" class="ai-filter px-4 py-2 rounded-lg border-2 border-cyan-400 bg-cyan-400/15 text-cyan-300 font-mono text-[11px] uppercase tracking-wider transition-all hover:-translate-y-0.5 shrink-0">{{ __('All') }}</button>
            <button onclick="filterAi('development', this)" class="ai-filter px-4 py-2 rounded-lg border-2 border-edge bg-surface text-zinc-400 font-mono text-[11px] uppercase tracking-wider transition-all hover:border-violet-400/50 hover:text-violet-300 hover:-translate-y-0.5 shrink-0">{{ __('Dev') }}</button>
            <button onclick="filterAi('design', this)" class="ai-filter px-4 py-2 rounded-lg border-2 border-edge bg-surface text-zinc-400 font-mono text-[11px] uppercase tracking-wider transition-all hover:border-pink-400/50 hover:text-pink-300 hover:-translate-y-0.5 shrink-0">{{ __('Design') }}</button>
            <button onclick="filterAi('writing', this)" class="ai-filter px-4 py-2 rounded-lg border-2 border-edge bg-surface text-zinc-400 font-mono text-[11px] uppercase tracking-wider transition-all hover:border-cyan-400/50 hover:text-cyan-300 hover:-translate-y-0.5 shrink-0">{{ __('Writing') }}</button>
        </div>
    </section>

    {{-- Card Grid --}}
    <main class="max-w-7xl mx-auto px-4 py-12">
        <div id="ai-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $aiTools = [
                    ['name'=>'CodePilot AI', 'cat'=>'development', 'tag'=>'Code Assistant'],
                    ['name'=>'Canvas Synth', 'cat'=>'design', 'tag'=>'Image Gen'],
                    ['name'=>'Narrative Forge', 'cat'=>'writing', 'tag'=>'Content'],
                    ['name'=>'DataLens', 'cat'=>'development', 'tag'=>'Analytics'],
                    ['name'=>'Palette AI', 'cat'=>'design', 'tag'=>'Color'],
                    ['name'=>'Verse Engine', 'cat'=>'writing', 'tag'=>'Poetry'],
                ];
            @endphp
            @foreach ($aiTools as $tool)
            <article data-category="{{ $tool['cat'] }}" class="group relative bg-card/60 border-2 border-edge rounded-2xl overflow-hidden transition-all duration-500 hover:border-pink-400/50 hover:-translate-y-1.5 hover:shadow-[0_20px_50px_-12px_rgba(255,47,185,0.12)]">
                <div class="p-7">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-pink-500/20 to-violet-500/20 border border-pink-400/30 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-pink-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="font-mega text-xl tracking-wide text-white mb-1 group-hover:text-pink-300 transition-colors">{{ $tool['name'] }}</h3>
                    <span class="inline-block mb-4 px-2.5 py-0.5 rounded-md border border-cyan-400/30 bg-cyan-400/10 text-cyan-300 font-mono text-[10px] uppercase tracking-wider">{{ $tool['tag'] }}</span>
                    <p class="text-zinc-400 text-sm leading-relaxed">{{ __('A cutting-edge AI tool built for modern creators. Explore features, compare ratings, and start using it today.') }}</p>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-pink-400/60 via-violet-400/60 to-cyan-400/60 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
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
    function filterAi(category, btn) {
        document.querySelectorAll('.ai-filter').forEach(b => {
            b.classList.remove('border-cyan-400','bg-cyan-400/15','text-cyan-300');
            b.classList.add('border-edge','bg-surface','text-zinc-400');
        });
        btn.classList.remove('border-edge','bg-surface','text-zinc-400');
        btn.classList.add('border-cyan-400','bg-cyan-400/15','text-cyan-300');
        document.querySelectorAll('#ai-grid > article').forEach(card => {
            const match = category === 'all' || card.dataset.category === category;
            card.style.display = match ? '' : 'none';
        });
    }
</script>
@endpush
@endsection

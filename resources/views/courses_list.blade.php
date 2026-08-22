@extends('layouts.app')

@section('title', 'کۆرسەکان — ALPHA/AI')

@section('content')
<div class="min-h-screen bg-void text-zinc-100 overflow-hidden">

    {{-- Hero --}}
    <section class="relative overflow-hidden border-b-2 border-edge">
        <div class="absolute -top-28 -start-1/3 w-[500px] h-[500px] rounded-full bg-violet-400/10 blur-[160px] pointer-events-none"></div>
        <div class="absolute -bottom-16 -end-1/4 w-[400px] h-[400px] rounded-full bg-cyan-400/10 blur-[120px] pointer-events-none"></div>
        <div class="relative max-w-7xl mx-auto px-4 py-20 sm:py-28 lg:py-32">
            <p class="font-mono text-[11px] uppercase tracking-[0.3em] text-violet-400 mb-4">// {{ __('Structured Learning') }}</p>
            <h1 class="font-mega text-5xl sm:text-7xl lg:text-8xl tracking-tight leading-[0.92] mb-6">
                <span class="text-white">کۆرسەکانی</span><br>
                <span class="bg-gradient-to-r from-violet-400 via-cyan-400 to-pink-400 bg-clip-text text-transparent animate-gradient-x">{{ __('AI Education') }}</span>
            </h1>
            <p class="max-w-2xl text-zinc-400 text-lg leading-relaxed">{{ __('Step-by-step video courses with in-browser practice. From programming basics to advanced AI/ML.') }}</p>
        </div>
    </section>

    {{-- Filter + Search --}}
    <section class="sticky top-16 z-30 bg-void/80 backdrop-blur-xl border-b-2 border-edge">
        <div class="max-w-7xl mx-auto px-4 py-4 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[260px]">
                <input id="course-search" type="search" placeholder="{{ __('Search courses...') }}" class="w-full ps-4 pe-4 py-2.5 rounded-lg bg-card border-2 border-edge text-zinc-100 placeholder:text-zinc-600 focus:border-violet-400 focus:outline-none transition-all text-sm" oninput="searchCourses(this.value)">
            </div>
            <div class="flex gap-2 overflow-x-auto pb-1">
                <button onclick="filterCourse('all', this)" class="course-filter px-3 py-2 rounded-lg border-2 border-violet-400 bg-violet-400/15 text-violet-300 font-mono text-[11px] uppercase tracking-wider transition-all hover:-translate-y-0.5 shrink-0">{{ __('All') }}</button>
                <button onclick="filterCourse('beginner', this)" class="course-filter px-3 py-2 rounded-lg border-2 border-edge bg-surface text-zinc-400 font-mono text-[11px] uppercase tracking-wider transition-all hover:border-cyan-400/50 hover:text-cyan-300 hover:-translate-y-0.5 shrink-0">{{ __('Beginner') }}</button>
                <button onclick="filterCourse('intermediate', this)" class="course-filter px-3 py-2 rounded-lg border-2 border-edge bg-surface text-zinc-400 font-mono text-[11px] uppercase tracking-wider transition-all hover:border-violet-400/50 hover:text-violet-300 hover:-translate-y-0.5 shrink-0">{{ __('Intermediate') }}</button>
                <button onclick="filterCourse('advanced', this)" class="course-filter px-3 py-2 rounded-lg border-2 border-edge bg-surface text-zinc-400 font-mono text-[11px] uppercase tracking-wider transition-all hover:border-pink-400/50 hover:text-pink-300 hover:-translate-y-0.5 shrink-0">{{ __('Advanced') }}</button>
            </div>
        </div>
    </section>

    {{-- Course Grid --}}
    <main class="max-w-7xl mx-auto px-4 py-12">
        <div id="course-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $courses = [
                    ['title'=>'Python for AI Beginners', 'level'=>'beginner', 'duration'=>'8 hours', 'tag'=>'Programming'],
                    ['title'=>'Deep Learning Fundamentals', 'level'=>'intermediate', 'duration'=>'12 hours', 'tag'=>'ML'],
                    ['title'=>'Natural Language Processing', 'level'=>'advanced', 'duration'=>'15 hours', 'tag'=>'NLP'],
                    ['title'=>'Computer Vision Essentials', 'level'=>'intermediate', 'duration'=>'10 hours', 'tag'=>'Vision'],
                    ['title'=>'AI Ethics & Policy', 'level'=>'beginner', 'duration'=>'6 hours', 'tag'=>'Policy'],
                    ['title'=>'Reinforcement Learning', 'level'=>'advanced', 'duration'=>'14 hours', 'tag'=>'RL'],
                ];
            @endphp
            @foreach ($courses as $c)
            <article data-level="{{ $c['level'] }}" class="group relative bg-card/60 border-2 border-edge rounded-2xl overflow-hidden transition-all duration-500 hover:border-violet-400/50 hover:-translate-y-1.5 hover:shadow-[0_20px_50px_-12px_rgba(139,92,255,0.12)]">
                <div class="p-7">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-2.5 py-1 rounded-md border border-cyan-400/30 bg-cyan-400/10 text-cyan-300 font-mono text-[10px] uppercase tracking-wider">{{ $c['tag'] }}</span>
                        <span class="font-mono text-[10px] text-zinc-500">{{ $c['duration'] }}</span>
                    </div>
                    <h3 class="font-mega text-xl tracking-wide text-white mb-3 group-hover:text-violet-300 transition-colors">{{ $c['title'] }}</h3>
                    <p class="text-zinc-400 text-sm leading-relaxed mb-5">{{ __('Learn core concepts with guided exercises and real-world AI applications.') }}</p>
                    <a href="#" class="inline-flex items-center gap-2 text-violet-400 text-sm font-display font-semibold hover:text-violet-300 transition-colors">
                        {{ __('Start course') }} <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-violet-400/60 via-cyan-400/60 to-pink-400/60 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
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
    function filterCourse(level, btn) {
        document.querySelectorAll('.course-filter').forEach(b => {
            b.classList.remove('border-violet-400','bg-violet-400/15','text-violet-300');
            b.classList.add('border-edge','bg-surface','text-zinc-400');
        });
        btn.classList.remove('border-edge','bg-surface','text-zinc-400');
        btn.classList.add('border-violet-400','bg-violet-400/15','text-violet-300');
        applyCourseFilters();
    }
    function searchCourses(query) {
        query = query.toLowerCase();
        document.querySelectorAll('#course-grid > article').forEach(card => {
            const level = card.dataset.level;
            const text = card.innerText.toLowerCase();
            const activeBtn = document.querySelector('.course-filter.border-violet-400');
            const activeLevel = activeBtn ? (activeBtn.innerText.toLowerCase() === 'all' ? 'all' : activeBtn.innerText.toLowerCase()) : 'all';
            const matchLevel = activeLevel === 'all' || level === activeLevel;
            const matchQuery = text.includes(query);
            card.style.display = (matchLevel && matchQuery) ? '' : 'none';
        });
    }
    function applyCourseFilters() {
        const activeBtn = document.querySelector('.course-filter.border-violet-400');
        const activeLevel = activeBtn ? (activeBtn.innerText.toLowerCase() === 'all' ? 'all' : activeBtn.innerText.toLowerCase()) : 'all';
        document.querySelectorAll('#course-grid > article').forEach(card => {
            const match = activeLevel === 'all' || card.dataset.level === activeLevel;
            card.style.display = match ? '' : 'none';
        });
    }
</script>
@endpush
@endsection

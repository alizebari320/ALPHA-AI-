@extends('layouts.app')

@section('title', 'کۆرسەکان — ALPHA/AI')

@section('content')
<div class="courses-page">

    {{-- Hero --}}
    <section class="courses-hero">
        <div class="courses-hero-grid" aria-hidden="true"></div>
        <div class="container courses-hero-inner">
            <p class="eyebrow"><span class="pulse-dot"></span>{{ __('Structured Learning') }}</p>
            <h1>{{ __('Build skills that') }}<br><span>{{ __('compound.') }}</span></h1>
            <p class="text-balance">{{ __('Step-by-step AI courses with practical exercises, clear learning paths, and Kurdish-first support.') }}</p>
        </div>
    </section>

    {{-- Filter + Search --}}
    <section class="courses-filter-bar">
        <div class="max-w-7xl mx-auto px-4 py-4 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[260px]">
                <input id="course-search" type="search" placeholder="{{ __('Search courses...') }}" class="course-search" oninput="searchCourses(this.value)">
            </div>
            <div class="flex gap-2 overflow-x-auto pb-1">
                <button onclick="filterCourse('all', this)" class="course-filter active">{{ __('All') }}</button>
                <button onclick="filterCourse('beginner', this)" class="course-filter">{{ __('Beginner') }}</button>
                <button onclick="filterCourse('intermediate', this)" class="course-filter">{{ __('Intermediate') }}</button>
                <button onclick="filterCourse('advanced', this)" class="course-filter">{{ __('Advanced') }}</button>
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
            <article data-level="{{ $c['level'] }}" class="course-card group">
                <div class="course-card-body">
                    <div class="flex items-center justify-between mb-4">
                        <span class="course-tag">{{ $c['tag'] }}</span>
                        <span class="course-duration">{{ $c['duration'] }}</span>
                    </div>
                    <h3>{{ $c['title'] }}</h3>
                    <p>{{ __('Learn core concepts with guided exercises and real-world AI applications.') }}</p>
                    <a href="#" class="course-start">
                        {{ __('Start course') }} <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
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
        document.querySelectorAll('.course-filter').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        applyCourseFilters();
    }
    function searchCourses(query) {
        query = query.toLowerCase();
        document.querySelectorAll('#course-grid > article').forEach(card => {
            const level = card.dataset.level;
            const text = card.innerText.toLowerCase();
            const activeBtn = document.querySelector('.course-filter.active');
            const activeLevel = activeBtn ? (activeBtn.innerText.toLowerCase() === 'all' ? 'all' : activeBtn.innerText.toLowerCase()) : 'all';
            const matchLevel = activeLevel === 'all' || level === activeLevel;
            const matchQuery = text.includes(query);
            card.style.display = (matchLevel && matchQuery) ? '' : 'none';
        });
    }
    function applyCourseFilters() {
        const activeBtn = document.querySelector('.course-filter.active');
        const activeLevel = activeBtn ? (activeBtn.innerText.toLowerCase() === 'all' ? 'all' : activeBtn.innerText.toLowerCase()) : 'all';
        document.querySelectorAll('#course-grid > article').forEach(card => {
            const match = activeLevel === 'all' || card.dataset.level === activeLevel;
            card.style.display = match ? '' : 'none';
        });
    }
</script>
@endpush
@endsection

@extends('layouts.app')

@section('title', 'AlphaAi — AI, made understandable')

@section('content')
<div class="alpha-home">
    <section class="hero-signal" aria-labelledby="hero-title">
        <div class="hero-grid" aria-hidden="true"></div>
        <div class="hero-orb hero-orb-one" aria-hidden="true"></div>
        <div class="hero-orb hero-orb-two" aria-hidden="true"></div>
        <div class="container hero-inner">
            <div class="hero-copy reveal">
                <p class="eyebrow"><span class="pulse-dot"></span> {{ __('The Kurdish-first AI platform') }}</p>
                <h1 id="hero-title">The signal<br><em>behind</em> the noise.</h1>
                <p class="hero-lede">{{ __('Discover the tools, knowledge, and ideas shaping tomorrow. Curated for curious minds. Built for the next generation of Kurdish makers.') }}</p>
                <div class="hero-actions">
                    <a href="{{ route('tools.index') }}" class="btn btn-accent btn-lg">{{ __('Explore the directory') }} <span aria-hidden="true">↗</span></a>
                    <a href="/courses" class="text-link">{{ __('Start learning') }} <span aria-hidden="true">→</span></a>
                </div>
            </div>
            <div class="hero-console reveal stagger-2" aria-label="AlphaAi live platform summary">
                <div class="console-top"><span>ALPHAAI / LIVE INDEX</span><span class="console-status"><i></i> ONLINE</span></div>
                <div class="console-ring"><div class="ring-core"><span>AI</span><small>DISCOVER<br>WHAT'S NEXT</small></div></div>
                <div class="console-data"><div><strong>{{ count($tools ?? []) ?: '200' }}</strong><span>tools indexed</span></div><div><strong>04</strong><span>languages</span></div><div><strong>{{ count($courses ?? []) ?: '12' }}</strong><span>learning paths</span></div></div>
                <div class="console-line"><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><b></b></div>
            </div>
        </div>
    </section>

    <section class="section signal-section" aria-labelledby="explore-title">
        <div class="container">
            <div class="section-heading"><div><p class="eyebrow">{{ __('One platform. Many directions.') }}</p><h2 id="explore-title">Find your next <span>advantage.</span></h2></div><p>{{ __('A focused space for learning, building, and staying ahead of the curve.') }}</p></div>
            <div class="category-grid">
                <a href="{{ route('tools.index') }}?category=dev" class="category-card category-cyan"><span class="category-number">01</span><div class="category-icon">⌘</div><h3>{{ __('Build') }}</h3><p>{{ __('Code, ship, automate') }}</p><span class="category-arrow">↗</span></a>
                <a href="{{ route('tools.index') }}?category=design" class="category-card category-violet"><span class="category-number">02</span><div class="category-icon">✦</div><h3>{{ __('Create') }}</h3><p>{{ __('Design, imagine, express') }}</p><span class="category-arrow">↗</span></a>
                <a href="{{ route('tools.index') }}?category=research" class="category-card category-orange"><span class="category-number">03</span><div class="category-icon">⌁</div><h3>{{ __('Understand') }}</h3><p>{{ __('Research, learn, go deeper') }}</p><span class="category-arrow">↗</span></a>
                <a href="/news" class="category-card category-lime"><span class="category-number">04</span><div class="category-icon">◉</div><h3>{{ __('Stay sharp') }}</h3><p>{{ __('Signals, stories, shifts') }}</p><span class="category-arrow">↗</span></a>
            </div>
            <div class="home-product-links"><a href="{{ route('prompts.index') }}"><span>⌁</span><strong>{{ __('Prompt Library') }}</strong><small>{{ __('Start with a better question.') }}</small>↗</a><a href="{{ route('kurdish-ai') }}"><span>ک</span><strong>{{ __('Kurdish AI Hub') }}</strong><small>{{ __('AI resources in your language.') }}</small>↗</a><a href="{{ route('assistant.index') }}"><span>✦</span><strong>{{ __('AlphaAi Assistant') }}</strong><small>{{ __('Find your next best starting point.') }}</small>↗</a></div>
        </div>
    </section>

    @if(count($tools ?? []) > 0)
    <section class="section featured-section" aria-labelledby="featured-title"><div class="container"><div class="section-heading"><div><p class="eyebrow">{{ __('The latest discoveries') }}</p><h2 id="featured-title">Tools worth <span>knowing.</span></h2></div><a href="{{ route('tools.index') }}" class="text-link">{{ __('View all tools') }} →</a></div><div class="tool-strip">
        @foreach(array_slice($tools, 0, 4) as $tool)
        <article class="tool-tile"><div class="tool-tile-top"><span class="tool-index">0{{ $loop->iteration }}</span><span class="chip chip-primary">{{ $tool['category'] ?? 'AI' }}</span></div><div class="tool-avatar">{{ mb_substr($tool['name'], 0, 1) }}</div><h3>{{ $tool['name'] }}</h3><p>{{ Str::limit($tool['tagline'] ?: $tool['description'], 72) }}</p><a href="{{ $tool['website_url'] ?: '#' }}" target="_blank" rel="noopener" class="tool-visit">{{ __('Visit tool') }} ↗</a></article>
        @endforeach
    </div></div></section>
    @endif

    <section class="section home-news-band"><div class="container"><div class="section-heading"><div><p class="eyebrow">{{ __('Always moving') }}</p><h2>{{ __('Stay ahead of the') }} <span>{{ __('shift.') }}</span></h2></div><a href="/news" class="text-link">{{ __('Read the latest') }} →</a></div><div class="home-news-grid"><a href="/news"><span>01 / NEWS</span><h3>{{ __('The tools changing how we work, learn, and create.') }}</h3>↗</a><a href="{{ route('kurdish-ai') }}"><span>02 / HUB</span><h3>{{ __('A Kurdish-first path into the AI economy.') }}</h3>↗</a></div></div></section>

    <section class="manifesto-section"><div class="container manifesto"><p class="eyebrow">{{ __('Made for the in-between moment') }}</p><h2>{{ __('You don’t need more information.') }}<br><span>{{ __('You need the right information.') }}</span></h2><a href="{{ route('tools.index') }}#submit-tool" class="btn btn-outline btn-lg">{{ __('Add your tool to AlphaAi') }} <span>↗</span></a></div></section>
</div>
@endsection

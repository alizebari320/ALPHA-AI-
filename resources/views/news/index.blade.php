@extends('layouts.app')
@section('title', __('AI News').' — AlphaAi')
@section('meta_description', __('Clear, localized AI news and practical updates for Kurdish learners and builders.'))
@section('content')
<div class="product-page"><section class="product-hero"><div class="container"><p class="eyebrow"><span class="pulse-dot"></span>{{ __('Signal feed') }}</p><h1>{{ __('Know what changed.') }}</h1><p>{{ __('Short, useful updates on the tools, research, and ideas moving AI forward.') }}</p></div></section><main class="container product-content"><div class="news-product-grid">@forelse($articles as $article)<article class="news-product-card"><div><span>{{ $article['category'] }}</span><time>{{ \Carbon\Carbon::parse($article['published_at'])->format('M d, Y') }}</time></div><h2>{{ $article['title'] }}</h2><p>{{ Str::limit($article['excerpt'], 170) }}</p><a class="text-link" href="{{ route('news.show', $article['slug']) }}">{{ __('Read story') }} ↗</a></article>@empty<div class="empty-product"><h2>{{ __('No news has been published yet.') }}</h2><p>{{ __('Check back soon for the next signal.') }}</p></div>@endforelse</div></main></div>
@endsection

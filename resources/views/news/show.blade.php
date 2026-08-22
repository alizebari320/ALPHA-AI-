@extends('layouts.app')
@section('title', $article['title'].' — AlphaAi')
@section('meta_description', Str::limit($article['excerpt'], 155))
@section('content')
<div class="product-page"><section class="product-hero"><div class="container"><a class="text-link" href="{{ route('news.index') }}">← {{ __('Back to news') }}</a><p class="eyebrow mt-8">{{ $article['category'] }} · {{ \Carbon\Carbon::parse($article['published_at'])->format('M d, Y') }}</p><h1>{{ $article['title'] }}</h1><p>{{ $article['excerpt'] }}</p></div></section><main class="container article-body"><p>{{ $article['body'] }}</p><div class="article-source"><span>{{ __('Source') }}</span><strong>{{ $article['source'] }}</strong></div></main></div>
@push('head')<script type="application/ld+json">{!! json_encode(['@context'=>'https://schema.org','@type'=>'NewsArticle','headline'=>$article['title'],'description'=>$article['excerpt'],'datePublished'=>$article['published_at'],'url'=>url()->current()]) !!}</script>@endpush
@endsection

@extends('layouts.app')
@section('title', __('Prompt Library').' — AlphaAi')
@section('meta_description', __('Practical prompts for coding, writing, research, study, design, and business.'))
@section('content')
<div class="product-page"><section class="product-hero"><div class="container"><p class="eyebrow"><span class="pulse-dot"></span>{{ __('Prompt Library') }}</p><h1>{{ __('Start with a better question.') }}</h1><p>{{ __('Copy, adapt, and save practical prompts for the work you actually do.') }}</p></div></section><main class="container product-content"><div class="category-nav"><a class="{{ $selectedCategory === '' ? 'selected' : '' }}" href="{{ route('prompts.index') }}">{{ __('All prompts') }}</a>@foreach($categories as $category)<a class="{{ $selectedCategory === $category ? 'selected' : '' }}" href="{{ route('prompts.index', ['category' => $category]) }}">{{ Str::headline($category) }}</a>@endforeach</div><div class="prompt-grid">@forelse($prompts as $prompt)<article class="prompt-card"><div class="prompt-card-top"><span class="chip chip-primary">{{ Str::headline($prompt->category) }}</span><span class="prompt-locale">{{ Str::upper($prompt->locale) }}</span></div><h2>{{ $prompt->title }}</h2><p>{{ Str::limit($prompt->body, 180) }}</p><div class="prompt-card-foot"><span>{{ $prompt->copy_count }} {{ __('copies') }}</span><button type="button" class="btn btn-accent btn-sm" data-copy-prompt="{{ $prompt->id }}">{{ __('Copy prompt') }}</button></div></article>@empty<div class="empty-product"><h2>{{ __('The library is warming up.') }}</h2><p>{{ __('Be the first to publish a useful prompt.') }}</p></div>@endforelse</div>{{ $prompts->links() }}</main></div>
@endsection
@push('scripts')
<script>
document.querySelectorAll('[data-copy-prompt]').forEach((button) => button.addEventListener('click', async () => {
    const response = await fetch('/prompts/' + button.dataset.copyPrompt + '/copy', {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json'},
    });
    const data = await response.json();
    if (data.body) {
        await navigator.clipboard.writeText(data.body);
        button.textContent = 'Copied';
        window.alphaTrack?.('prompt_copy', {entity_type: 'prompt', entity_key: button.dataset.copyPrompt});
    }
}));
</script>
@endpush

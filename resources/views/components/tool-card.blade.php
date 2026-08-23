@props(['tool'])

@php
    $categoryLabels = [
        'dev' => __('Development'),
        'writing' => __('Writing'),
        'design' => __('Design'),
        'audio_video' => __('Audio & Video'),
        'research' => __('Research'),
        'kurdish_ai' => __('Kurdish AI'),
    ];

    $pricingLabels = [
        'free' => __('Free'),
        'freemium' => __('Freemium'),
        'paid' => __('Paid'),
    ];

    $rating = number_format((float) $tool['rating_avg'], 1);
@endphp

<article
    data-tool-card
    data-name="{{ Str::lower($tool['name']) }}"
    data-tagline="{{ Str::lower($tool['tagline']) }}"
    data-description="{{ Str::lower($tool['description']) }}"
    data-category="{{ $tool['category'] }}"
    data-pricing="{{ $tool['pricing_type'] }}"
    data-languages="{{ implode(',', $tool['languages'] ?? ['en', 'ckb', 'badini', 'ar']) }}"
    data-tool="{{ json_encode([
        'id' => $tool['key'],
        'name' => $tool['name'],
        'tagline' => $tool['tagline'],
        'description' => $tool['description'],
        'category' => $categoryLabels[$tool['category']] ?? $tool['category'],
        'pricing' => $pricingLabels[$tool['pricing_type']] ?? $tool['pricing_type'],
        'website_url' => $tool['website_url'],
        'icon_url' => $tool['icon_url'],
        'rating_avg' => (float) $tool['rating_avg'],
        'rating_count' => $tool['rating_count'],
        'views_count' => $tool['views_count'],
        'prompts' => $tool['prompts'],
    ], JSON_UNESCAPED_UNICODE) }}"
    class="tool-directory-card group flex flex-col h-full"
>
    <a class="tool-card-link" href="{{ route('tools.show', $tool['key']) }}" aria-label="{{ __('View') }} {{ $tool['name'] }}"></a>
    <div class="tool-card-head">
        <div class="tool-card-icon">
            @if ($tool['icon_url'])
                <img src="{{ $tool['icon_url'] }}" alt="{{ $tool['name'] }} {{ __('icon') }}" loading="lazy" width="48" height="48" class="w-full h-full object-contain p-2">
            @else
                <span>{{ Str::upper(Str::substr($tool['name'], 0, 1)) }}</span>
            @endif
        </div>

        <div class="min-w-0 flex-1">
            <h3 class="tool-card-name truncate">
                {{ $tool['name'] }}
            </h3>

            @if ($tool['tagline'])
                <p class="tool-card-tagline line-clamp-2">{{ $tool['tagline'] }}</p>
            @endif
        </div>
    </div>

    @if ($tool['description'])
        <p class="tool-card-description line-clamp-3 flex-1">
            {{ $tool['description'] }}
        </p>
    @endif

    <div class="tool-card-meta">
        <span class="chip chip-primary">{{ $categoryLabels[$tool['category']] ?? $tool['category'] }}</span>

        @php
            $pricingClass = match($tool['pricing_type']) {
                'free' => 'chip-success',
                'freemium' => 'chip-primary',
                'paid' => 'chip-accent',
                default => 'chip-primary',
            };
        @endphp
        <span class="chip {{ $pricingClass }}">{{ $pricingLabels[$tool['pricing_type']] ?? $tool['pricing_type'] }}</span>

        <span class="tool-card-stats">
            <span class="flex items-center gap-1" title="{{ __('Rating') }}">
                <svg class="w-3.5 h-3.5 text-accent" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.05 2.93c.3-.92 1.6-.92 1.9 0l1.3 4.01a1 1 0 00.95.69h4.22c.97 0 1.37 1.24.59 1.81l-3.42 2.48a1 1 0 00-.36 1.12l1.3 4.01c.3.92-.75 1.69-1.54 1.12l-3.41-2.48a1 1 0 00-1.18 0l-3.41 2.48c-.79.57-1.84-.2-1.54-1.12l1.3-4.01a1 1 0 00-.36-1.12L2.0 9.44c-.79-.57-.38-1.81.59-1.81h4.22a1 1 0 00.95-.69l1.29-4.01z"/>
                </svg>
                {{ $rating }}
            </span>
            <span class="flex items-center gap-1" title="{{ __('Views') }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12S5.8 5.5 12 5.5 21.5 12 21.5 12 18.2 18.5 12 18.5 2.5 12 2.5 12z"/>
                </svg>
                {{ $tool['views_count'] }}
            </span>
        </span>
        <button type="button" data-tool-preview class="btn btn-ghost btn-sm" aria-label="{{ __('Quick view') }} {{ $tool['name'] }}">
            {{ __('Quick view') }}
        </button>
    </div>
</article>

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

    $pricingStyles = [
        'free' => 'border-emerald-500/40 text-emerald-300 bg-emerald-500/10',
        'freemium' => 'border-sky-500/40 text-sky-300 bg-sky-500/10',
        'paid' => 'border-accent/40 text-accent bg-accent/10',
    ];

    $rating = number_format((float) $tool['rating_avg'], 1);
@endphp

<article
    role="button"
    tabindex="0"
    data-tool-card
    data-name="{{ Str::lower($tool['name']) }}"
    data-tagline="{{ Str::lower($tool['tagline']) }}"
    data-description="{{ Str::lower($tool['description']) }}"
    data-category="{{ $tool['category'] }}"
    data-pricing="{{ $tool['pricing_type'] }}"
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
    class="group relative flex flex-col text-start bg-card border-2 border-edge rounded-xl p-5
           cursor-pointer overflow-hidden animate-card-in
           transition-all duration-300 ease-out transform
           hover:-translate-y-1.5 hover:border-accent/70 hover:shadow-offset
           hover:backdrop-blur-sm
           focus:outline-none focus-visible:border-accent focus-visible:shadow-offset"
>
    {{-- gold wash on hover --}}
    <div class="pointer-events-none absolute inset-0 opacity-0 group-hover:opacity-100
                transition-opacity duration-300
                bg-gradient-to-br from-accent/[0.07] via-transparent to-transparent"></div>

    <div class="relative flex items-start gap-4">
        <div class="shrink-0 w-14 h-14 rounded-lg border-2 border-edge bg-surface
                    flex items-center justify-center overflow-hidden
                    transition-colors duration-300 group-hover:border-accent/50">
            @if ($tool['icon_url'])
                <img src="{{ $tool['icon_url'] }}" alt="" loading="lazy"
                     class="w-full h-full object-contain p-1.5">
            @else
                <span class="font-mega text-2xl text-accent">{{ Str::upper(Str::substr($tool['name'], 0, 1)) }}</span>
            @endif
        </div>

        <div class="min-w-0 flex-1">
            <h3 class="font-display text-lg font-semibold text-zinc-100 truncate
                       transition-colors duration-300 group-hover:text-accent">
                {{ $tool['name'] }}
            </h3>

            @if ($tool['tagline'])
                <p class="mt-0.5 text-sm text-zinc-400 line-clamp-2">{{ $tool['tagline'] }}</p>
            @endif
        </div>
    </div>

    @if ($tool['description'])
        <p class="relative mt-4 text-sm leading-relaxed text-zinc-500 line-clamp-3">
            {{ $tool['description'] }}
        </p>
    @endif

    <div class="relative mt-auto pt-5 flex flex-wrap items-center gap-2">
        <span class="px-2.5 py-1 rounded-md border border-edge bg-surface
                     font-mono text-[11px] uppercase tracking-wider text-zinc-400">
            {{ $categoryLabels[$tool['category']] ?? $tool['category'] }}
        </span>

        <span class="px-2.5 py-1 rounded-md border font-mono text-[11px] uppercase tracking-wider
                     {{ $pricingStyles[$tool['pricing_type']] ?? $pricingStyles['free'] }}">
            {{ $pricingLabels[$tool['pricing_type']] ?? $tool['pricing_type'] }}
        </span>

        <span class="ms-auto flex items-center gap-3 font-mono text-[11px] text-zinc-500">
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
    </div>
</article>

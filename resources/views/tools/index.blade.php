@extends('layouts.app')

@section('title', __('AI Tools Directory') . ' — ALPHA/AI')

@section('content')
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

    $pillBase = 'shrink-0 px-4 py-2 rounded-lg border-2 font-mono text-[11px] uppercase tracking-wider
                 transition-all duration-300 ease-out transform hover:-translate-y-0.5';
@endphp

<div class="min-h-screen bg-surface">

    {{-- ══════════════ top bar ══════════════ --}}
    <header class="sticky top-0 z-50 border-b-2 border-edge bg-surface/90 backdrop-blur-lg">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center gap-4">
            <a href="/" class="font-mega text-2xl tracking-wider text-zinc-100 hover:text-accent transition-colors">
                ALPHA<span class="text-accent">/</span>AI
            </a>

            <nav class="hidden md:flex items-center gap-1 ms-4">
                <a href="/" class="px-3 py-2 rounded-lg text-sm text-zinc-400 hover:text-accent transition-colors">{{ __('Home') }}</a>
                <a href="{{ route('tools.index') }}" class="px-3 py-2 rounded-lg text-sm text-accent border-2 border-accent/30 bg-accent/10">{{ __('AI Tools') }}</a>
                <a href="/news" class="px-3 py-2 rounded-lg text-sm text-zinc-400 hover:text-accent transition-colors">{{ __('News') }}</a>
            </nav>

            {{-- language switcher --}}
            <div class="ms-auto flex items-center gap-2">
                <div class="hidden sm:flex items-center gap-1 p-1 rounded-lg border-2 border-edge bg-card">
                    @foreach (config('alphaai.locales', []) as $code => $meta)
                        <a href="{{ route('lang.switch', $code) }}"
                           class="px-2.5 py-1 rounded-md font-mono text-[11px] uppercase tracking-wider transition-all duration-200
                                  {{ app()->getLocale() === $code
                                      ? 'bg-accent/20 text-accent border border-accent/40'
                                      : 'text-zinc-500 hover:text-zinc-200 border border-transparent' }}">
                            {{ $code === 'badini' ? 'BAD' : Str::upper($code) }}
                        </a>
                    @endforeach
                </div>

                <button type="button" data-submit-open
                        class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-lg
                               border-2 border-accent bg-accent/15 text-accent
                               font-display text-sm font-semibold tracking-wide
                               transition-all duration-300 transform
                               hover:bg-accent hover:text-surface hover:-translate-y-0.5 hover:shadow-offset">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('Submit Tool') }}
                </button>
            </div>
        </div>
    </header>

    {{-- ══════════════ hero ══════════════ --}}
    <section class="relative overflow-hidden border-b-2 border-edge">
        <div class="pointer-events-none absolute -top-24 start-1/4 w-96 h-96 rounded-full bg-accent/10 blur-3xl"></div>

        <div class="relative max-w-7xl mx-auto px-4 py-14 sm:py-20">
            <p class="font-mono text-[11px] uppercase tracking-[0.3em] text-accent mb-4">
                // {{ __('Artificial Intelligence') }}
            </p>

            <h1 class="font-mega text-5xl sm:text-7xl tracking-wide text-zinc-100 leading-[0.95]">
                {{ __('AI Tools Directory') }}
            </h1>

            <p class="mt-5 max-w-2xl text-base sm:text-lg text-zinc-400 leading-relaxed">
                {{ __('A curated directory of artificial intelligence tools, in your language.') }}
            </p>

            {{-- search --}}
            <div class="mt-9 max-w-xl relative">
                <span class="absolute inset-y-0 start-0 ps-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-zinc-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.2-5.2M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </span>

                <input id="tool-search" type="search" autocomplete="off"
                       placeholder="{{ __('Search AI tools...') }}"
                       aria-label="{{ __('Search') }}"
                       class="w-full ps-12 pe-4 py-4 rounded-xl bg-card border-2 border-edge
                              text-zinc-100 placeholder:text-zinc-600
                              transition-all duration-300
                              focus:border-accent focus:ring-0 focus:outline-none focus:shadow-offset">
            </div>
        </div>
    </section>

    {{-- ══════════════ filters ══════════════ --}}
    <section class="border-b-2 border-edge bg-card/40">
        <div class="max-w-7xl mx-auto px-4 py-5 space-y-3">
            <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
                <span class="shrink-0 font-mono text-[10px] uppercase tracking-widest text-zinc-600 me-1">
                    {{ __('Category') }}
                </span>

                <button type="button" data-filter-category="all"
                        class="{{ $pillBase }} border-accent bg-accent/15 text-accent" data-active="true">
                    {{ __('All') }}
                </button>

                @foreach ($categories as $cat)
                    <button type="button" data-filter-category="{{ $cat }}"
                            class="{{ $pillBase }} border-edge bg-surface text-zinc-400 hover:border-accent/50 hover:text-accent">
                        {{ $categoryLabels[$cat] ?? $cat }}
                    </button>
                @endforeach
            </div>

            <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
                <span class="shrink-0 font-mono text-[10px] uppercase tracking-widest text-zinc-600 me-1">
                    {{ __('Pricing') }}
                </span>

                <button type="button" data-filter-pricing="all"
                        class="{{ $pillBase }} border-accent bg-accent/15 text-accent" data-active="true">
                    {{ __('All') }}
                </button>

                @foreach ($pricingTypes as $type)
                    <button type="button" data-filter-pricing="{{ $type }}"
                            class="{{ $pillBase }} border-edge bg-surface text-zinc-400 hover:border-accent/50 hover:text-accent">
                        {{ $pricingLabels[$type] ?? $type }}
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════ grid ══════════════ --}}
    <main class="max-w-7xl mx-auto px-4 py-10">

        @if ($error)
            <div class="mb-8 border-2 border-red-500/40 bg-red-950/40 rounded-xl px-5 py-4">
                <p class="text-sm text-red-300">{{ $error }}</p>
            </div>
        @endif

        <p class="mb-6 font-mono text-[11px] uppercase tracking-widest text-zinc-600">
            <span id="tool-count">{{ count($tools) }}</span> / {{ count($tools) }}
        </p>

        <div id="tool-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($tools as $tool)
                <x-tool-card :tool="$tool" />
            @endforeach
        </div>

        {{-- empty state --}}
        <div id="tool-empty" class="{{ count($tools) ? 'hidden' : '' }} py-20 text-center">
            <p class="font-mega text-4xl tracking-widest text-zinc-700">// {{ __('No tools found') }}</p>
            <p class="mt-3 text-sm text-zinc-500">{{ __('Try a different search or category.') }}</p>
            <button type="button" id="tool-clear"
                    class="mt-6 px-5 py-2.5 rounded-lg border-2 border-edge bg-card text-zinc-300
                           font-mono text-[11px] uppercase tracking-wider
                           transition-all duration-300 hover:border-accent/60 hover:text-accent">
                {{ __('Clear filters') }}
            </button>
        </div>
    </main>

    {{-- floating action button (mobile) --}}
    <button type="button" data-submit-open aria-label="{{ __('Submit Tool') }}"
            class="sm:hidden fixed z-[60] bottom-6 end-6 w-14 h-14 rounded-full
                   border-2 border-accent bg-accent text-surface
                   flex items-center justify-center shadow-[0_8px_30px_rgba(245,158,11,.4)]
                   transition-transform duration-300 hover:scale-105 active:scale-95">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
    </button>

    <x-tool-modal />
    <x-submit-tool-modal :categories="$categories" :pricingTypes="$pricingTypes" />
</div>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    const i18n = {
        sending: @json(__('Sending...')),
        submit: @json(__('Submit')),
        error: @json(__('Something went wrong. Please try again.')),
        thanksRating: @json(__('Thanks for rating!')),
    };

    // ───────────────────────── filtering ─────────────────────────
    const grid    = document.getElementById('tool-grid');
    const cards   = Array.from(document.querySelectorAll('[data-tool-card]'));
    const search  = document.getElementById('tool-search');
    const empty   = document.getElementById('tool-empty');
    const counter = document.getElementById('tool-count');

    let activeCategory = 'all';
    let activePricing  = 'all';
    let query          = '';

    const ACTIVE   = ['border-accent', 'bg-accent/15', 'text-accent'];
    const INACTIVE = ['border-edge', 'bg-surface', 'text-zinc-400'];

    function setPillState(group, value) {
        document.querySelectorAll(`[data-filter-${group}]`).forEach((pill) => {
            const on = pill.dataset[`filter${group[0].toUpperCase()}${group.slice(1)}`] === value;
            pill.dataset.active = on ? 'true' : 'false';
            pill.classList.remove(...ACTIVE, ...INACTIVE);
            pill.classList.add(...(on ? ACTIVE : INACTIVE));
        });
    }

    function apply() {
        let shown = 0;

        cards.forEach((card) => {
            const matchCategory = activeCategory === 'all' || card.dataset.category === activeCategory;
            const matchPricing  = activePricing  === 'all' || card.dataset.pricing  === activePricing;
            const haystack = `${card.dataset.name} ${card.dataset.tagline} ${card.dataset.description}`;
            const matchQuery = query === '' || haystack.includes(query);

            const visible = matchCategory && matchPricing && matchQuery;

            card.classList.toggle('hidden', !visible);

            if (visible) {
                shown++;
                // re-trigger the morph-in animation
                card.classList.remove('animate-card-in');
                void card.offsetWidth;
                card.classList.add('animate-card-in');
            }
        });

        if (counter) counter.textContent = shown;
        if (empty)   empty.classList.toggle('hidden', shown > 0);
        if (grid)    grid.classList.toggle('hidden', shown === 0);
    }

    let debounce;
    search?.addEventListener('input', (e) => {
        clearTimeout(debounce);
        const value = e.target.value.trim().toLowerCase();
        debounce = setTimeout(() => { query = value; apply(); }, 140);
    });

    document.querySelectorAll('[data-filter-category]').forEach((pill) => {
        pill.addEventListener('click', () => {
            activeCategory = pill.dataset.filterCategory;
            setPillState('category', activeCategory);
            apply();
        });
    });

    document.querySelectorAll('[data-filter-pricing]').forEach((pill) => {
        pill.addEventListener('click', () => {
            activePricing = pill.dataset.filterPricing;
            setPillState('pricing', activePricing);
            apply();
        });
    });

    document.getElementById('tool-clear')?.addEventListener('click', () => {
        activeCategory = 'all';
        activePricing  = 'all';
        query = '';
        if (search) search.value = '';
        setPillState('category', 'all');
        setPillState('pricing', 'all');
        apply();
    });

    // ───────────────────────── detail modal ─────────────────────────
    const modal    = document.getElementById('tool-modal');
    const backdrop = document.getElementById('tool-modal-backdrop');
    let currentId  = null;
    let lastFocus  = null;

    const $ = (id) => document.getElementById(id);

    function fillStars(value) {
        document.querySelectorAll('#tool-modal-stars [data-star]').forEach((btn) => {
            const on = Number(btn.dataset.star) <= Math.round(value);
            btn.classList.toggle('text-accent', on);
            btn.classList.toggle('border-accent/60', on);
            btn.classList.toggle('text-zinc-600', !on);
            btn.setAttribute('aria-checked', on ? 'true' : 'false');
        });
    }

    function openModal(card) {
        let data;
        try { data = JSON.parse(card.dataset.tool); } catch { return; }

        currentId = data.id;
        lastFocus = document.activeElement;

        $('tool-modal-name').textContent    = data.name || '';
        $('tool-modal-tagline').textContent = data.tagline || '';
        $('tool-modal-category').textContent = data.category || '';
        $('tool-modal-pricing').textContent  = data.pricing || '';
        $('tool-modal-views').textContent    = data.views_count ?? 0;
        $('tool-modal-rating').textContent   = Number(data.rating_avg || 0).toFixed(1);
        $('tool-modal-rating-count').textContent = data.rating_count ? `(${data.rating_count})` : '';

        const link = $('tool-modal-link');
        link.href = data.website_url || '#';
        link.classList.toggle('pointer-events-none', !data.website_url);
        link.classList.toggle('opacity-40', !data.website_url);

        const icon = $('tool-modal-icon');
        const initial = $('tool-modal-initial');
        if (data.icon_url) {
            icon.src = data.icon_url;
            icon.classList.remove('hidden');
            initial.classList.add('hidden');
        } else {
            icon.classList.add('hidden');
            initial.classList.remove('hidden');
            initial.textContent = (data.name || '?').charAt(0).toUpperCase();
        }

        const descWrap = $('tool-modal-desc-wrap');
        if (data.description) {
            $('tool-modal-description').textContent = data.description;
            descWrap.classList.remove('hidden');
        } else {
            descWrap.classList.add('hidden');
        }

        const promptsWrap = $('tool-modal-prompts-wrap');
        const promptsList = $('tool-modal-prompts');
        promptsList.innerHTML = '';
        if (Array.isArray(data.prompts) && data.prompts.length) {
            data.prompts.forEach((p) => {
                const li = document.createElement('li');
                li.className = 'border-2 border-edge rounded-lg bg-surface/60 px-3 py-2 ' +
                               'font-mono text-xs text-zinc-400';
                li.textContent = p;
                promptsList.appendChild(li);
            });
            promptsWrap.classList.remove('hidden');
        } else {
            promptsWrap.classList.add('hidden');
        }

        fillStars(Number(data.rating_avg || 0));

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        requestAnimationFrame(() => backdrop.classList.replace('opacity-0', 'opacity-100'));

        modal.querySelector('[data-modal-close]')?.focus();

        // fire-and-forget view counter
        fetch(`/tools/${encodeURIComponent(currentId)}/view`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
        })
            .then((r) => r.json())
            .then((d) => { if (d?.views_count != null) $('tool-modal-views').textContent = d.views_count; })
            .catch(() => {});
    }

    function closeModal() {
        backdrop.classList.replace('opacity-100', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
            lastFocus?.focus();
        }, 200);
        currentId = null;
    }

    cards.forEach((card) => {
        card.addEventListener('click', () => openModal(card));
        card.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openModal(card); }
        });
    });

    modal?.querySelectorAll('[data-modal-close]').forEach((el) =>
        el.addEventListener('click', closeModal)
    );

    // ───────────────────────── rating ─────────────────────────
    document.querySelectorAll('#tool-modal-stars [data-star]').forEach((btn) => {
        btn.addEventListener('click', () => {
            if (!currentId) return;
            const rating = Number(btn.dataset.star);
            fillStars(rating);

            fetch(`/tools/${encodeURIComponent(currentId)}/rate`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ rating }),
            })
                .then((r) => r.json())
                .then((d) => {
                    if (!d?.ok) throw new Error();
                    $('tool-modal-rating').textContent = Number(d.rating_avg).toFixed(1);
                    $('tool-modal-rating-count').textContent = d.rating_count ? `(${d.rating_count})` : '';
                    fillStars(d.rating_avg);
                    toast(d.message || i18n.thanksRating);
                })
                .catch(() => toast(i18n.error, false));
        });
    });

    // ───────────────────────── toast ─────────────────────────
    const toastEl = document.getElementById('tool-toast');
    const toastMsg = document.getElementById('tool-toast-msg');
    let toastTimer;

    function toast(message, success = true) {
        if (!toastEl) return;
        toastMsg.textContent = message;

        toastEl.classList.toggle('border-emerald-500/50', success);
        toastEl.classList.toggle('bg-emerald-950/90', success);
        toastEl.classList.toggle('border-red-500/50', !success);
        toastEl.classList.toggle('bg-red-950/90', !success);

        toastEl.classList.remove('hidden');
        toastEl.classList.remove('animate-toast-in');
        void toastEl.offsetWidth;
        toastEl.classList.add('animate-toast-in');

        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => toastEl.classList.add('hidden'), 4200);
    }

    // ───────────────────────── submit modal ─────────────────────────
    const submitModal = document.getElementById('submit-modal');
    const submitBackdrop = document.getElementById('submit-modal-backdrop');
    const form = document.getElementById('submit-tool-form');
    const submitBtn = document.getElementById('submit-tool-btn');
    const formError = document.getElementById('submit-tool-error');

    function openSubmit() {
        submitModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        requestAnimationFrame(() => submitBackdrop.classList.replace('opacity-0', 'opacity-100'));
        document.getElementById('st-name')?.focus();
    }

    function closeSubmit() {
        submitBackdrop.classList.replace('opacity-100', 'opacity-0');
        setTimeout(() => {
            submitModal.classList.add('hidden');
            document.body.style.overflow = '';
        }, 200);
    }

    document.querySelectorAll('[data-submit-open]').forEach((b) => b.addEventListener('click', openSubmit));
    document.querySelectorAll('[data-submit-close]').forEach((b) => b.addEventListener('click', closeSubmit));

    form?.addEventListener('submit', (e) => {
        e.preventDefault();
        formError.classList.add('hidden');

        if (!form.reportValidity()) return;

        submitBtn.disabled = true;
        submitBtn.textContent = i18n.sending;

        const payload = Object.fromEntries(new FormData(form).entries());
        delete payload._token;

        fetch(@json(route('tools.submit')), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json',
            },
            body: JSON.stringify(payload),
        })
            .then(async (r) => {
                const data = await r.json().catch(() => ({}));
                if (!r.ok) throw data;
                return data;
            })
            .then((data) => {
                form.reset();
                closeSubmit();
                toast(data.message);
            })
            .catch((err) => {
                const first = err?.errors ? Object.values(err.errors)[0]?.[0] : null;
                formError.textContent = first || err?.message || i18n.error;
                formError.classList.remove('hidden');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = i18n.submit;
            });
    });

    // ───────────────────────── escape key ─────────────────────────
    document.addEventListener('keydown', (e) => {
        if (e.key !== 'Escape') return;
        if (!submitModal.classList.contains('hidden')) closeSubmit();
        else if (!modal.classList.contains('hidden')) closeModal();
    });
})();
</script>
@endpush

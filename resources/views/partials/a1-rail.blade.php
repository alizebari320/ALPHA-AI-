{{-- A1 · side rail (nav moved from top to a fixed right rail) --}}
@php
    $active = $active ?? '';
    $railLinks = [
        ['key' => 'home',     'href' => '/',            'so' => 'سەرەکی',    'ba' => 'سەرەکی',    'ico' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 10.5L12 3l9 7.5V21h-6v-6h-6v6H3z"/></svg>'],
        ['key' => 'ferga',    'href' => '/ferga',       'so' => 'فێرگە',     'ba' => 'فێرگە',     'ico' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M8 5l-6 7 6 7M16 5l6 7-6 7"/></svg>'],
        ['key' => 'courses',  'href' => '/courses',     'so' => 'کۆرس',      'ba' => 'کۆرس',      'ico' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5A2.5 2.5 0 016.5 17H20V3H6.5A2.5 2.5 0 004 5.5v14z"/><path d="M4 19.5A2.5 2.5 0 006.5 22H20v-5"/></svg>'],
        ['key' => 'ai-tools', 'href' => '/ai-tools',    'so' => 'ئامراز',    'ba' => 'ئامراز',    'ico' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M13 2L3 14h7l-1 8 10-12h-7l1-8z"/></svg>'],
        ['key' => 'news',     'href' => '/news',        'so' => 'هەواڵ',     'ba' => 'نووچە',     'ico' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 4h13v14H4zM17 8h3v8a2 2 0 01-2 2M7 8h7M7 12h7"/></svg>'],
        ['key' => 'universities', 'href' => '/universities', 'so' => 'زانکۆ', 'ba' => 'زانکۆ',    'ico' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3L1 9l11 6 9-4.9V17c0 1.7 2 2.6 4 1v-8"/><path d="M6 11v5c0 1.5 2.7 3 6 3s6-1.5 6-3v-5"/></svg>'],
        ['key' => 'academic-guide', 'href' => '/academic-guide', 'so' => 'ڕێبەر', 'ba' => 'ڕێبەر', 'ico' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 4l-5 2v14l5-2 6 2 5-2V4l-5 2-6-2z"/><path d="M9 4v14M15 6v14"/></svg>'],
    ];
@endphp
<aside class="a1-rail" id="a1-rail" data-a1-auth-required>
    <a href="/" class="a1-rail__mark" aria-label="ALPHA AI">
        <img src="{{ asset('mark-a1.svg') }}" width="40" height="40" alt="ALPHA AI">
    </a>
    <button type="button" class="a1-rail__menu" id="a1-rail-toggle" aria-label="menu" title="menu">☰</button>

    <nav class="a1-rail__list">
        @foreach ($railLinks as $link)
            <a href="{{ $link['href'] }}"
               class="a1-rail__link lang-str {{ $active === $link['key'] ? 'is-here' : '' }}"
               data-so="{{ $link['so'] }}" data-ba="{{ $link['ba'] }}"
               title="{{ $link['so'] }}">
               {!! $link['ico'] !!}<span class="a1-rail__label">{{ $link['so'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="a1-rail__bottom">
        <a href="/profile" class="a1-rail__user" title="profile">
            <span class="a1-rail__avatar" id="a1-avatar">؟</span>
            <span class="a1-rail__who">
                <span class="a1-rail__greet lang-str" data-so="بەخێربێیت" data-ba="بەخێربێیت">بەخێربێیت</span>
                <span class="a1-rail__name" id="a1-user-name">…</span>
            </span>
        </a>
        <button type="button" id="lang-toggle" class="a1-rail__mini" title="سۆرانی / بادینی">
            <span style="font-size:0.9rem">ع</span><span class="a1-rail__label" id="lang-text">بادینی</span>
        </button>
        <button type="button" id="theme-toggle" class="a1-rail__mini" title="ڕووناک / تاریک">
            <span id="a1-theme-ico">☀</span><span class="a1-rail__label lang-str" data-so="ڕووناکی" data-ba="ڕووناکی">ڕووناکی</span>
        </button>
        <a href="/profile" class="a1-rail__mini" title="profile">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-6 8-6s8 2 8 6"/></svg>
            <span class="a1-rail__label lang-str" data-so="هەژمار" data-ba="هەژمار">هەژمار</span>
        </a>
        <button type="button" id="logout-btn" class="a1-rail__mini" title="logout">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
            <span class="a1-rail__label lang-str" data-so="دەرچوون" data-ba="دەرکەفتن">دەرچوون</span>
        </button>
    </div>
</aside>

{{-- auth guard cover + scroll progress --}}
<div class="a1-progress" id="a1-progress" aria-hidden="true"><i></i></div>
<div class="a1-cover" id="a1-auth-cover" hidden>
    <img src="{{ asset('mark-a1.svg') }}" width="44" height="44" alt="">
    <div class="a1-cover__bar"><i></i></div>
    <p style="font-family:var(--a1-mono);font-size:0.72rem;color:var(--a1-dim);letter-spacing:0.2em">LOADING</p>
</div>

{{-- ALPHA AI v2 · top nav. Same links set, new look. Keeps ids: lang-toggle, lang-text, theme-toggle, logout-btn, and .lang-str sweep. --}}
@php
    $active = $active ?? '';
    $navLinks = [
        ['key' => 'home',     'href' => '/',           'so' => 'سەرەکی',   'ba' => 'سەرەکی'],
        ['key' => 'ferga',    'href' => '/ferga',      'so' => 'فێرگە',    'ba' => 'فێرگە'],
        ['key' => 'courses',  'href' => '/courses',    'so' => 'کۆرسەکان', 'ba' => 'کۆرس'],
        ['key' => 'ai-tools', 'href' => '/ai-tools',   'so' => 'ئامرازەکان','ba' => 'ئامراز'],
        ['key' => 'news',     'href' => '/news',       'so' => 'هەواڵ',    'ba' => 'نووچە'],
        ['key' => 'universities', 'href' => '/universities', 'so' => 'زانکۆ', 'ba' => 'زانکۆ'],
        ['key' => 'academic-guide', 'href' => '/academic-guide', 'so' => 'ڕێبەر', 'ba' => 'ڕێبەر'],
    ];
@endphp
<nav class="al-nav" data-al-auth-required>
    <div class="al-nav__inner">
        <a href="/" class="al-logo" aria-label="ALPHA AI">
            <img src="{{ asset('logo-alpha.svg') }}" width="34" height="34" alt="ALPHA AI" class="al-logo__mark">
            <span class="al-logo__name">ALPHA AI<small>LEARN · BUILD</small></span>
        </a>

        <div class="al-nav__links" id="al-navlinks">
            @foreach ($navLinks as $link)
                <a href="{{ $link['href'] }}"
                   class="al-nav__link lang-str {{ $active === $link['key'] ? 'is-here' : '' }}"
                   data-so="{{ $link['so'] }}" data-ba="{{ $link['ba'] }}">{{ $link['so'] }}</a>
            @endforeach
        </div>

        <div class="al-nav__spacer"></div>

        <div class="al-nav__tools">
            <button type="button" id="lang-toggle" class="al-iconbtn" title="سۆرانی / بادینی">
                <span id="lang-text">بادینی</span>
            </button>
            <button type="button" id="theme-toggle" class="al-iconbtn" title="ڕووناک / تاریک">
                <span id="al-theme-ico">☾</span>
            </button>
            <a href="/profile" class="al-btn al-btn--ghost al-btn--sm lang-str" data-so="هەژمار" data-ba="هەژمار">هەژمار</a>
            <button type="button" id="logout-btn" class="al-btn al-btn--danger al-btn--sm lang-str" data-so="دەرچوون" data-ba="دەرکەفتن">دەرچوون</button>
            <button type="button" id="al-burger" class="al-iconbtn" style="display:none" aria-label="menu">☰</button>
        </div>
    </div>
</nav>

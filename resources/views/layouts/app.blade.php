@php
    $locale = app()->getLocale();
    $locales = config('alphaai.locales', []);
    $isRtl = in_array($locale, ['ar', 'ckb', 'badini'], true);
    $dir = $isRtl ? 'rtl' : 'ltr';
    $path = trim(request()->path(), '/');
    $isActive = fn (string $p) => $path === $p || ($p !== '' && str_starts_with($path, $p . '/'));
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}" class="{{ request()->has('dark') ? 'dark' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'AlphaAi'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
    @stack('styles')
    <meta name="description" content="@yield('meta_description', 'AlphaAi helps Kurdish learners discover AI tools, prompts, courses, news, and practical resources.')">
    <link rel="canonical" href="{{ url()->current() }}">
    <style>
        html { scroll-behavior: smooth; scroll-padding-top: 72px; }
    </style>
</head>
<body dir="{{ $dir }}" class="bg-bg text-fg font-sans antialiased overflow-x-hidden {{ $isRtl ? 'text-right' : 'text-left' }}">

    <header id="main-header" class="nav-shell" role="banner">
        <div class="container flex h-[72px] items-center gap-4">
            <a href="/" class="brand-mark" aria-label="AlphaAi home">
                <span class="brand-orbit" aria-hidden="true"></span><span>Alpha<span class="text-accent">Ai</span></span>
            </a>

            <nav class="hidden md:flex items-center gap-1 ms-4" aria-label="Primary navigation">
                <a href="/" class="nav-link {{ $path === '' ? 'active' : '' }}">{{ __('Home') }}</a>
                    <a href="{{ route('tools.index') }}" class="nav-link {{ $isActive('tools') ? 'active' : '' }}">{{ __('AI Tools') }}</a>
                <a href="/courses" class="nav-link {{ $isActive('courses') ? 'active' : '' }}">{{ __('Courses') }}</a>
                <a href="/news" class="nav-link {{ $isActive('news') ? 'active' : '' }}">{{ __('News') }}</a>
                <a href="/about" class="nav-link {{ $isActive('about') ? 'active' : '' }}">{{ __('About') }}</a>
                <a href="{{ route('prompts.index') }}" class="nav-link {{ $isActive('prompts') ? 'active' : '' }}">{{ __('Prompts') }}</a>
                <a href="{{ route('kurdish-ai') }}" class="nav-link {{ $isActive('kurdish-ai') ? 'active' : '' }}">{{ __('Kurdish AI') }}</a>
            </nav>

            <div class="ms-auto flex items-center gap-2">
                <div class="language-segment hidden sm:flex items-center gap-1" role="group" aria-label="Language selection">
                    @foreach ($locales as $code => $meta)
                        <a href="{{ route('lang.switch', $code) }}"
                           class="lang-btn {{ $locale === $code ? 'active' : '' }}"
                           aria-label="Switch to {{ $code }}"
                           aria-current="{{ $locale === $code ? 'true' : 'false' }}">
                            {{ $code === 'badini' ? 'BAD' : Str::upper($code) }}
                        </a>
                    @endforeach
                </div>

                <a href="{{ route('tools.index') }}#submit-tool" class="hidden sm:inline-flex btn btn-accent btn-sm" aria-label="{{ __('Submit a tool') }}">
                    {{ __('Submit a tool') }}
                </a>

                <button id="theme-toggle" type="button" class="icon-btn" aria-label="Toggle theme" aria-pressed="false">
                    <svg class="w-5 h-5 sun-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                    <svg class="w-5 h-5 moon-icon hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                </button>

                <button id="mobile-menu-btn" type="button" class="md:hidden icon-btn" aria-label="Toggle menu" aria-expanded="false" aria-controls="mobile-menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden border-t border-border bg-bg-elevated/98 backdrop-blur supports-[backdrop-filter]:bg-bg-elevated/80 transition-all duration-300 overflow-hidden" aria-label="Mobile navigation">
            <div class="container py-4 flex flex-col gap-1">
                <a href="/" class="nav-link block py-2 {{ $path === '' ? 'active' : '' }}">{{ __('Home') }}</a>
                <a href="{{ route('tools.index') }}" class="nav-link block py-2 {{ $isActive('tools') ? 'active' : '' }}">{{ __('AI Tools') }}</a>
                <a href="/courses" class="nav-link block py-2 {{ $isActive('courses') ? 'active' : '' }}">{{ __('Courses') }}</a>
                <a href="/news" class="nav-link block py-2 {{ $isActive('news') ? 'active' : '' }}">{{ __('News') }}</a>
                <a href="/about" class="nav-link block py-2 {{ $isActive('about') ? 'active' : '' }}">{{ __('About') }}</a>
                <a href="{{ route('prompts.index') }}" class="nav-link block py-2 {{ $isActive('prompts') ? 'active' : '' }}">{{ __('Prompts') }}</a>
                <a href="{{ route('kurdish-ai') }}" class="nav-link block py-2 {{ $isActive('kurdish-ai') ? 'active' : '' }}">{{ __('Kurdish AI') }}</a>
                <a href="{{ route('assistant.index') }}" class="nav-link block py-2 {{ $isActive('assistant') ? 'active' : '' }}">{{ __('Assistant') }}</a>
                <a href="{{ route('tools.index') }}#submit-tool" class="nav-link block py-2 mt-2">{{ __('Submit a tool') }}</a>
            </div>
        </div>
    </header>

    <main id="content" class="layer relative" role="main">
        @yield('content')
    </main>

    <footer class="layer relative border-t border-border bg-bg-muted/50 mt-auto" role="contentinfo">
        <div class="container py-12 lg:py-16 grid gap-8 md:grid-cols-3">
            <div class="md:col-span-2">
                <a href="/" class="font-display text-lg font-semibold text-fg hover:text-accent transition-colors block mb-4 flex items-center gap-1.5">
                    <span>Alpha<span class="text-accent">Ai</span></span>
                </a>
                <nav class="flex flex-wrap gap-x-6 gap-y-2 text-sm text-fg-muted" aria-label="Footer navigation">
                    <a href="/" class="hover:text-fg transition-colors">{{ __('Home') }}</a>
                    <a href="{{ route('tools.index') }}" class="hover:text-fg transition-colors">{{ __('AI Tools') }}</a>
                    <a href="/courses" class="hover:text-fg transition-colors">{{ __('Courses') }}</a>
                    <a href="/news" class="hover:text-fg transition-colors">{{ __('News') }}</a>
                    <a href="/universities" class="hover:text-fg transition-colors">{{ __('Universities') }}</a>
                    <a href="/about" class="hover:text-fg transition-colors">{{ __('About') }}</a>
                </nav>
            </div>
            <div class="text-center md:text-end">
                <h4 class="font-display text-base font-medium text-fg mb-2">{{ __('Contact') }}</h4>
                <a href="mailto:alphaaiteam@gmail.com" class="font-mono text-xs text-fg-muted hover:text-accent transition-colors" dir="ltr">alphaaiteam@gmail.com</a>
            </div>
        </div>
        <div class="border-t border-border">
            <div class="container py-4 text-center">
                <p class="font-mono text-[10px] tracking-[0.2em] uppercase text-fg-faint">&copy; {{ date('Y' )}} AlphaAi</p>
            </div>
        </div>
    </footer>

    <script>
        (function() {
            const html = document.documentElement;
            const themeToggle = document.getElementById('theme-toggle');
            const sunIcon = themeToggle?.querySelector('.sun-icon');
            const moonIcon = themeToggle?.querySelector('.moon-icon');
            const header = document.getElementById('main-header');

            function updateThemeIcons(isDark) {
                if (sunIcon && moonIcon) {
                    sunIcon.classList.toggle('hidden', isDark);
                    moonIcon.classList.toggle('hidden', !isDark);
                }
                themeToggle?.setAttribute('aria-pressed', String(isDark));
            }

            function initTheme() {
                const saved = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const isDark = saved ? saved === 'dark' : prefersDark;
                html.classList.toggle('dark', isDark);
                updateThemeIcons(isDark);
            }

            themeToggle?.addEventListener('click', () => {
                const isDark = html.classList.toggle('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                updateThemeIcons(isDark);
            });

            const mobileBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            if (mobileBtn && mobileMenu) {
                mobileBtn.addEventListener('click', () => {
                    const open = mobileMenu.classList.toggle('hidden');
                    mobileBtn.setAttribute('aria-expanded', String(!open));
                });
            }

            if (header) {
                const observer = new IntersectionObserver(
                    ([e]) => {
                        if (e.intersectionRatio < 1) header.classList.add('scrolled');
                        else header.classList.remove('scrolled');
                    },
                    { threshold: [1], rootMargin: '-1px 0px 0px 0px' }
                );
                observer.observe(header);
            }

            initTheme();
        })();
    </script>

    <script>
        window.alphaTrack = function(event, detail = {}) {
            const token = document.querySelector('meta[name="csrf-token"]')?.content;
            if (!token) return;
            fetch("{{ route('analytics.track') }}", {method:'POST', keepalive:true, headers:{'Content-Type':'application/json','X-CSRF-TOKEN':token,'Accept':'application/json'}, body:JSON.stringify({event,path:window.location.pathname,...detail})}).catch(()=>{});
        };
        window.addEventListener('load', () => window.alphaTrack('page_view'));
    </script>
    @stack('scripts')
</body>
</html>

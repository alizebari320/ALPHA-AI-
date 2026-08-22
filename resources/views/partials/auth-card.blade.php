{{--
  Auth Card - Glassmorphism panel with neon accent
  Usage:
    @component('partials.auth-card')
        @slot('header')
            <h1 class="font-mega text-3xl tracking-wide text-zinc-100 mb-1">Title</h1>
            <p class="text-zinc-500 font-mono text-xs tracking-widest mt-2">Subtitle</p>
        @endslot

        @slot('body')
            Form content here
        @endslot

        @slot('footer')
            Footer links/actions
        @endslot
    @endcomponent
--}}
@props([
    'header' => '',
    'body' => '',
    'footer' => '',
    'class' => 'panel bracket panel-hover panel-sweep w-full max-w-md transition-all duration-500 ease-out hover:shadow-[0_0_40px_rgba(34,229,255,0.15)]',
    'centered' => true,
])

<div class="relative z-10 flex items-center justify-center min-h-[calc(100vh-8rem)] px-4 pb-16">
    <div class="{{ $class }}">
        {{-- Corner brackets (from .bracket class) --}}
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <div class="absolute top-7 left-7 w-14 h-14 border-t-2 border-l-2 border-cyan-400 opacity-0 transition-opacity duration-300 group-hover:opacity-100 rtl:right-7 rtl:left-auto rtl:border-r-2 rtl:border-l-0"></div>
            <div class="absolute bottom-7 right-7 w-14 h-14 border-b-2 border-r-2 border-cyan-400 opacity-0 transition-opacity duration-300 group-hover:opacity-100 rtl:left-7 rtl:right-auto rtl:border-l-2 rtl:border-r-0"></div>
        </div>

        {{-- Top highlight line --}}
        <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-cyan-400/50 to-transparent opacity-60 transition-opacity duration-350 group-hover:opacity-100" aria-hidden="true"></div>

        {{-- Diagonal sweep on hover --}}
        <div class="absolute inset-0 -skew-x-6 bg-gradient-to-r from-transparent via-white/5 to-transparent origin-left transform -translate-x-full transition-transform duration-700 group-hover:translate-x-[320%] pointer-events-none" aria-hidden="true"></div>

        <div class="relative z-10 p-8">
            @if ($header)
                <div class="text-center mb-8">
                    {{ $header }}
                </div>
            @endif

            {{ $body }}

            @if ($footer)
                <div class="mt-8 pt-6 border-t border-zinc-800">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>

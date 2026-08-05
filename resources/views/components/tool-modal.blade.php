{{--
    Glassmorphic tool detail modal.
    Populated client-side from the focused card's data-tool payload.
--}}
<div id="tool-modal" class="fixed inset-0 z-[70] hidden" role="dialog" aria-modal="true"
     aria-labelledby="tool-modal-name">

    {{-- backdrop --}}
    <div data-modal-close
         class="absolute inset-0 bg-black/70 backdrop-blur-md opacity-0 transition-opacity duration-300"
         id="tool-modal-backdrop"></div>

    <div class="relative h-full w-full flex items-end sm:items-center justify-center p-0 sm:p-6 overflow-y-auto">
        <div id="tool-modal-panel"
             class="relative w-full sm:max-w-2xl bg-card/90 backdrop-blur-xl
                    border-2 border-edge sm:rounded-2xl rounded-t-2xl
                    shadow-[0_-8px_40px_rgba(0,0,0,.6)] sm:shadow-offset-lg
                    animate-modal-in">

            {{-- gold top rule --}}
            <div class="absolute inset-x-0 top-0 h-0.5 bg-gradient-to-e from-accent/80 via-accent/20 to-transparent"></div>

            <button type="button" data-modal-close aria-label="{{ __('Close') }}"
                    class="absolute top-4 end-4 z-10 w-9 h-9 rounded-lg border-2 border-edge bg-surface/80
                           text-zinc-400 flex items-center justify-center
                           transition-all duration-200 hover:border-accent/60 hover:text-accent">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="p-6 sm:p-8">
                {{-- header --}}
                <div class="flex items-start gap-4 pe-12">
                    <div id="tool-modal-icon-wrap"
                         class="shrink-0 w-16 h-16 rounded-xl border-2 border-edge bg-surface
                                flex items-center justify-center overflow-hidden">
                        <img id="tool-modal-icon" src="" alt="" class="w-full h-full object-contain p-2 hidden">
                        <span id="tool-modal-initial" class="font-mega text-3xl text-accent"></span>
                    </div>

                    <div class="min-w-0">
                        <h2 id="tool-modal-name"
                            class="font-mega text-3xl sm:text-4xl tracking-wide text-zinc-100 leading-none"></h2>
                        <p id="tool-modal-tagline" class="mt-2 text-sm text-zinc-400"></p>
                    </div>
                </div>

                {{-- meta chips --}}
                <div class="mt-6 flex flex-wrap items-center gap-2">
                    <span id="tool-modal-category"
                          class="px-2.5 py-1 rounded-md border border-edge bg-surface
                                 font-mono text-[11px] uppercase tracking-wider text-zinc-400"></span>
                    <span id="tool-modal-pricing"
                          class="px-2.5 py-1 rounded-md border border-accent/40 bg-accent/10
                                 font-mono text-[11px] uppercase tracking-wider text-accent"></span>
                </div>

                {{-- stats --}}
                <div class="mt-6 grid grid-cols-2 gap-3">
                    <div class="border-2 border-edge rounded-lg bg-surface/60 p-4">
                        <p class="font-mono text-[10px] uppercase tracking-widest text-zinc-500">{{ __('Views') }}</p>
                        <p id="tool-modal-views" class="mt-1 font-mega text-2xl text-zinc-100">0</p>
                    </div>
                    <div class="border-2 border-edge rounded-lg bg-surface/60 p-4">
                        <p class="font-mono text-[10px] uppercase tracking-widest text-zinc-500">{{ __('Rating') }}</p>
                        <p class="mt-1 font-mega text-2xl text-zinc-100">
                            <span id="tool-modal-rating">0.0</span>
                            <span id="tool-modal-rating-count" class="font-mono text-xs text-zinc-500 ms-1"></span>
                        </p>
                    </div>
                </div>

                {{-- description --}}
                <div id="tool-modal-desc-wrap" class="mt-6 hidden">
                    <h3 class="font-mono text-[10px] uppercase tracking-widest text-zinc-500 mb-2">
                        {{ __('About this tool') }}
                    </h3>
                    <p id="tool-modal-description" class="text-sm leading-relaxed text-zinc-300"></p>
                </div>

                {{-- example prompts --}}
                <div id="tool-modal-prompts-wrap" class="mt-6 hidden">
                    <h3 class="font-mono text-[10px] uppercase tracking-widest text-zinc-500 mb-2">
                        {{ __('Example prompts') }}
                    </h3>
                    <ul id="tool-modal-prompts" class="space-y-2"></ul>
                </div>

                {{-- interactive rating --}}
                <div class="mt-7 border-t-2 border-edge pt-6">
                    <h3 class="font-mono text-[10px] uppercase tracking-widest text-zinc-500 mb-3">
                        {{ __('Rate this tool') }}
                    </h3>
                    <div id="tool-modal-stars" class="flex items-center gap-1.5" role="radiogroup">
                        @for ($i = 1; $i <= 5; $i++)
                            <button type="button" data-star="{{ $i }}" role="radio" aria-checked="false"
                                    aria-label="{{ $i }}"
                                    class="w-9 h-9 rounded-md border-2 border-edge bg-surface
                                           flex items-center justify-center text-zinc-600
                                           transition-all duration-200
                                           hover:border-accent/60 hover:text-accent hover:-translate-y-0.5">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.05 2.93c.3-.92 1.6-.92 1.9 0l1.3 4.01a1 1 0 00.95.69h4.22c.97 0 1.37 1.24.59 1.81l-3.42 2.48a1 1 0 00-.36 1.12l1.3 4.01c.3.92-.75 1.69-1.54 1.12l-3.41-2.48a1 1 0 00-1.18 0l-3.41 2.48c-.79.57-1.84-.2-1.54-1.12l1.3-4.01a1 1 0 00-.36-1.12L2.0 9.44c-.79-.57-.38-1.81.59-1.81h4.22a1 1 0 00.95-.69l1.29-4.01z"/>
                                </svg>
                            </button>
                        @endfor
                    </div>
                </div>

                {{-- primary action --}}
                <a id="tool-modal-link" href="#" target="_blank" rel="noopener noreferrer"
                   class="mt-7 w-full inline-flex items-center justify-center gap-2
                          px-5 py-3.5 rounded-lg border-2 border-accent
                          bg-accent/15 text-accent font-display font-semibold tracking-wide
                          transition-all duration-300 transform
                          hover:bg-accent hover:text-surface hover:-translate-y-0.5 hover:shadow-offset">
                    {{ __('Visit website') }}
                    <svg class="w-4 h-4 rtl:-scale-x-100" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

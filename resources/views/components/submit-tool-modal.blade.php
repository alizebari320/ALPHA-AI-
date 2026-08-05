@props(['categories' => [], 'pricingTypes' => []])

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

    $inputClass = 'w-full px-4 py-2.5 rounded-lg bg-surface border-2 border-edge text-sm text-zinc-100
                   placeholder:text-zinc-600 transition-colors duration-200
                   focus:border-accent focus:ring-0 focus:outline-none';

    $labelClass = 'block font-mono text-[10px] uppercase tracking-widest text-zinc-500 mb-1.5';
@endphp

<div id="submit-modal" class="fixed inset-0 z-[80] hidden" role="dialog" aria-modal="true"
     aria-labelledby="submit-modal-title">

    <div data-submit-close id="submit-modal-backdrop"
         class="absolute inset-0 bg-black/70 backdrop-blur-md opacity-0 transition-opacity duration-300"></div>

    <div class="relative h-full w-full flex items-end sm:items-center justify-center p-0 sm:p-6 overflow-y-auto">
        <div class="relative w-full sm:max-w-lg bg-card/90 backdrop-blur-xl
                    border-2 border-edge sm:rounded-2xl rounded-t-2xl
                    sm:shadow-offset-lg animate-modal-in">

            <div class="absolute inset-x-0 top-0 h-0.5 bg-gradient-to-e from-accent/80 via-accent/20 to-transparent"></div>

            <button type="button" data-submit-close aria-label="{{ __('Close') }}"
                    class="absolute top-4 end-4 w-9 h-9 rounded-lg border-2 border-edge bg-surface/80
                           text-zinc-400 flex items-center justify-center
                           transition-all duration-200 hover:border-accent/60 hover:text-accent">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <form id="submit-tool-form" class="p-6 sm:p-8" novalidate>
                @csrf

                <h2 id="submit-modal-title" class="font-mega text-3xl tracking-wide text-zinc-100 pe-12">
                    {{ __('Submit a New Tool') }}
                </h2>
                <p class="mt-2 text-sm text-zinc-400">
                    {{ __('Help grow the directory. Submissions are reviewed before publishing.') }}
                </p>

                <div class="mt-6 space-y-4">
                    <div>
                        <label for="st-name" class="{{ $labelClass }}">{{ __('Tool name') }} *</label>
                        <input id="st-name" name="name" type="text" required maxlength="120" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label for="st-url" class="{{ $labelClass }}">{{ __('Website URL') }} *</label>
                        <input id="st-url" name="website_url" type="url" required placeholder="https://"
                               dir="ltr" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label for="st-tagline" class="{{ $labelClass }}">{{ __('Tagline') }}</label>
                        <input id="st-tagline" name="tagline" type="text" maxlength="200" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label for="st-desc" class="{{ $labelClass }}">{{ __('Description') }}</label>
                        <textarea id="st-desc" name="description" rows="3" maxlength="2000"
                                  class="{{ $inputClass }} resize-none"></textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="st-category" class="{{ $labelClass }}">{{ __('Category') }} *</label>
                            <select id="st-category" name="category" required class="{{ $inputClass }}">
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat }}">{{ $categoryLabels[$cat] ?? $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="st-pricing" class="{{ $labelClass }}">{{ __('Pricing') }} *</label>
                            <select id="st-pricing" name="pricing_type" required class="{{ $inputClass }}">
                                @foreach ($pricingTypes as $type)
                                    <option value="{{ $type }}">{{ $pricingLabels[$type] ?? $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="st-icon" class="{{ $labelClass }}">{{ __('Icon URL') }}</label>
                            <input id="st-icon" name="icon_url" type="url" placeholder="https://"
                                   dir="ltr" class="{{ $inputClass }}">
                        </div>

                        <div>
                            <label for="st-lang" class="{{ $labelClass }}">{{ __('Language of your submission') }}</label>
                            <select id="st-lang" name="lang" class="{{ $inputClass }}">
                                @foreach (config('alphaai.locales', []) as $code => $meta)
                                    <option value="{{ $code }}" @selected($code === app()->getLocale())>
                                        {{ $meta['native'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <p id="submit-tool-error" class="mt-4 hidden text-sm text-red-400"></p>

                <div class="mt-7 flex flex-col-reverse sm:flex-row items-stretch sm:items-center gap-3">
                    <button type="button" data-submit-close
                            class="flex-1 px-5 py-3 rounded-lg border-2 border-edge bg-surface
                                   text-zinc-300 font-display tracking-wide
                                   transition-all duration-200 hover:border-zinc-600 hover:text-zinc-100">
                        {{ __('Cancel') }}
                    </button>

                    <button type="submit" id="submit-tool-btn"
                            class="flex-1 px-5 py-3 rounded-lg border-2 border-accent bg-accent/15
                                   text-accent font-display font-semibold tracking-wide
                                   transition-all duration-300 transform
                                   hover:bg-accent hover:text-surface hover:-translate-y-0.5 hover:shadow-offset
                                   disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                        {{ __('Submit') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- success toast --}}
<div id="tool-toast"
     class="fixed z-[90] bottom-6 end-6 hidden max-w-sm
            border-2 border-emerald-500/50 bg-emerald-950/90 backdrop-blur-xl
            rounded-xl px-5 py-4 shadow-[0_8px_30px_rgba(0,0,0,.5)] animate-toast-in">
    <div class="flex items-start gap-3">
        <svg class="w-5 h-5 shrink-0 text-emerald-400 mt-0.5" fill="none" stroke="currentColor"
             stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
        <p id="tool-toast-msg" class="text-sm text-emerald-100"></p>
    </div>
</div>

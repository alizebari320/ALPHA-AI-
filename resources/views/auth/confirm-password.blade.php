@extends('layouts.app')

@section('title', 'Confirm Password — ALPHA/AI')

@section('content')
<div class="tech-glow w-72 h-72 top-0 right-1/4"></div>

<div class="relative z-10 flex items-center justify-center min-h-screen p-4">
    <div class="card p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-amber-600 border-2 border-amber-700 flex items-center justify-center shadow-[3px_3px_0_rgba(0,0,0,.35)] text-neutral-950 font-black text-2xl mx-auto mb-4 font-mega">A</div>
            <h2 class="font-mega text-4xl tracking-wide text-stone-900 dark:text-cream mb-1">پشتڕاستکردنەوە</h2>
        </div>

        <div class="mb-4 text-sm text-slate-600 dark:text-slate-300">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end mt-6">
                <x-primary-button>
                    {{ __('Confirm') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection

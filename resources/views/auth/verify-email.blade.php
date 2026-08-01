@extends('layouts.app')

@section('title', 'Verify Email — ALPHA/AI')

@section('content')
<div class="tech-glow w-72 h-72 top-0 right-1/4"></div>

<div class="relative z-10 flex items-center justify-center min-h-screen p-4">
    <div class="card p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-amber-600 border-2 border-amber-700 flex items-center justify-center shadow-[3px_3px_0_rgba(0,0,0,.35)] text-neutral-950 font-black text-2xl mx-auto mb-4 font-mega">A</div>
            <h2 class="font-mega text-4xl tracking-wide text-stone-900 dark:text-cream mb-1">پشتڕاستکردنەوەی ئیمێڵ</h2>
        </div>

        <div class="mb-4 text-sm text-slate-600 dark:text-slate-300">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-amber-800 dark:text-gold">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-primary-button>
                        {{ __('Resend Verification Email') }}
                    </x-primary-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-slate-500 dark:text-slate-400 hover:text-amber-700 dark:hover:text-gold rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Server-side admin gate. The client-side check in the Blade views only
     * hides UI — it is trivially bypassed with DevTools, so every admin route
     * must pass through here as well.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user) {
            return $request->expectsJson()
                ? response()->json(['error' => 'unauthenticated'], 401)
                : redirect()->guest(route('login'));
        }

        $admins = array_map(
            static fn (string $email): string => mb_strtolower(trim($email)),
            config('alphaai.admin_emails', [])
        );

        if (! in_array(mb_strtolower(trim($user->email)), $admins, true)) {
            abort(403, 'This area is restricted to administrators.');
        }

        return $next($request);
    }
}

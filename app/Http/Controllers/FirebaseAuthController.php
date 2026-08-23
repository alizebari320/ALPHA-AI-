<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FirebaseAuthController extends Controller
{
    public function sync(Request $request)
    {
        $request->validate(['id_token' => 'required|string']);

        try {
            $verifiedToken = app('firebase.auth')->verifyIdToken($request->input('id_token'));
        } catch (\Throwable $e) {
            return response()->json(['error' => 'invalid_token'], 401);
        }

        $claims = $verifiedToken->claims()->all();

        $uid = (string) ($claims['sub'] ?? '');
        $email = strtolower(trim((string) ($claims['email'] ?? '')));
        $emailVerified = filter_var($claims['email_verified'] ?? false, FILTER_VALIDATE_BOOLEAN);

        if ($uid === '' || $email === '') {
            return response()->json(['error' => 'no_email'], 422);
        }

        if (! $emailVerified) {
            return response()->json(['error' => 'email_not_verified'], 403);
        }

        $user = User::where('firebase_uid', $uid)->first();

        if (! $user) {
            $existing = User::whereRaw('LOWER(email) = ?', [$email])->first();

            if ($existing) {
                return response()->json(['error' => 'account_link_required'], 409);
            }

            $user = User::create([
                'name' => $claims['name'] ?? explode('@', $email)[0],
                'email' => $email,
                'firebase_uid' => $uid,
                'auth_provider' => $claims['firebase']['sign_in_provider'] ?? 'firebase',
                'password' => Hash::make(Str::random(64)),
                'email_verified_at' => now(),
            ]);
        } else {
            $user->forceFill([
                'email' => $email,
                'name' => $claims['name'] ?? $user->name,
                'auth_provider' => $claims['firebase']['sign_in_provider'] ?? $user->auth_provider,
                'email_verified_at' => $user->email_verified_at ?? now(),
            ])->save();
        }

        $request->session()->regenerate();
        Auth::login($user);

        return response()->json(['ok' => true, 'name' => $user->name]);
    }
}

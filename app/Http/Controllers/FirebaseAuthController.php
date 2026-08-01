<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $email = $claims['email'] ?? null;
        if (! $email) {
            return response()->json(['error' => 'no_email'], 422);
        }

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $claims['name'] ?? explode('@', $email)[0],
                'password' => bcrypt(Str::random(32)),
                'email_verified_at' => now(),
            ]
        );

        Auth::login($user);

        return response()->json(['ok' => true, 'name' => $user->name]);
    }
}

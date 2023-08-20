<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;

class TokenAuthenticationMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json(['Token missing' => $token], 401);
        }

        $user = User::where('api_token', $token)->first();

        if (!$user) {
            return response()->json(['Invalid token' => $token], 401);
        }

        auth()->login($user);

        return $next($request);
    }
}
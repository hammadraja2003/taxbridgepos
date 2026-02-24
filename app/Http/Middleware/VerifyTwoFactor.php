<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;

class VerifyTwoFactor
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // If user has 2FA enabled and not verified in this session
        if ($user && $user->hasTwoFactorEnabled() && !session('2fa_verified')) {
            return redirect()->route('mfa.verify');
        }

        return $next($request);
    }
}

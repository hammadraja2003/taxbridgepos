<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Roles as Role;

class HasPermanentDeletePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->role_type == 1 || $role->role_type == 2) {
            return $next($request);
        }

        return back()->with('not_permitted', 'Unauthorized action!');
    }
}

<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\TenantManager;

class SetTenantConnection
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('login') || $request->is('password/*') || $request->is('install/*')) {
            return $next($request);
        }
        if (auth()->check() && session()->has('bus_config_id')) {
            $tenantId = session()->get('bus_config_id');
            try {
                app(TenantManager::class)->setTenant($tenantId);
            } catch (\Exception $e) {
                auth()->logout();
                session()->invalidate();
                return redirect()->route('login')
                    ->with('delete_message', 'Unable to connect to tenant database. Contact admin.');
            }
        }
        
        return $next($request);
    }
}
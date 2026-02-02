<?php
namespace App\Http\Middleware;

use App\Services\TenantManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Closure;

class SetTenantConnection
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('login') || $request->is('password/*') || $request->is('install/*')) {
            return $next($request);
        }
        if (auth()->check() && session()->has('bus_config_id')) {
            $bus_config_id = session()->get('bus_config_id');
            try {
                $business = DB::connection('master')
                    ->table('business_configurations')
                    ->where('bus_config_id', $bus_config_id)
                    ->first();
                // Verify tenant database exists
                $dbName = $business->db_name;
                $dbExists = DB::select("SHOW DATABASES LIKE '{$dbName}'");
                if (empty($dbExists)) {
                    auth()->logout();
                    session()->invalidate();
                    return redirect()
                        ->route('login')
                        ->with('delete_message', 'Your tenant database has not been created yet. Please contact admin.');
                }

                // Check for active package
                $today = \Carbon\Carbon::now();
                $activePackage = DB::connection('master')
                    ->table('business_packages')
                    ->where('business_id', $business->bus_config_id)
                    ->where('is_active', true)
                    ->where(function ($query) use ($today) {
                        $query
                            ->where(function ($q) use ($today) {
                                $q
                                    ->where('is_trial', false)
                                    ->where('end_date', '>=', $today);
                            })
                            ->orWhere(function ($q) use ($today) {
                                $q
                                    ->where('is_trial', true)
                                    ->where('trial_end_date', '>=', $today);
                            });
                    })
                    ->first();

                if (!$activePackage) {
                    auth()->logout();
                    session()->invalidate();
                    return redirect()->route('login')->withErrors([
                        'delete_message' => 'Your business does not have an active package. Please contact admin.'
                    ]);
                }

                app(TenantManager::class)->setTenant($bus_config_id);
            } catch (\Exception $e) {
                auth()->logout();
                session()->invalidate();
                return redirect()
                    ->route('login')
                    ->with('delete_message', 'Unable to connect to tenant database. Contact admin.');
            }
        }

        return $next($request);
    }
}

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
                // $dbName = $business->db_name;
                // Validate database name to prevent injection attempts
                // if (!preg_match('/^[a-zA-Z0-9_]+$/', $dbName)) {
                //     \Log::critical('Invalid database name detected - possible SQL injection attempt', [
                //         'bus_config_id' => $bus_config_id,
                //         'db_name' => $dbName,
                //         'user_id' => auth()->id()
                //     ]);

                //     auth()->logout();
                //     session()->invalidate();
                //     return redirect()
                //         ->route('login')
                //         ->with('delete_message', 'Security violation detected. This incident has been logged.');
                // }
                // $dbExists = DB::select('SHOW DATABASES LIKE ?', [$dbName]);
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
                } else {
                    $business_package_features = DB::connection('master')
                        ->table('business_package_features')
                        ->where('business_package_id', $activePackage->business_packages_id)
                        ->pluck('feature_key');

                    session([
                        'is_trial' => $activePackage->is_trial,
                        'trial_end_date' => $activePackage->trial_end_date,
                        'start_date' => $activePackage->start_date,
                        'end_date' => $activePackage->end_date,
                        'features' => $business_package_features->toArray(),
                    ]);

                    app(TenantManager::class)->setTenant($bus_config_id);
                }
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

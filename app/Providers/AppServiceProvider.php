<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use App\Models\Translation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;
use Stancl\Tenancy\Events\TenancyBootstrapped;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


    public function boot()
    {
        Schema::defaultStringLength(191);
        $this->app->bind(\App\ViewModels\ISmsModel::class, \App\ViewModels\SmsModel::class);

        if (app()->runningInConsole()) {
            return;
        }

        $permissionLogic = function () {
            Blade::if('can', function ($permission) {
                $user = Auth::user();
                if (!$user) {
                    return false;
                }
                $role_has_permissions_list = Cache::remember(
                    'role_has_permissions_list' . $user->role_id,
                    60 * 60 * 24 * 365,
                    function () use ($user) {
                        return DB::connection('master')->table('permissions')
                            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                            ->where('role_id', $user->role_id)
                            ->select('permissions.name')
                            ->get();
                    }
                );
                $permissions = $role_has_permissions_list->pluck('name')->toArray();
                return in_array($permission, $permissions);
            });
        };
        $permissionLogic();

        //only check environment is local
        if (App::environment('local')) {
            // Log missing translations
            Lang::handleMissingKeysUsing(function ($key, $replacements, $locale) {
                // Check if the key already exists in the database
                $exists = DB::table('translations')->where('key', $key)->exists();

                if (!$exists) {
                    // Log only if key doesn't exist in DB
                    Log::warning("Missing translation key (not in DB): {$key}");

                    // OPTIONAL: insert into DB if you want to keep track automatically
                    /*
                    DB::table('translations')->insertOrIgnore([
                        'key' => $key,
                        'php_code' => $key,
                        'locale' => $locale, // optional
                    ]);
                    */
                }

                // Return key so app doesn't crash
                return $key;
            });
        }
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Auth;
use App\Models\Language;
use Illuminate\Support\Facades\Cache;

class Common
{
    use \App\Traits\TenantInfo;

    public function handle(Request $request, Closure $next)
    {
        //get general setting value
        $bus_config_id = session()->get('bus_config_id');
        $general_setting = DB::connection('master')
                ->table('general_settings')
                ->where('bus_config_id', $bus_config_id)
                ->latest()
                ->first();

        if (!$general_setting) {
            abort(500, 'General settings not configured. Please contact administrator.');
        }
        // Create a unique prefix for this tenant
        $key_prefix = 'tenant_' . $bus_config_id . '_';
        Cache::put($key_prefix . 'general_setting', $general_setting, 60*60*24*365);

        
        // ✅ Load and share business configuration data
        if ($bus_config_id) {
            $business_config = DB::connection('master')
                    ->table('business_configurations')
                    ->where('bus_config_id', $bus_config_id)
                    ->first();
            
            View::share('business_config', $business_config);
        }


        // ✅ Timezone setup
        $timezone = $general_setting->timezone ?? config('app.timezone');
        config(['app.timezone' => $timezone]);
        date_default_timezone_set($timezone);

        $todayDate = date("Y-m-d");
        // if(config('database.connections.saleprosaas_landlord')) {
        //     $subdomain = $this->getTenantId();
        //     if($general_setting->expiry_date) {
        //         $expiry_date = date("Y-m-d", strtotime($general_setting->expiry_date));
        //         if($todayDate > $expiry_date) {
        //             auth()->logout();
        //             return redirect('https://'.env('CENTRAL_DOMAIN').'/contact-for-renewal?id='.$subdomain);
        //         }
        //     }
        //     View::share('subdomain', $subdomain);
        // }
        //setting language
        // View::composer(['backend.layout.0main_rtl', 'backend.layout.main'], function ($view) {
        //     $languages = Cache::rememberForever('languages_list', function () {
        //         if (Schema::hasTable('languages')) {
        //             return Language::select('id', 'name')->orderBy('name')->get();
        //         }
        //         else {
        //             return collect();
        //         }
        //     });
            
        //     $view->with('languages', $languages);
        // });
                //setting language
        View::composer(['backend.layout.0main_rtl', 'backend.layout.main'], function ($view) {
            $languages = Cache::rememberForever('languages_list', function () {
                // Modified: Removed Schema check and used Model directly
                try {
                    return \App\Models\Language::select('id', 'name')->orderBy('name')->get();
                } catch (\Exception $e) {
                    return collect();
                }
            });
            
            $view->with('languages', $languages);
        });



        // --- Language & Translation Loading (Moved from AppServiceProvider) ---
        if (isset($_COOKIE['language'])) {
            \App::setLocale($_COOKIE['language']);
        } else {
            try {
                // Now works because SetTenantConnection has configured the DB
                $language = \App\Models\Language::where('is_default', true)->first();
                \App::setLocale($language->language ?? 'en');
            } catch (\Throwable $e) {
                \App::setLocale('en');
            }
        }
        
        try {
            $currentLocale = \App::getLocale(); // Get the locale we just set
            $translations = Cache::rememberForever("translations_{$currentLocale}", function () use ($currentLocale) {
                 return \App\Models\Translation::getTrnaslactionsByLocale($currentLocale);
            });
            if (!empty($translations)) {
                app('translator')->addLines($translations, $currentLocale);
            }
        } catch (\Throwable $e) {}
        // ---------------------------------------------------------------------

        //setting theme
        if(isset($_COOKIE['theme'])) {
            View::share('theme', $_COOKIE['theme']);
        }else {
            View::share('theme', 'light');
        }
        $currency = Cache::remember($key_prefix . 'currency', 60*60*24*365, function () use ($bus_config_id) {
            $settingData = DB::connection('master')
                ->table('general_settings')
                ->where('bus_config_id', $bus_config_id)
                ->latest()
                ->first();
            return \App\Models\Currency::find($settingData->currency);
        });


        View::share('general_setting', $general_setting);
        View::share('currency', $currency);
        config(['staff_access' => $general_setting->staff_access, 'is_packing_slip' => $general_setting->is_packing_slip, 'date_format' => $general_setting->date_format, 'currency' => $currency->symbol ?? $currency->code, 'currency_position' => $general_setting->currency_position, 'decimal' => $general_setting->decimal, 'is_zatca' => $general_setting->is_zatca, 'company_name' => $general_setting->company_name, 'vat_registration_number' => $general_setting->vat_registration_number, 'without_stock' => $general_setting->without_stock, 'addons' => $general_setting->modules]);


        $alert_product = DB::table('products')->where('is_active', true)->whereColumn('alert_quantity', '>', 'qty')->count();

        $dso_alert_product = DB::table('dso_alerts')->select('number_of_products')->whereDate('created_at', date("Y-m-d"))->first();
        if($dso_alert_product)
            $dso_alert_product_no = $dso_alert_product->number_of_products;
        else
            $dso_alert_product_no = 0;

        // Dynamic days from settings
        $days = $general_setting->expiry_alert_days ?? 0;
        // dd($days);

        $expire_alert_products = DB::table('product_batches')
            ->join('products', 'products.id', '=', 'product_batches.product_id')
            ->where('products.is_active', true)
            ->where('product_batches.qty', '>', 0)
            ->whereDate('product_batches.expired_date', '<=', now()->addDays($days)->format('Y-m-d'))
            ->count();

        // View share (exact same style)
        View::share([
            'alert_product'          => $alert_product,
            'dso_alert_product_no'   => $dso_alert_product_no,
            'expire_alert_products'  => $expire_alert_products,
        ]);


        $role = Cache::remember($key_prefix . 'user_role', 60*60*24*365, function () {
             return DB::connection('master')->table('roles')
                ->where('id', Auth::user()->role_id)
                ->where('bus_config_id', session('bus_config_id'))
                ->first();
        });
        View::share('role', $role);
        $permission_list = Cache::remember($key_prefix . 'permissions', 60*60*24*365, function () {
            return DB::connection('master')->table('permissions')->get();
        });
        View::share('permission_list', $permission_list);
        $role_has_permissions = Cache::remember($key_prefix . 'role_has_permissions', 60*60*24*365, function () {return DB::connection('master')->table('role_has_permissions')->where('role_id', Auth::user()->role_id)->get();
        });
        View::share('role_has_permissions', $role_has_permissions);

        $role_has_permissions_list = Cache::remember($key_prefix . 'role_has_permissions_list'.Auth::user()->role_id, 60*60*24*365, function () {
             return DB::connection('master')->table('permissions')->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')->where('role_id', Auth::user()->role_id)->select('permissions.name')->get();
        });
        View::share('role_has_permissions_list', $role_has_permissions_list);

        $categories_list = Cache::remember($key_prefix . 'category_list', 60*60*24*365, function () {
            return DB::table('categories')->where('is_active', true)->get();
        });
        View::share('categories_list', $categories_list);

        return $next($request);
    }
}

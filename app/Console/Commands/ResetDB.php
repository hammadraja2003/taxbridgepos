<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use DB;

class ResetDB extends Command
{
    use \App\Traits\CacheForget;

    protected $signature = 'reset:db';

    protected $description = 'Reset DB in the demo';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        //clearing all the cached queries
        $key_prefix = 'tenant_' . session('bus_config_id') . '_';
        $this->cacheForget($key_prefix . 'biller_list');
        $this->cacheForget($key_prefix . 'brand_list');
        $this->cacheForget($key_prefix . 'category_list');
        $this->cacheForget($key_prefix . 'coupon_list');
        $this->cacheForget($key_prefix . 'customer_list');
        $this->cacheForget($key_prefix . 'customer_group_list');
        $this->cacheForget($key_prefix . 'product_list');
        $this->cacheForget($key_prefix . 'product_list_with_variant');
        $this->cacheForget($key_prefix . 'warehouse_list');
        $this->cacheForget($key_prefix . 'table_list');
        $this->cacheForget($key_prefix . 'tax_list');
        $this->cacheForget($key_prefix . 'currency');
        $this->cacheForget($key_prefix . 'general_setting');
        $this->cacheForget($key_prefix . 'pos_setting');
        $this->cacheForget($key_prefix . 'user_role');
        $this->cacheForget($key_prefix . 'permissions');
        $this->cacheForget($key_prefix . 'role_has_permissions');
        $this->cacheForget($key_prefix . 'role_has_permissions_list');

        // Disable foreign key checks to avoid constraint issues
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        $tables = DB::select('SHOW TABLES');
        $key = 'Tables_in_' . env('DB_DATABASE');
        foreach ($tables as $table) {
            Schema::drop($table->$key);
        }
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        //importing data from DB
        DB::unprepared(file_get_contents(base_path('salepropos.sql')));
    }
}

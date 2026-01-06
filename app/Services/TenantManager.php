<?php
namespace App\Services;
use App\Models\BusinessConfiguration;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
class TenantManager
{
    protected $tenant;
    public function setTenant($tenantId)
    {
        $business = BusinessConfiguration::find($tenantId);
        if ($business) {
            // Set the connection configuration
            Config::set("database.connections.tenant", [
                'driver'      => 'mysql',
                'host'        => $business->db_host ?: '127.0.0.1',
                'port'        => $business->db_port ?? 3306,
                'database'    => $business->db_name,
                'username'    => $business->db_username,
                'password'    => $business->db_password,
                'charset'     => 'utf8mb4',
                'collation'   => 'utf8mb4_unicode_ci',
                'prefix'      => '',
                'strict'      => true,
                'engine'      => null,
            ]);
            
            // 🔥 VERY IMPORTANT
            DB::purge('tenant');
            Config::set('database.default', 'tenant');
            DB::purge();        // purge default connection
            DB::reconnect();    // reconnect default

            // Test tenant connection
            DB::connection()->select('SELECT 1');
            $this->tenant = $business;
        } else {
            throw new \Exception("Business configuration not found for tenant ID: {$tenantId}");
        }
    }
    public function getTenant()
    {
        return $this->tenant;
    }
    public function getTenantConnection()
    {
        return DB::connection('tenant');
    }
}
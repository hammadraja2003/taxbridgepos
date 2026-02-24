<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessConfiguration extends Model
{
    use HasFactory;

    protected $connection = 'master';
    protected $primaryKey = 'bus_config_id';

    protected $fillable = [
        'bus_name',
        'bus_ntn_cnic',
        'bus_address',
        'bus_province',
        'bus_logo',
        'bus_account_title',
        'bus_account_number',
        'bus_reg_num',
        'bus_contact_num',
        'bus_contact_person',
        'bus_IBAN',
        'bus_swift_code',
        'bus_acc_branch_name',
        'bus_acc_branch_code',
        'hash',
        'db_host',
        'db_name',
        'db_username',
        'db_password',
        'fbr_env',
        'fbr_api_token_sandbox',
        'fbr_api_token_prod',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'bus_config_id', 'bus_config_id');
    }

    public function scenarios()
    {
        return $this->belongsToMany(
            SandboxScenario::class,
            'business_scenarios',
            'bus_config_id',
            'scenario_id'
        )->withTimestamps();
    }
}

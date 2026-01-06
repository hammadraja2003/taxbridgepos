<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Roles extends SpatieRole
{
    protected $connection = 'master';
    protected $table = 'roles';

    protected $fillable =[
        "name", "description", "guard_name", "is_active" ,"bus_config_id"
    ];
}

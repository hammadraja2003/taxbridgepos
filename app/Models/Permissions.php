<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permissions extends SpatiePermission
{
    protected $connection = 'master';
    protected $table = 'permissions';
    
    protected $fillable = [
        'name',
        'guard_name',
        'created_at',
        'updated_at'
    ];
}

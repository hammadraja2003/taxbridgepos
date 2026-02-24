<?php

namespace App\Models;

use App\Models\Roles;
use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    protected $connection = 'master';
    protected $table = 'permissions';

    protected $fillable = [
        'name',
        'guard_name',
        'created_at',
        'updated_at'
    ];

    public function roles()
    {
        return $this->belongsToMany(
            Roles::class,
            'role_has_permissions',
            'permission_id',
            'role_id'
        );
    }
}

<?php

namespace App\Models;

use App\Models\Roles as Role;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    // use HasRoles;

    protected $connection = 'master';

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'company_name', 'role_id', 'biller_id', 'warehouse_id', 'kitchen_id', 'service_staff', 'is_active', 'is_deleted', 'bus_config_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isActive()
    {
        return $this->is_active;
    }

    public function holiday()
    {
        return $this->hasMany('App\Models\Holiday');
    }

    public function notifications()
    {
        return $this->morphMany(\App\Models\Notification::class, 'notifiable')->latest();
    }

    // 👇 Append role_type automatically to user object
    protected $appends = ['role_type'];

    // Relationship with roles table
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // Accessor for role_type
    public function getRoleTypeAttribute()
    {
        return $this->role ? $this->role->role_type : null;
    }
}

<?php

namespace App\Models;

use App\Models\Permissions;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $connection = 'master';
    protected $table = 'roles';

    protected $fillable = [
        'name', 'description', 'guard_name', 'is_active', 'bus_config_id', 'role_type'
    ];

    public function permissions()
    {
        return $this->belongsToMany(
            Permissions::class,
            'role_has_permissions',
            'role_id',
            'permission_id'
        );
    }

    public function hasPermissionTo(string $permissionName): bool
    {
        return $this
            ->permissions()
            ->where('name', $permissionName)
            ->exists();
    }

    public function givePermissionTo(Permissions $permission): void
    {
        // avoid duplicate insert
        if (!$this->permissions()->where('permission_id', $permission->id)->exists()) {
            $this->permissions()->attach($permission->id);
        }
    }

    public function revokePermissionTo(string $permissionName): void
    {
        $permission = Permissions::where('name', $permissionName)->first();

        if ($permission) {
            $this->permissions()->detach($permission->id);
        }
    }

    public static function findByName(string $name)
    {
        $busConfigId = session('bus_config_id');
        if (!$busConfigId) {
            throw new \Exception('Business context not set in session.');
        }
        return static::where('name', $name)
            ->where('bus_config_id', $busConfigId)
            ->firstOrFail();
    }
}

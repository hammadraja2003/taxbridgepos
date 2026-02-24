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
        'name', 'email', 'password', 'phone', 'company_name', 'role_id', 'biller_id', 'warehouse_id', 'kitchen_id', 'service_staff', 'is_active', 'is_deleted', 'bus_config_id', 'two_factor_enabled', 'two_factor_secret', 'two_factor_recovery_codes', 'two_factor_confirmed_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'is_deleted' => 'boolean',
        'two_factor_enabled' => 'boolean',
        'two_factor_confirmed_at' => 'datetime',
    ];

    /**
     * Check if user has two-factor authentication enabled
     */
    public function hasTwoFactorEnabled(): bool
    {
        return $this->two_factor_enabled && !empty($this->two_factor_secret);
    }

    /**
     * Get the recovery codes as an array
     */
    public function getRecoveryCodesAttribute($value): array
    {
        return $value ? json_decode($value, true) : [];
    }

    /**
     * Set the recovery codes
     */
    public function setRecoveryCodesAttribute($value): void
    {
        $this->attributes['two_factor_recovery_codes'] = is_array($value)
            ? json_encode($value)
            : $value;
    }

    /**
     * Generate new recovery codes
     */
    public function generateRecoveryCodes(): array
    {
        $codes = [];
        for ($i = 0; $i < 8; $i++) {
            $codes[] = strtoupper(substr(bin2hex(random_bytes(5)), 0, 10));
        }

        $this->two_factor_recovery_codes = $codes;
        $this->save();

        return $codes;
    }

    /**
     * Use a recovery code
     */
    public function useRecoveryCode(string $code): bool
    {
        $codes = $this->recovery_codes;

        if (in_array(strtoupper($code), $codes)) {
            $this->two_factor_recovery_codes = array_values(
                array_diff($codes, [strtoupper($code)])
            );
            $this->save();
            return true;
        }

        return false;
    }

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

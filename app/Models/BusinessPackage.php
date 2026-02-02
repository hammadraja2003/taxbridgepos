<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessPackage extends Model
{
    use HasFactory;

    protected $connection = 'master';

    protected $table = 'business_packages';
    protected $primaryKey = 'business_packages_id';
    public $timestamps = false;

    protected $fillable = [
        'business_id',
        'package_id',
        'start_date',
        'end_date',
        'discount',
        'price_after_discout',
        'is_active',
        'is_trial',
        'trial_end_date',
        // Legacy fillables
        'name',
        'price',
        'duration_days',
        'name',
        'price',
        'duration_days',
        'description'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_trial' => 'boolean',
        'trial_end_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function business()
    {
        return $this->belongsTo(BusinessConfiguration::class, 'business_id', 'bus_config_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'package_id');
    }

    public function features()
    {
        return $this->hasMany(BusinessPackageFeature::class, 'business_package_id', 'business_packages_id');
    }

    public function packageFeatures()
    {
        return $this->hasMany(BusinessPackageFeature::class, 'business_package_id', 'business_packages_id');
    }

    public function usage()
    {
        return $this->hasMany(BusinessFeatureUsage::class, 'business_package_id', 'business_packages_id');
    }
}

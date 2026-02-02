<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $connection = 'master';
    protected $primaryKey = 'package_id';
    protected $fillable = [
        'package_name',
        'package_description',
        'package_price',
        'package_billing_cycle',
    ];

    public function features()
    {
        return $this->hasMany(PackageFeature::class, 'package_id', 'package_id');
    }

    public function businessPackages()
    {
        return $this->hasMany(BusinessPackage::class, 'package_id', 'package_id');
    }
}

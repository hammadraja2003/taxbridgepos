<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageFeature extends Model
{
    use HasFactory;
    protected $connection = 'master';
    
    public $timestamps = false;

    protected $fillable = [
        'package_id',
        'feature_key',
        'limit_type',
        'limit_value',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'package_id');
    }
}


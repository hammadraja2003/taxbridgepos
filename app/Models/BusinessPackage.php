<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessPackage extends Model
{
    use HasFactory;

    protected $table = 'business_packages';

    protected $fillable = [
        'name',
        'is_trial',
        'is_active',
        'price',
        'duration_days',
        'description'
    ];
}

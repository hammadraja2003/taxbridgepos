<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessScenario extends Model
{
    use HasFactory;

    protected $table = 'business_scenarios';

    protected $fillable = [
        'name',
        'description'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{   
    protected $connection = 'tenant';   
    protected $fillable =[
        "name", "is_active"
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrmSetting extends Model
{   
    protected $connection = 'tenant';   
    protected $fillable =[
        "checkin", "checkout"
    ];
}

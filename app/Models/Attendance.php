<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $connection = 'tenant';       
    protected $fillable =[
        "date", "employee_id", "user_id",
        "checkin", "checkout", "status", "note"
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminMailSetting extends Model
{
    use HasFactory;
    
    protected $connection = 'master';
    protected $table = 'admin_mail_settings';
    
    protected $fillable = [
        "driver", 
        "host", 
        "port", 
        "from_address", 
        "from_name", 
        "username", 
        "password", 
        "encryption"
    ];
}

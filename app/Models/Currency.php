<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $connection = 'tenant';
    protected $fillable = ["name", "code", "symbol", "exchange_rate", "is_active"];
}

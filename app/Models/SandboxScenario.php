<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SandboxScenario extends Model
{
    use HasFactory;

    protected $connection = 'master';
    protected $table = 'sandbox_scenarios';
    protected $primaryKey = 'scenario_id';

    protected $fillable = [
        'scenario_code',
        'scenario_description',
        'sale_type'
    ];
}

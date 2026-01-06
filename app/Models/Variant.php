<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{   
    protected $connection = 'tenant';   
    protected $fillable = ['name'];

    public function product()
    {
    	return $this->belongsToMany('App\Models\Variant', 'product_variants');
    }
}

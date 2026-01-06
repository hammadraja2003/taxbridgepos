<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_Supplier extends Model
{   
    protected $connection = 'tenant';   
	protected $table = 'product_supplier';
    protected $fillable =[

        "product_code", "supplier_id", "qty", "price"
    ];
}

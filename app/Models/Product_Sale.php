<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_Sale extends Model
{
    protected $connection = 'tenant';   
	protected $table = 'product_sales';
    protected $fillable =[
        "sale_id", "product_id", "product_batch_id", "variant_id", 'imei_number', "qty", "return_qty", "sale_unit_id", "net_unit_price", "discount", "tax_rate", "tax", "total", "is_packing", "is_delivered","topping_id","value_sales_excluding_st","fixed_notified_value_or_retail_price" , "sales_tax_withheld_at_source" , "extra_tax", "further_tax", "sro_schedule_no", "fed_payable","sale_type","sro_item_serial_no"
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }
}

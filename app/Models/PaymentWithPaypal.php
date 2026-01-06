<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentWithPaypal extends Model
{   
    protected $connection = 'tenant';           
    protected $table = 'payment_with_paypal';
    protected $fillable =[
        "payment_id", "transaction_id"
    ];
}

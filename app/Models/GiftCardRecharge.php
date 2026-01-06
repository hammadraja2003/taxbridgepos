<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftCardRecharge extends Model
{   
    protected $connection = 'tenant';           
    protected $table = 'gift_card_recharges';

    protected $fillable =[

        "gift_card_id", "amount", "user_id"
    ];
}

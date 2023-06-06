<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'me_order_id',
        'product_id',
        'unit',
        'quantity',
        'me_id',
        'distributor_id',
        'total_price',
        'channel_id',
        'company_id',
        'status'
    ];

}

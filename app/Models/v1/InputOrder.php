<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputOrder extends Model
{
    use HasFactory;
    protected $hidden =['id'];

    public function getRouteKeyName()
    {
        return 'order_id';
    }

    protected $fillable = [
        'order_id',
        'me_id',
        'total_price',
        'channel_id',
        'sold_to',
        'status',
        'payment_method',
        'payment_id',
        'delivery_status',
        'hq_commission',
        'me_commission',
        'distributor_commission',
    ];
}

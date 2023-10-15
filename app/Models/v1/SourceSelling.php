<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SourceSelling extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_id',
        'customer_id',
        'sell_location',
        'sell_price',
        'quantity',
        'sold_by',
        'market_type',
        'payment_id',
    ];
}

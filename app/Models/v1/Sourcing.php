<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sourcing extends Model
{
    use HasFactory;
    protected $fillable = [
        'source_id',
        'product_name',
        'product_image',
        'buy_price',
        'sell_price',
        'quantity',
        'unit',
        'description',
        'category',
        'which_farmer',
        'source_by',
        'transportation_id',

    ];
}

<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sourcing extends Model
{
    use HasFactory;
    protected $fillable = [
        'source_id',
        'batch_id',
        'product_name',
        'product_images',
        'buy_price',
        'sell_price',
        'quantity',
        'variety',
        'unit',
        'description',
        'which_farmer',
        'source_by',
        'source_location',
        'is_sorted',
        'is_active',
    ];

    protected $casts = [
        'product_images' => 'array',
    ];
   
}

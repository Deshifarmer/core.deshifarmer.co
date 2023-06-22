<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $hidden =['id'];
    public function getRouteKeyName()
    {
        return 'product_id';
    }

    protected $fillable = [
        'product_id',
        'name',
        'image',
        'description',
        'preferred',
        'unit',
        'category_id',//category_id
        'subcategory_id',//subcategory_id
        'company_id',
        'buy_price_from_company',
        'sell_price_from_company',
        'sell_price',
        'discount',
        'hq_commission',
        'me_commission',
        'distributor_commission',
        'status'
    ];
}

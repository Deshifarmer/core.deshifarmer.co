<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'seed_name',
        'seed_company',
        'seed_price',
        'seed_quantity',
        'seed_unit',
        'details',
    ];
}

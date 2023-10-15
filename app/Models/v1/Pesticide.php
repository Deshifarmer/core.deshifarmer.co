<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesticide extends Model
{
    use HasFactory;
    protected $fillable = [
        'batch_id',
        'pesticide_type',
        'pesticide_name',
        'amount',
        'details',
    ];
}

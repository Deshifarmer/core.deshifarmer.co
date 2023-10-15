<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fertilization extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'fertilizer_type',
        'fertilizer_name',
        'amount',
        'details',
    ];
}

<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'farmer_id',
        'me_id',
        'cp_id',
        'current_seed',
        'current_fertilizer',
        'current_pesticide',
        'future_seed',
        'future_fertilizer',
        'future_pesticide',
    ];

    protected $cast = [
        'current_seed' => 'array',
        'current_fertilizer' => 'array',
        'current_pesticide' => 'array',
        'future_seed' => 'array',
        'future_fertilizer' => 'array',
        'future_pesticide' => 'array',
    ];
}

<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandPreparation extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'images',
        'land_preparation_date',
        'details',
    ];

    protected $casts = [
        'images' => 'array',
    ];
}

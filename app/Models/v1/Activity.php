<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'farmer_id',
        'farm',
        'crop',
        'type',
        'quantity',
        'unit',
        'location',
        'activity_by',
        'details',
        'images',
    ];
}

<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{
    use HasFactory;
    protected $hidden = ['id'];
    public function getRouteKeyName()
    {
        return 'farm_id';
    }
    protected $fillable =[
        'farm_id',
        'farmer_id',
        'farm_name',
        'gallery',
        'farm_reg_no',
        'address',
        'union',
        'mouaza',
        'lat',
        'long',
        'farm_area',
        'soil_type',
        'current_crop',
        'starting_date',
        'isActive',
    ];

}

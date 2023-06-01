<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmersPoint extends Model
{
    use HasFactory;
    protected $hidden =['id'];

    public function getRouteKeyName()
    {
        return 'farmers_point_id';
    }
    protected $fillable = [
        'farmers_point_id',
        'title',
        'address',
        'farmers_point_type',
        'current_manager',
        'mobile_number',
    ];
}

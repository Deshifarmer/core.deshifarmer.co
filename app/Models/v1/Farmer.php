<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;

    protected $hidden =['id'];

    public function getRouteKeyName()
    {
        return 'farmer_id';
    }
    protected $fillable = [
        'farmer_id',
        'image',
        'farmer_type',
        'input_by',
        'nid',
        'first_name',
        'last_name',
        'phone',
        'gender',
        'date_of_birth',
        'address',
        'village',
        'upazila',
        'district',
        'division',
        'credit_score',
        'land_status',
        'family_member',
        'number_of_children',
        'yearly_income',
        'year_of_stay_in',
        'groyp_id',
        'farmer_role',
        'farm_id',
        'is_active',
    ];

}

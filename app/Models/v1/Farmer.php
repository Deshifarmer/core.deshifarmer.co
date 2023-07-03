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
        'onboard_by',
        'nid',
        'gov_farmer_id',
        'first_name',
        'last_name',
        'fathers_name',
        'phone',
        'is_married',
        'gender',
        'date_of_birth',
        'address',
        'village',
        'upazila',
        'district',
        'division',
        'credit_score',
        'resident_type',
        'family_member',
        'number_of_children',
        'yearly_income',
        'year_of_stay_in',
        'group_id',
        // 'farmer_role',
        'bank_details',
        'mfs_account',
        'current_producing_crop',
        'focused_crop',
        'farm_id',
        'cropping_intensity',
        'cultivation_practice',
        'is_active',
    ];
    protected $casts =[
        'group_id'=>'json',
        'bank_details'=>'object',
        'mfs_account'=>'json',
        'current_producing_crop'=>'json',
        'focused_crop'=>'json',
        'farm_id'=>'json',
    ];
    protected $appends = [
        'full_name',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }


}

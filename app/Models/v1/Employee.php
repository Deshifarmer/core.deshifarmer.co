<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $hidden = ['id'];
    public function getRouteKeyName()
    {
        return 'df_id';
    }
    protected $fillable = [
        'df_id',
        'first_name',
        'last_name',
        'nid',
        'email',
        'phone',
        'type',
        'onboard_by',
        'designation',
        'previous_designation',
        'previous_company',
        'photo',
        'date_of_birth',
        'present_address',
        'permanent_address',
        'home_district',
        'joining_date',
        'gender',
        'department',
        'work_place',
        'comission',
        'target_volume',
        'channel',
        'channel_assign_by',
        'under'
    ];

    protected $appends = [
        'full_name',
    ];


    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}

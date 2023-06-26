<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerGroup extends Model
{
    use HasFactory;
    protected $hidden = ['id'];
    public function getRouteKeyName()
    {
        return 'farmer_group_id';
    }
    protected $fillable =[
        'farmer_group_id',
        'farmer_group_name',
        'cluster_id',
        'isActive',
        'inactive_at',
        'group_manager_id',
        'group_leader',
    ];
}

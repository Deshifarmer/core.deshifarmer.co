<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    use HasFactory;
    protected $hidden = ['id'];
    public function getRouteKeyName()
    {
        return 'cluster_id';
    }

    protected $fillable =[
        'cluster_id',
        'cluster_name',
        'created_by',
        'channel_id',
    ];

}

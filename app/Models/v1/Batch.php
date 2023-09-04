<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{

    use HasFactory;
    public function getRouteKeyName()
    {
        return 'batch_id';
    }
    protected $fillable = [
        'batch_id',
        'season',
        'farm_id',
        'which_crop',
        'created_by'
    ];
}

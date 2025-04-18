<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = [
        'activity',
        'images',
        'batch_id',
        'track_by'
    ];
    protected $casts = [
        'images' => 'array',
        'activity' => 'json'
    ];
}

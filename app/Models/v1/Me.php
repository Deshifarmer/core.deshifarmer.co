<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Me extends Model
{
    use HasFactory;

    protected $fillable = [
        'deshifarmer_id',
        'channel_id',
        'assign_by'
    ];

}

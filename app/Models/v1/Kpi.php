<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
    use HasFactory;
    protected $fillable = [
        'starting_date',
        'ending_date',
        'type',
        'target',
        'for',
        'note',
    ];
}

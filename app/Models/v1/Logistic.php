<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'log_id',
        'from',
        'to',
        'vehicle_type',
        'weight',
        'price',
        'request_by',
        'diver_name',
        'phone_no',
        'car_no',
        'status',
    ];
}

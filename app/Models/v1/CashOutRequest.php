<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashOutRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'requested_by',
        'amount',
        'accepted',
        'number',
        'cash_out_method',
        'status',
        'remarks'
    ];
}

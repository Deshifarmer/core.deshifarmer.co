<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashInRequest extends Model
{
    use HasFactory;

    protected $hidden = ['id'];
    public function getRouteKeyName()
    {
        return 'receipt_id';
    }

    protected $fillable = [
        'df_id',
        'requested',
        'accepted_amount',
        'receipt',
        'receipt_id',
        'status',
    ];
}

<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $hidden = ['id'];
    public function getRouteKeyName()
    {
        return 'transaction_id';
    }

    protected $fillable = [
        'transaction_id',
        'amount',
        'order_id',
        'method',
        'credited_to',
        'debited_from',
        'authorized_by',
    ];
}

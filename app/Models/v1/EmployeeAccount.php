<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAccount extends Model
{
    use HasFactory;
    protected $hidden = ['id'];
    public function getRouteKeyName()
    {
        return 'acc_number';
    }

    protected $fillable = [
        'acc_number',
        'net_balance',
        'total_credit',
        'total_debit',
        'last_transaction',
        'last_transaction_amount',
    ];
}

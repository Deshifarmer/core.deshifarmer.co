<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerDeposit extends Model
{
    use HasFactory;
    protected $hidden =['id'];
    public function getRouteKeyName()
    {
        return 'deposit_id';
    }
    protected $fillable = [
        'deposit_id',
        'farmer_id',
        'amount',
        'deposit_method',
        'deposit_status',
        'transaction_id',
        'which_input_order_id',
        'rcv_by_me_id',
        'rcv_by_dis_id'
    ];
}

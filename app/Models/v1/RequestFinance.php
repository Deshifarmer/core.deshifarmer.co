<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestFinance extends Model
{
    use HasFactory;

    protected $fillable = [
        'which_farmer',
        'season',
        'producing_crop',
        'variety',
        'purpose_of_loan',
        'order_id',
        'which_fp',
        'df_approved_loan',
        'amount_of_loan',
        'season_and_eta_sales',
        'note',
        'payment_schedule',
        'payment_dates',
        'status'

    ];

     protected $casts =[

        'payment_dates'=>'json',
    ];


}

<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutputCustomer extends Model
{
    use HasFactory;
    protected $hidden =['id'];

    public function getRouteKeyName()
    {
        return 'customer_id';
    }

    protected $fillable = [
        'customer_id',
        'name',
        'email',
        'address',
        'phone_number',
        'onboard_by'
    ];
}

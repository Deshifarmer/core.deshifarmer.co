<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributors_file extends Model
{
    use HasFactory;
    protected $hidden =['id'];

    public function getRouteKeyName()
    {
        return 'df_id';
    }
    protected $fillable = [
        'df_id',
        'business_present_address',
        'business_contact_no',
        'signature',
        'bio_data',
        'tin_no',
        'trade_license',
        'agri_license',
        'vat_certificate',
        'bank_solvency',
        'nid_front',
        'nid_back',
        'character_certificate',
        'tax_report',
        'owner_prove',
    ];
}

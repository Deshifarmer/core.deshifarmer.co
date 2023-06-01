<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributorInfo extends Model
{
    use HasFactory;
    protected $hidden =['id'];

    public function getRouteKeyName()
    {
        return 'distributor_id';
    }

    protected $fillable = [
        'distributor_id',
        'company_name',
        'business_type',
        'business_present_address',
        'business_contact_no',
        'is_known_to_deshi_farmer',
        'interested_to_invest_ammount',
        'interested_to_earn_from_df',
        'applicent_name',
        'applicent_age',
        'gender',
        'nationality',
        'permanent_address',
        'present_address',
        'personal_contact_no',
        'nid_no',
        'tin_no',
        'signature',
        'bio_data',
        'trade_licence',
        'agro_licence',
        'vat_certificate',
        'bank_solvency',
        'nid',
        'character_certificate',
        'tax_report',
        'owner_prove',
        'foujdari_oporadh_sawgohon_potro',
        'image',
        'refference',
        'status',
    ];
    protected $casts = [
        'refference' => 'json',
    ];

}

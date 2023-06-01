<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DistributorInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'distributor_id'=>$this->distributor_id,
            'company_name'=>$this->company_name,
            'business_type'=>$this->business_type,
            'business_present_address'=>$this->business_present_address,
            'business_contact_no'=>$this->business_contact_no,
            'is_known_to_deshi_farmer'=>$this->is_known_to_deshi_farmer,
            'interested_to_invest_ammount'=>$this->interested_to_invest_ammount,
            'interested_to_earn_from_df'=>$this->interested_to_earn_from_df,
            'applicent_name'=>$this->applicent_name,
            'applicent_age'=>$this->applicent_age,
            'gender'=>$this->gender,
            'nationality'=>$this->nationality,
            'permanent_address'=>$this->permanent_address,
            'present_address'=>$this->present_address,
            'personal_contact_no'=>$this->personal_contact_no,
            'nid_no'=>$this->nid_no,
            'tin_no'=>$this->tin_no,
            'signature'=>$this->signature,
            'bio_data'=>$this->bio_data,
            'trade_licence'=>$this->trade_licence,
            'agro_licence'=>$this->agro_licence,
            'vat_certificate'=>$this->vat_certificate,
            'bank_solvency'=>$this->bank_solvency,
            'nid'=>$this->nid,
            'character_certificate'=>$this->character_certificate,
            'tax_report'=>$this->tax_report,
            'owner_prove'=>$this->owner_prove,
            'foujdari_oporadh_sawgohon_potro'=>$this->foujdari_oporadh_sawgohon_potro,
            'image'=>$this->image,
            'refference'=>$this->refference,
            'status'=>$this->status,
        ];
    }
}

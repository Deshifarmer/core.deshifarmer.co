<?php

namespace App\Http\Resources\v1;

use App\Models\v1\Farmer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FinanceRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $farmer= Farmer::where('farmer_id',$this->which_farmer)->first();
        return [
            'id' => $this->id,
            'which_farmer' => $this->which_farmer,
            'farmer_name' =>$farmer->full_name,
            'season' => $this->season,
            'producing_crop' => $this->producing_crop,
            'variety' => $this->variety,
            'purpose_of_loan' => $this->purpose_of_loan,
            'amount_of_loan' => $this->amount_of_loan,
            'season_and_eta_sales'=>$this->season_and_eta_sales,
            'note'=>$this->note,
            'payment_schedule'=>$this->payment_schedule,
            'payment_dates'=>$this->payment_date,
            'status'=>$this->payment_status,
            'created_at'=>$this->created_at
        ];
    }
}

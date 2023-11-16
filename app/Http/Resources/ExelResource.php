<?php

namespace App\Http\Resources;

use App\Models\v1\Employee;
use App\Models\v1\Farmer;
use App\Models\v1\SourceSelling;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $farmer = Farmer::where('farmer_id',$this->which_farmer)->first();
        $sourceSelling = SourceSelling::where('source_id', $this->source_id)->first();
        $me = Employee::where('df_id',$this->source_by)->first();
        return [
            'farmer_df_id'=>$farmer->farmer_id,
            'participant_id' => $farmer->usaid_id,
            'participant_name'=>$farmer->full_name,
            'commodity'=>$this->product_name,
            'qty_sold'=>$sourceSelling->quantity,
            'unit'=>$this->unit,
            'price'=>$this->sell_price,
            'village'=>$sourceSelling->sell_location,
            'me_name'=>$me->full_name
        ];
    }
}

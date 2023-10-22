<?php

namespace App\Http\Resources\v1;

use App\Models\v1\OutputCustomer;
use App\Models\v1\Sourcing;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SourceSellingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'source_id'=>$this->source_id,
            
            'source_details'=>SourcingResource::make(Sourcing::where('source_id',$this->source_id)->first()),
            'customer_id'=>$this->customer_id,
            'customer_details'=>OutputCustomerResource::make(OutputCustomer::where('customer_id',$this->customer_id)->first()),
            'sell_location'=>$this->sell_location,
            'sell_price'=>$this->sell_price,
            'quantity'=>$this->quantity,
            'sold_by'=>$this->sold_by,
            'market_type'=>$this->market_type,
            'payment_id'=>$this->payment_id,
            'created_at'=>$this->created_at,
        ];
    }
}

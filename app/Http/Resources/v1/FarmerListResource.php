<?php

namespace App\Http\Resources\v1;

use App\Models\v1\InputOrder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FarmerListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'full_name' => $this->full_name,
            'farmer_id' => $this->farmer_id,
            'usaid_id' => $this->usaid_id,
            'image'=>$this->image,
            'phone' => $this->phone,
            'address'=>$this->address,
            'group_id'=>$this->group_id,
            'order_list' => InputOrderResource::collection(InputOrder::where('sold_to',$this->farmer_id)->get()),
        ];
    }
}

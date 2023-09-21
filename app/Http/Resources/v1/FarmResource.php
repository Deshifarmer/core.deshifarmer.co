<?php

namespace App\Http\Resources\v1;

use App\Models\v1\Batch;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FarmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'farm_id'=>$this->farm_id,
            'farmer_id'=>$this->farmer_id,
            'farm_name'=>$this->farm_name,
            'gallery'=>$this->gallery,
            'farm_reg_no'=>$this->farm_reg_no,
            'address'=>$this->address,
            'union'=>$this->union,
            'mouaza'=>$this->mouaza,
            'lat'=>$this->lat,
            'long'=>$this->long,
            'farm_area'=>$this->farm_area,
            'soil_type'=>$this->soil_type,
            'current_crop'=>$this->current_crop,
            'starting_date'=>$this->starting_date,
            'isActive'=>$this->isActive,

            'batch'=>$this->when($request->routeIs(['hq.farm.show','hq.farmer_farm']), BatchResource::collection(Batch::where('farm_id', $this->farm_id)->get()))

        ];
    }
}

<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FarmersPointResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'farmers_point_id' => $this->farmers_point_id,
            'title'=> $this->title,
            'address'=> $this->address,
            'farmers_point_type'=> $this->farmers_point_type,
            'current_manager'=> $this->current_manager,
            'mobile_number'=> $this->mobile_number,
        ];
    }
}

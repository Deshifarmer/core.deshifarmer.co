<?php

namespace App\Http\Resources\v1;

use App\Models\v1\District;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupLeaderDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'farmer_id' => $this->farmer_id,
            'full_name' => $this->full_name,
            'first_name' => $this->first_name,
            'last_name' =>$this->last_name,
            'district' => District::where('id', $this->district)->first()->name,
            'phone' => $this->phone,
            'gender'=> $this->gender,
            'address' => $this->address,
            'image' => $this->image,
            'farm_area'=> $this->farm_area,

        ];
    }
}

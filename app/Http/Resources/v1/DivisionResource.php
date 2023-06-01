<?php

namespace App\Http\Resources\v1;

use App\Models\v1\District;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DivisionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'bn_name' => $this->bn_name,
            'lat' => $this->lat,
            'long' => $this->long,
            // when appended
            'districts' => $this->whenAppended('districts', function () {
                return DistrictResource::collection(District::where('division_id', $this->id)->get());
            })
        ];
    }
}

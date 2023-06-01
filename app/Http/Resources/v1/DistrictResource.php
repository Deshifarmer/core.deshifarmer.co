<?php

namespace App\Http\Resources\v1;

use App\Models\v1\Upazila;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DistrictResource extends JsonResource
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
            // 'division_id' => $this->division_id,
            'name' => $this->name,
            'bn_name' => $this->bn_name,
            'lat' => $this->lat,
            'long' => $this->long,
            'upazila' => UpazilaResource::collection(Upazila::where('district_id', $this->id)->get())

        ];
    }
}

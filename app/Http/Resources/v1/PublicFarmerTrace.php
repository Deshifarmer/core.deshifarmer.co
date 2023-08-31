<?php

namespace App\Http\Resources\v1;

use App\Models\v1\Activity;
use App\Models\v1\District;
use App\Models\v1\Division;
use App\Models\v1\Farm;
use App\Models\v1\Upazila;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicFarmerTrace extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'farmer_details' => [
                'id' => $this->farmer_id,
                'name' => $this->full_name,
                'address' => $this->address,
                'village' => $this->village,
                'upazila' => Upazila::where('id', $this->upazila)->get()->implode('name'),
                'district' => District::where('id', $this->district)->get()->implode('name'),
                'division' => Division::where('id', $this->division)->get()->implode('name'),
                'image' => $this->image,
            ],
            'farm_list'=>
                Farm::where('farmer_id', $this->farmer_id)->get()->map(function ($farm) {
                    return [
                        'name' => $farm->farm_name,
                        'address' => $farm->address,
                        'gallery' => $farm->gallery,
                        'latitude' => $farm->lat,
                        'longitude' => $farm->long,
                        'farm_area' => $farm->farm_area,
                        'crop' => $farm->current_crop,
                        'soil_type' => $farm->soil_type,
                        'activity' => $farm->farm_id

                    ];
                }),

        ];
    }
}

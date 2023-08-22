<?php

namespace App\Http\Resources\v1;

use App\Models\v1\Farmer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
            'farmer_id' => $this->farmer_id,
            'farmer_details' => Farmer::where('farmer_id', $this->farmer_id)->get()->map(function ($farmer) {
                return [

                    'full_name' => $farmer->full_name,
                    'phone' => $farmer->phone,
                    'image' => $farmer->image,
                ];
            }),
            'farm' => $this->farm, 
            'crop' => $this->crop,
            'type' => $this->type,
            'quantity' => $this->quantity,
            'unit' => $this->unit,
            'location' => $this->location,
            'activity_by' => $this->activity_by,
            'details' => $this->details,
            'images' => $this->images,
            'created_at' => $this->created_at->diffForHumans(),

        ];
    }
}

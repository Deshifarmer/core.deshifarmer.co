<?php

namespace App\Http\Resources\v1;

use App\Models\v1\Activity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'batch_id' => $this->batch_id,
            'season' => $this->season,
            'farm_id' => $this->farm_id,
            'which_crop' => $this->which_crop,
            'created_by' => $this->created_by,

            'activities' => ActivityResource::collection( Activity::where('batch_id', $this->batch_id)->get())
        ];
    }
}

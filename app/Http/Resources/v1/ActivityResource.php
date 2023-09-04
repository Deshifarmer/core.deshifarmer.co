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
            'activity' => $this->activity,
            'images' => $this->images,
        ];
    }
}

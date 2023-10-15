<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SowingResource extends JsonResource
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
            'batch_id' => $this->batch_id,
            'seed_name' => $this->seed_name,
            'seed_company' => $this->seed_company,
            'seed_price' => $this->seed_price,
            'seed_quantity' => $this->seed_quantity,
            'seed_unit' => $this->seed_unit,
            'details' => $this->details,
        ];
    }
}

<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SourcingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'source_id' => $this->source_id,
            'product_name' => $this->product_name,
            'product_images' => $this->product_images,
            'buy_price' => $this->buy_price,
            'sell_price' => $this->sell_price,
            'quantity' => $this->quantity,
            'unit' => $this->unit,
            'description' => $this->description,
            'category' => $this->category,
            'which_farmer' => $this->which_farmer,
            'source_by' => $this->source_by,
            'transportation_id' => $this->transportation_id,
        ];
    }
}

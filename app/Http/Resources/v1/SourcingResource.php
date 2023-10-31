<?php

namespace App\Http\Resources\v1;

use App\Models\v1\Farmer;
use App\Models\v1\Upazila;
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
            'batch_id' => $this->batch_id,
            'product_name' => $this->product_name,
            'product_images' => $this->product_images,
            'buy_price' => $this->buy_price,
            'sell_price' => $this->sell_price,
            'quantity' => $this->quantity,
            'unit' => $this->unit,
            'description' => $this->description,
            // 'category' => $this->category,
            'which_farmer' => $this->which_farmer,
            'farmer_name' =>Farmer::where('farmer_id', $this->which_farmer)->first()->first_name . ' ' . Farmer::where('farmer_id', $this->which_farmer)->first()->last_name,
            'usaid_id' => Farmer::where('farmer_id', $this->which_farmer)->first()->usaid_id ?? null,
            'source_by' => $this->source_by,
            'transportation_id' => $this->transportation_id,
            'source_location' => Upazila::where('id', $this->source_location)->first()->name,
            'created_at' => $this->created_at,
        ];
    }
}

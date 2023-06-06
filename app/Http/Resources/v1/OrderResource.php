<?php

namespace App\Http\Resources\v1;

use App\Models\v1\Product;
use App\Models\v1\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $unit = Unit::where('id', $this->unit)->get()->implode('unit');
        return [
            'id' => $this->id,
            'me_order_id' => $this->me_order_id,
            'me_id' => $this->me_id,
            'distributor_id' => $this->distributor_id,
            'product_id' => $this->product_id,
            'product_details' => new ProductResource(Product::where('product_id', $this->product_id)->first()),
            'unit' =>Unit::where('id', $this->unit)->get()->implode('unit'),
            'quantity' => $this->quantity,
            'total_price'=>$this->total_price,
            'status'=>$this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'location' => $this->channel_id,
        ];
    }
}

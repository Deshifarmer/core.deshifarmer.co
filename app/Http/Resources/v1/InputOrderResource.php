<?php

namespace App\Http\Resources\v1;

use App\Models\v1\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\RouteUri;

class InputOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'order_id' => $this->order_id,
            'me_id' => $this->me_id,
            'channel_id' => $this->channel_id,
            'total_price' => $this->total_price,
            'sold_to' => $this->sold_to,
            'status' => $this->status,
            'payment_method'=> $this->payment_method,
            'payment_id' => $this->payment_id,
            'delivery_status' => $this->delivery_status,
            'hq_commission' => $this->hq_commission,
            'me_commission' => $this->me_commission,
            'distributor_commission' => $this->distributor_commission,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'order_details' => $this->when($request->routeIs('hq.single_input_order'), function () {
                return OrderResource::collection(Order::where('me_order_id', $this->order_id)->get());
            }),
           
        ];
    }
}

<?php

namespace App\Http\Resources\v1;

use App\Models\v1\Employee;
use App\Models\v1\Farmer;
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
            'payment_method' => $this->payment_method,
            'payment_id' => $this->payment_id,
            'delivery_status' => $this->delivery_status,
            'me_commission' => $this->me_commission,
            'distributor_commission' => $this->distributor_commission,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),


            'distributor_details' => $this->when($request->routeIs(
                [
                    'hq.single_input_order'
                ]
            ), function () {
                $distributor_details = Employee::where('df_id', $this->distributor_id)->get();
                return [
                    'distributor_name' => $distributor_details->implode('full_name'),
                    'distributor_phone' => $distributor_details->implode('phone'),
                ];
            }),
            'me_details' => $this->when($request->routeIs(
                [
                    'hq.single_input_order',
                    'distributor.me_new_order',
                    'distributor.me_confirm_order_status'
                ]
            ), function () {
                $me_details = Employee::where('df_id', $this->me_id)->get();
                return [
                    'me_name' => $me_details->implode('full_name'),
                    'me_phone' => $me_details->implode('phone'),
                ];
            }),
            'farmer_details' => $this->when($request->routeIs(
                [
                    'hq.single_input_order',
                    'me.me_order'
                ]
            ), function () {
                $farmer_details = Farmer::where('farmer_id', $this->sold_to)->get();
                return [
                    'farmer_name' => $farmer_details->implode('first_name') . ' ' . $farmer_details->implode('last_name'),
                    'farmer_phone' => $farmer_details->implode('phone'),
                    'farmer_address' => $farmer_details->implode('address'),
                ];
            }),
            'order_details' => $this->when($request->routeIs(
                [
                    'hq.single_input_order',
                    'me.me_order'
                ]
            ), function () {
                return OrderResource::collection(Order::where('me_order_id', $this->order_id)->get());
            }),

        ];
    }
}

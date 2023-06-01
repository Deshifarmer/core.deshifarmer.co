<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class FarmerDepositResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'deposit_id' => $this->deposit_id,
            'farmer_id' => $this->farmer_id,
            'amount' => $this->amount,
            'deposit_method' => $this->deposit_method,
            'deposit_status' => $this->deposit_status,
            'transaction_id' => $this->transaction_id,
            'which_input_order_id' => $this->which_input_order_id,
            'received_by' => $this->received_by,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}

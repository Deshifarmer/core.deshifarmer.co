<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OutputCustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'customer_id' => $this->customer_id,
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'onboard_by' => $this->onboard_by,
        ];
    }
}

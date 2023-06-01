<?php

namespace App\Http\Resources\v1;

use App\Models\v1\Order;
use App\Models\v1\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'name' => $this->name,
            'address' => $this->address,
            'contact_person_name' => $this->contact_person_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'order' => $this->whenAppended('order', function () {
                return Order::where('product_id', Product::where('company_id', $this->id)->get()->implode('product_id'))
                    ->where('status','pending')
                    ->get();
            })
        ];
    }
}

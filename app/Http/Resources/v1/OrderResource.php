<?php

namespace App\Http\Resources\v1;

use App\Models\v1\Distributors_file;
use App\Models\v1\Employee;
use App\Models\v1\Farmer;
use App\Models\v1\InputOrder;
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
            'distributor_name' => Employee::where('df_id', $this->distributor_id)->get()->implode('first_name') . ' ' . Employee::where('df_id', $this->distributor_id)->get()->implode('last_name'),
            'delivery_address' => Distributors_file::where('df_id', $this->distributor_id)->get()->implode('business_present_address'),
            'delivery_contact' => Distributors_file::where('df_id', $this->distributor_id)->get()->implode('business_contact_no'),
            'product_id' => $this->product_id,
            'product_details' => new ProductResource(Product::where('product_id', $this->product_id)->first()),
            'unit' =>Unit::where('id', $this->unit)->get()->implode('unit'),
            'quantity' => $this->quantity,
            'total_price'=>$this->total_price,
            'status'=>$this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'location' => $this->channel_id,
            'farmer_name'=> Farmer::where('farmer_id',InputOrder::where('order_id', $this->me_order_id)->first()->sold_to)->get()->implode('first_name') . ' ' . Farmer::where('farmer_id',InputOrder::where('order_id', $this->me_order_id)->first()->sold_to)->get()->implode('last_name'),
        ];
    }
}

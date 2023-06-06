<?php

namespace App\Http\Resources\v1;

use App\Models\v1\District;
use App\Models\v1\Division;
use App\Models\v1\InputOrder;
use App\Models\v1\Order;
use App\Models\v1\Upazila;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class FarmerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'farmer_id' => $this->farmer_id,
            'image'=>$this->image,
            'farmer_type' => $this->farmer_type,
            'input_by' => $this->input_by,
            'nid' => $this->nid,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => strtoupper("$this->first_name $this->last_name") ,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'address' => $this->address,
            'village' => $this->village,
            'upazila' => Upazila::where('id', $this->upazila)->get()->implode('name'),
            'district' => District::where('id', $this->district)->get()->implode('name'),
            'division' => Division::where('id', $this->division)->get()->implode('name'),
            'credit_score' => $this->credit_score,
            'land_status' => $this->land_status,
            'family_member' => $this->family_member,
            'number_of_children' => $this->number_of_children,
            'yearly_income' => $this->yearly_income,
            'year_of_stay_in' => $this->year_of_stay_in,
            'groyp_id' => $this->groyp_id,
            'farmer_role' => $this->farmer_role,
            'farm_id' => $this->farm_id,
            'is_active' => $this->is_active,
            // 'created_at' => $this->created_at->diffForHumans(),
            // 'updated_at' => $this->updated_at->diffForHumans(),

            'order_list' => InputOrderResource::collection(InputOrder::where('sold_to',$this->farmer_id)->get())
        ];
    }
}

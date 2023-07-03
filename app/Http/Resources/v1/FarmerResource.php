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
            'onboard_by' => $this->onboard_by,
            'nid' => $this->nid,
            'gov_farmer_id' => $this->gov_farmer_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'fathers_name' => $this->fathers_name,
            'phone' => $this->phone,
            'is_married' => $this->is_married,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'address' => $this->address,
            'village' => $this->village,
            'upazila' => Upazila::where('id', $this->upazila)->get()->implode('name'),
            'district' => District::where('id', $this->district)->get()->implode('name'),
            'division' => Division::where('id', $this->division)->get()->implode('name'),
            'credit_score' => $this->credit_score,
            'resident_type' => $this->resident_type,
            'land_status' => $this->land_status,
            'family_member' => $this->family_member,
            'number_of_children' => $this->number_of_children,
            'yearly_income' => $this->yearly_income,
            'year_of_stay_in' => $this->year_of_stay_in,
            'group_id' => $this->group_id,
            'bank_details' => $this->bank_details,
            'mfs_account' => $this->mfs_account,
            'current_producing_crop' => $this->current_producing_crop,
            'focused_crop' => $this->focused_crop,
            'cropping_intensity' => $this->cropping_intensity,
            'cultivation_practice' => $this->cultivation_practice,
            'farmer_role' => $this->farmer_role,
            'farm_id' => $this->farm_id,
            'is_active' => $this->is_active,
            'onboard_date' => $this->created_at->format('Y-m-d H:i:s'),
            // 'updated_at' => $this->updated_at->diffForHumans(),

            'order_list' => InputOrderResource::collection(InputOrder::where('sold_to',$this->farmer_id)->get())
        ];
    }
}

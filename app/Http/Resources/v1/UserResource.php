<?php

namespace App\Http\Resources\v1;

use App\Models\v1\District;
use App\Models\v1\Employee;
use App\Models\v1\EmployeeAccount;
use App\Models\v1\Farmer;
use App\Models\v1\InputOrder;
use App\Models\v1\Order;
use App\Models\v1\Product;
use App\Models\v1\Unit;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'df_id' => $this->df_id,
            'full_name' => $this->full_name,
            'nid' => $this->nid,
            'phone' => $this->phone,
            'email' => $this->email,
            'photo' => $this->photo,
            'channel' => $this->channel,
            'date_of_birth' => $this->date_of_birth,
            'present_address' => $this->present_address,
            'permanent_address' => $this->permanent_address,
            'home_district' => District::find($this->home_district)->name ?? null,
            'joining_date' => $this->joining_date,
            'type' => $this->type,
            'gender' => $this->gender,
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'status' => $this->status,
            'balance' => EmployeeAccount::where('acc_number', $this->df_id)->get('net_balance')->implode('net_balance'),

            'me_list' => $this->when($this->type == 2, function () {
                return Employee::where('under', $this->df_id)->get()->map(function ($employee) {
                    return [
                        'df_id' => $employee->df_id,
                        'full_name' => $employee->full_name,
                        'phone' => $employee->phone,
                        'email' => $employee->email,
                        'channel_assign_by' => $employee->channel_assign_by,
                        'status' => $employee->status,
                        'total_order' => InputOrder::where('me_id', $employee->df_id)->count(),
                        'total_order_amount' => InputOrder::where('me_id', $employee->df_id)->sum('total_price'),

                    ];
                });
            }),

            'farmer_list' => $this->when($this->type == 3, function () {
                return Farmer::where('input_by', $this->df_id)->get()->map(function ($farmer) {
                    return [
                        'farmer_id' => $farmer->farmer_id,
                        'full_name' => "$farmer->first_name $farmer->last_name",
                        'phone' => $farmer->phone,
                    ];
                });
            }),

            'product_list' => $this->when($this->type == 1, function () {
                return Product::where('company_id', $this->df_id)->get()->map(function ($product) {
                    return [
                        'product_id' => $product->product_id,
                        'product_name' =>$product->name,
                        'image' => $product->image,
                        'buy_price_from_company'=>$product->buy_price_from_company,
                        'sell_price_from_company'=>$product->sell_price_from_company
                    ];
                });
            }),
        ];
    }
}

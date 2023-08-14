<?php

namespace App\Http\Resources\v1;

use App\Models\v1\District;
use App\Models\v1\Division;
use App\Models\v1\Employee;
use App\Models\v1\EmployeeAccount;
use App\Models\v1\Farmer;
use App\Models\v1\InputOrder;
use App\Models\v1\Order;
use App\Models\v1\Product;
use App\Models\v1\Transaction;
use App\Models\v1\Unit;
use App\Models\v1\Upazila;
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
            'joining_date' => $this->created_at->format('Y-m-d H:i:s'),
            'balance' => EmployeeAccount::where('acc_number', $this->df_id)->get('net_balance')->implode('net_balance'),

            'under' => $this->when($this->type == 3, function () {
                return $this->under ?? null;
            }),


            'all_transaction' => $this->when(auth()->user()->type == 0 && $this->type == 2, function () {
                return Transaction::where('debited_from', $this->df_id)
                    ->orWhere('credited_to', $this->df_id)->sum('amount');
            }),

            'total_sale' => $this->when(auth()->user()->type == 0 && $this->type == 2, function () {
                return Order::where('distributor_id', $this->df_id)->sum('quantity');
            }),
            'balance' => $this->when(auth()->user()->type == 0 && $this->type == 2, function () {
                return EmployeeAccount::where('acc_number', $this->df_id)->get('net_balance')->implode('net_balance');
            }),


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
                        'total_farmer' => Farmer::where('onboard_by', $employee->df_id)->count(),

                    ];
                });
            }),

            'farmer_list' => $this->when($this->type == 3  && $request->routeIs('hq.profile.single_user') , function () {
                return Farmer::where('onboard_by', $this->df_id)->get()->map(function ($farmer) {
                    return [
                        'farmer_id' => $farmer->farmer_id,
                        "first_name" => $farmer->first_name,
                        "last_name" => $farmer->last_name,
                        'full_name' => "$farmer->first_name $farmer->last_name",
                        'phone' => $farmer->phone,
                        "gender" => $farmer->gender,
                        'image' => $farmer->image,
                        'created_at' => $farmer->created_at->diffForHumans(),
                        'gender' =>  $farmer->gender,
                        'date_of_birth' =>  $farmer->date_of_birth,
                        'address' =>  $farmer->address,
                        'village' =>  $farmer->village,
                        'upazila' => Upazila::where('id',  $farmer->upazila)->get()->implode('name'),
                        'district' => District::where('id',  $farmer->district)->get()->implode('name'),
                        'division' => Division::where('id',  $farmer->division)->get()->implode('name'),
                        'union' => $farmer->union,
                        'father_name' =>  $farmer->fathers_name,
                        'farm_area'=> $farmer->farm_area,
                    ];
                });
            }),
            'total_farmer' => $this->when($this->type == 3, function () {
                return Farmer::where('onboard_by', $this->df_id)->count();
            }),

            'total_product' => $this->when($this->type == 1, function () {
                return Product::where('company_id', $this->df_id)->count();
            }),

            'product_list' => $this->when($this->type == 1 && $request->routeIs('hq.profile.single_user'), function () {
                return Product::where('company_id', $this->df_id)->get()->map(function ($product) {
                    return [
                        'product_id' => $product->product_id,
                        'product_name' => $product->name,
                        'image' => $product->image,
                        'buy_price_from_company' => $product->buy_price_from_company,
                        'sell_price_from_company' => $product->sell_price_from_company
                    ];
                });
            }),

            'transaction' => $this->when($request->routeIs(['hq.profile.single_user']), function () {
                return TransactionResource::collection(
                    Transaction::where('credited_to', $this->df_id)
                        ->orWhere('debited_from', $this->df_id)
                        ->get()
                );
            }),
        ];
    }
}

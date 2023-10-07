<?php

namespace App\Http\Resources\v1;

use App\Models\v1\District;
use App\Models\v1\Division;
use App\Models\v1\Employee;
use App\Models\v1\InputOrder;
use App\Models\v1\Me;
use App\Models\v1\Upazila;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChannelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $district_id = Upazila::where('id', $this->upazila_id)->get()->implode('district_id');
        $division_id = District::where('id', $district_id)->get()->implode('division_id');
        return [
            'channel_name' => $this->channel_name,
            'division'=>Division::where('id',$division_id)->get()->implode('name'),
            'district'=>District::where('id',$district_id)->get()->implode('name'),
            'toatal_distributor' => Employee::where('channel', $this->channel_name)->where('type',2)->count(),
            'total_me' => Employee::where('channel', $this->channel_name)->where('type',3)->count(),
            'total_order'=>$this->when($request->routeIs('hq.all_channel'), function () {
                return InputOrder::where('channel_id',$this->channel_name)->count();
            }),
            'total_sales'=>InputOrder::where('channel_id',$this->channel_name)->where('status','collected by me')->sum('total_price'),

            'disrtibutor_list' => $this->when($request->routeIs('hq.single_channel'), function () {
                return Employee::where('type',2)
                ->where('channel',$this->channel_name)->get()->map(function ($employee) {
                    return [
                        'df_id' => $employee->df_id,
                        'full_name' => "$employee->first_name $employee->last_name",
                        'phone' => $employee->phone,
                        'email' => $employee->email,
                        'channel_assign_by' => $employee->channel_assign_by,
                        'status' => $employee->status,
                    ];
                });
            }),

            'me_list' => $this->when($request->routeIs('hq.single_channel'), function () {
                return Employee::where('type',3)
                ->where('channel',$this->channel_name)->get()->map(function ($employee) {
                    return [
                        'df_id' => $employee->df_id,
                        'full_name' => "$employee->first_name $employee->last_name",
                        'phone' => $employee->phone,
                        'email' => $employee->email,
                        'channel_assign_by' => $employee->channel_assign_by,
                        'status' => $employee->status,
                    ];
                });
            })

        ];
    }
}

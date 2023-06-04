<?php

namespace App\Http\Resources\v1;

use App\Models\v1\District;
use App\Models\v1\Employee;
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
            "full_name" => $this->full_name,
            'nid' => $this->nid,
            'phone' => $this->phone,
            'email' => $this->email,
            'designation' => $this->designation,
            'previous_designation' => $this->previous_designation,
            'previous_company' => $this->previous_company,
            'photo' => $this->photo,
            'channel'=> $this->channel,
            'date_of_birth' => $this->date_of_birth,
            'present_address' => $this->present_address,
            'permanent_address' => $this->permanent_address,
            'home_district' => District::find($this->home_district)->name ?? null,
            'joining_date' => $this->joining_date,
            'type' => $this->type,
            'gender' => $this->gender,
            'department' => $this->department,
            'work_place' => $this->work_place,
            'comission' => $this->comission,
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'target_volume' => $this->target_volume,

            'me_list' => $this->when($this->type == 2, function () {
                return Employee::where('under', $this->df_id)->get()->map(function ($employee) {
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
        ];
    }
}

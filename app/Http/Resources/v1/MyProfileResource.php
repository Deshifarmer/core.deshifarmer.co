<?php

namespace App\Http\Resources\v1;

use App\Models\v1\District;
use App\Models\v1\Employee;
use App\Models\v1\EmployeeAccount;
use App\Models\v1\InputOrder;
use App\Models\v1\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\Console\Input\Input;

class MyProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'df_id' => $this->df_id,
            'full_name' => $this->full_name,
            'nid' => $this->nid,
            'phone' => $this->phone,
            'email' => $this->email,
            'designation' => $this->designation,
            'previous_designation' => $this->previous_designation,
            'previous_company' => $this->previous_company,
            'photo' => $this->photo,
            'channel' => $this->channel,
            'date_of_birth' => $this->date_of_birth,
            'present_address' => $this->present_address,
            'permanent_address' => $this->permanent_address,
            'home_district' => District::find($this->home_district)->name ?? null,
            'joining_date' => $this->joining_date,
            'type' => $this->type,
            'gender' => $this->gender,
            'department' => $this->department,
            'work_place' => $this->work_place,
            'commission' => $this->commission,
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'target_volume' => $this->target_volume,
            'account_details' => EmployeeAccount::where('acc_number', $this->df_id)->get(),
            'transactions' => Transaction::where('credited_to', $this->df_id)
                ->orWhere('debited_from', $this->df_id)
                ->get(),
            'orders' => $this->when($request->routeIs('distributor.my_me_profile'), function () {
                return InputOrder::where('me_id', $this->df_id)->get();
            }),



        ];
    }
}

<?php

namespace App\Http\Resources\v1;

use App\Models\v1\Distributors_file;
use App\Models\v1\District;
use App\Models\v1\Employee;
use App\Models\v1\EmployeeAccount;
use App\Models\v1\Farmer;
use App\Models\v1\InputOrder;
use App\Models\v1\Order;
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
            'total_sale' => $this->when($request->routeIs('me.my_profile'), function () {
                return Order::where('me_id', $this->df_id)->count('quantity');
            }),
            'total_farmer' => $this->when($request->routeIs('me.my_profile'), function () {
                return Farmer::where('onboard_by', $this->df_id)->count();
            }),
            'distributors_files' => $this->when($request->routeIs('db.my_profile'), function () {
                if (Distributors_file::where('df_id', $this->df_id)->exists()) {
                    return Distributors_file::where('df_id', $this->df_id)->get();
                } else {
                    return "not a single file uploaded";
                }
            }),
            'total_me' => $this->when($request->routeIs('db.my_profile'), function () {
                return Employee::where('under', $this->df_id)->count();
            }),
            'this_month_earning' => $this->when($request->routeIs(['distributor.my_me_profile']), function () {
                return Transaction::where('credited_to', $this->df_id)
                    ->whereMonth('created_at', date('m'))
                    ->sum('amount');
            }),
            'lifetime_earning' => $this->when($request->routeIs(['distributor.my_me_profile']), function () {
                return Transaction::where('credited_to', $this->df_id)
                ->sum('amount');
            }),
            'this_month_total_sales' => $this->when($request->routeIs(['distributor.my_me_profile']), function () {
                return Order::where('me_id', $this->df_id)
                    ->whereMonth('created_at', date('m'))
                    ->count('quantity');
            }),
            'lifetime_total_sales' => $this->when($request->routeIs(['distributor.my_me_profile']), function () {
                return Order::where('me_id', $this->df_id)
                    ->count('quantity');
            }),

        ];
    }
}

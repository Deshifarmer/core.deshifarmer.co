<?php

namespace App\Http\Resources\v1;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
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
            'employee_id' => $this->employee_id,
            'employee_name' => User::where('df_id', $this->employee_id)->first()->first_name . ' ' . User::where('df_id', $this->employee_id)->first()->last_name,
            'check_in' => $this->check_in,
            'cin_note' => $this->cin_note,
            'cin_location' => $this->cin_location,
            'check_out' =>  $this->check_out,
            'cout_note' => $this->cout_note,
            'cout_location' => $this->cout_location,
        ];
    }
}

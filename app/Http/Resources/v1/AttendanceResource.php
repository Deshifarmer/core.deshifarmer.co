<?php

namespace App\Http\Resources\v1;

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
            'check_in' => Carbon::parse($this->check_in)->format('h:i:s A'),
            'cin_note' => $this->cin_note,
            'cin_location' => $this->cin_location,
            'check_out' =>  $this->check_out ? Carbon::parse($this->check_out)->format('h:i:s A') : null,
            'cout_note' => $this->cout_note,
            'cout_location' => $this->cout_location,
        ];
    }
}

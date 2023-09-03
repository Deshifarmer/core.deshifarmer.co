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
            'cin_note' => $this->cin_note,
            'check_in' => Carbon::parse($this->check_in)->format('h:i:s A'),
            'check_out' =>  Carbon::parse($this->check_in)->format('h:i:s A'),
            'cout_note' => $this->cout_note,
            
        ];
    }
}

<?php

namespace App\Http\Resources\v1;

use App\Models\v1\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DistributorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $distributor = Employee::where('deshifarmer_id', $this->deshifarmer_id);
        return [
            'id' => $this->id,
            'channel_id'=>$this->channel_id,
            'assign_by'=>$this->assign_by,
            'distributor_details' => Employee::where('deshifarmer_id', $this->deshifarmer_id)->get(),
        ];
    }
}

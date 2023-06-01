<?php

namespace App\Http\Resources\v1;

use App\Models\v1\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $me = Employee::where('deshifarmer_id', $this->deshifarmer_id)->get();
        return [
            'id' => $this->id,
            'channel_id'=>$this->channel_id,
            'assign_by'=>$this->assign_by,
            'me_details' => Employee::where('deshifarmer_id', $this->deshifarmer_id)->get(),
        ];
    }
}

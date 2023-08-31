<?php

namespace App\Http\Resources\v1;

use App\Models\v1\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $arr = [
            0 => 'HQ',
            1 => 'CO',
            2 => 'DB',
            3 => 'ME',
            4 => 'TM',
        ];

        return [
            'token' => $this->createToken($arr[$this->role])->plainTextToken,
            'full_name' => "$this->first_name $this->last_name",
            'df_id' => $this->df_id,
            'role' => $this->role,
        ];
    }
}

<?php

namespace App\Http\Resources\v1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CashInRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'receipt_id' => $this->receipt_id,
            'distributor' => new UserResource(User::where('df_id', $this->df_id)->first()),
            'amount' => $this->requested,
            'accepted_amount' => $this->accepted_amount,
            'receipt' => $this->receipt,
            'status' => $this->status,
            'created_at' => $this->created_at-> diffForHumans(),
            'updated_at' => $this->updated_at-> diffForHumans(),
        ];
    }
}

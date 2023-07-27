<?php

namespace App\Http\Resources\v1;

use App\Models\v1\Farmer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FarmerGroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'farmer_group_id' => $this->farmer_group_id,
            'farmer_group_name' => $this->farmer_group_name,
            'cluster_id' => $this->cluster_id,
            'isActive' => $this->isActive,
            'inactive_at' => $this->inactive_at,
            'group_manager_id' => $this->group_manager_id,
            'group_leader' => $this->group_leader,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'color' => $this->color,
            'total_farmers' => Farmer::where('group_id', $this->farmer_group_id)->count(),
            'farmer_list' => $this->when($request->routeIs('group.show'), function () {
                return FarmerResource::collection(Farmer::where('group_id', $this->farmer_group_id)
                    ->where('id', '!=', $this->group_manager_id)
                    ->get());
            }),
        ];
    }
}

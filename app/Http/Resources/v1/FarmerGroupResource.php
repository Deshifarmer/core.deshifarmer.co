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
            'group_leader' => GroupLeaderDetailsResource::make(Farmer::where('farmer_id', $this->group_leader)->first()),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'color' => $this->color,
            'total_farmers' => Farmer::where('group_id', $this->farmer_group_id)->count(),
            'member_pic' => Farmer::where('group_id', $this->farmer_group_id)->inRandomOrder()->limit(4)->get()->map(function ($farmer) {
                return $farmer->image;
            }),
            'farmer_list' => $this->when($request->routeIs(['group.show','farmer_group.show']), function () {
                return GroupLeaderDetailsResource::collection(Farmer::where('group_id', $this->farmer_group_id)
                    ->where('farmer_id', '!=', $this->group_leader)
                    ->get());
            }),
        ];
    }
}

<?php

namespace App\Http\Resources\v1;

use App\Models\v1\Activity;
use App\Models\v1\Fertilization;
use App\Models\v1\LandPreparation;
use App\Models\v1\Pesticide;
use App\Models\v1\Sourcing;
use App\Models\v1\Sowing;
use App\Models\v1\Watering;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'batch_id' => $this->batch_id,
            'season' => $this->season,
            'farm_id' => $this->farm_id,
            'which_crop' => $this->which_crop,
            'created_by' => $this->created_by,
            'land_preparation' => $this->when($request->routeIs(['hq.batch.show', 'me.batch.show']), function () {
                $lp =  LandPreparation::where('batch_id', $this->batch_id)->first();
                return  $lp ? LandPReparationResource::make($lp) : null;
            }),
            'sowing' => $this->when($request->routeIs(['hq.batch.show', 'me.batch.show']), function () {
                $sow =  Sowing::where('batch_id', $this->batch_id)->first();
                return  $sow ? SowingResource::make($sow) : null;
            }),
            'fertilization' => $this->when($request->routeIs(['hq.batch.show', 'me.batch.show']), function () {
                return Fertilization::where('batch_id', $this->batch_id)->first();
            }),
            'pesticide' => $this->when($request->routeIs(['hq.batch.show', 'me.batch.show']), function () {
                return Pesticide::where('batch_id', $this->batch_id)->first();
            }),
            'watering' => $this->when($request->routeIs(['hq.batch.show', 'me.batch.show']), function () {
                return Watering::where('batch_id', $this->batch_id)->first();
            }),
            'sourcing' => $this->when($request->routeIs(['hq.batch.show', 'me.batch.show']), function () {
                return SourcingResource::make(Sourcing::where('batch_id', $this->batch_id)->first());
            }),
        ];
    }
}

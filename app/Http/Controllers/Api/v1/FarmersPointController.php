<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\FarmersPointResource;
use App\Models\v1\FarmersPoint;
use Illuminate\Http\Request;

class FarmersPointController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return FarmersPointResource::collection(FarmersPoint::orderByDesc('id')
            ->paginate($this->perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['farmers_point_id'] = $this->generateUUID();
        $farmersPoint = FarmersPoint::create($input);
        // return $input['farmers_point_id'];
    }

    /**
     * Display the specified resource.
     */
    public function show(FarmersPoint $farmersPoint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FarmersPoint $farmersPoint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FarmersPoint $farmersPoint)
    {
        //
    }
}

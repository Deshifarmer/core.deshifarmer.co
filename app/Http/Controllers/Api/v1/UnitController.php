<?php

namespace App\Http\Controllers\Api\v1;


use Illuminate\Support\Facades\Validator;
use App\Http\Resources\v1\UnitResource;
use App\Models\v1\Unit;
use Illuminate\Http\Request;


class UnitController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UnitResource::collection(Unit::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
           'unit' => 'required|string|unique:units,unit',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }
        $unit = Unit::create($request->all());
        return new UnitResource($unit);

    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        //
    }
}

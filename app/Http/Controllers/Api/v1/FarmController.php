<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\Farm;
use Illuminate\Http\Request;

class FarmController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Farm::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['farm_id'] ='Farm-'.$this->generateUUID();
        $farm = Farm::create($data);
        return response()->json($farm, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Farm $farm)
    {
        return $farm;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Farm $farm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Farm $farm)
    {
        //
    }
}

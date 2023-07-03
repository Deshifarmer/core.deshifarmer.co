<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\FarmerGroup;
use Illuminate\Http\Request;

class FarmerGroupController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return FarmerGroup::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data =$request->all();
        $data['farmer_group_id'] ='FG-' . $this->generateUUID();
        $farmerGroup = FarmerGroup::create($data);
        return response()->json($farmerGroup, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(FarmerGroup $farmerGroup)
    {
      return $farmerGroup;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FarmerGroup $farmerGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FarmerGroup $farmerGroup)
    {
        //
    }
}

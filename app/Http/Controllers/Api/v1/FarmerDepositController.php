<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\FarmerDepositResource;
use App\Models\v1\FarmerDeposit;
use Illuminate\Http\Request;

class FarmerDepositController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return FarmerDepositResource::collection(FarmerDeposit::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data =  $request->all();
        $data['deposit_id'] = 'dep-' . $this->generateUUID();
        $farmerDeposit = FarmerDeposit::create($data);
        return new FarmerDepositResource($farmerDeposit);

    }

    /**
     * Display the specified resource.
     */
    public function show(FarmerDeposit $farmerDeposit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FarmerDeposit $farmerDeposit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FarmerDeposit $farmerDeposit)
    {
        //
    }
}

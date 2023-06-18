<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\DistributorInfoResource;
use App\Http\Resources\v1\EmployeeResource;
use App\Models\v1\Channel;
use App\Models\v1\DistributorInfo;
use App\Models\v1\Employee;
use Illuminate\Http\Request;

class DiostributorInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return DistributorInfoResource::collection(DistributorInfo::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $distributorInfo = DistributorInfo::create($data);
        return new DistributorInfoResource($distributorInfo);
    }

    /**
     * Display the specified resource.
     */
    public function show(DistributorInfo $distributorInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DistributorInfo $distributorInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DistributorInfo $distributorInfo)
    {
        //
    }


}

<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\DistributorResource;
use App\Http\Resources\v1\EmployeeResource;
use App\Models\v1\Distributor;
use App\Models\v1\Employee;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return EmployeeResource::collection(Employee::where('employee_type', 4)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request['employee_type'] = 4;
        // $result = (new EmployeeController)->store($request);
        // $getContent =json_decode($result->getContent());
        //  if($getContent->{'code'} == 404){
        //     return $result;
        //  }

        // $data['deshifarmer_id'] =$getContent->{'data'}->{'deshifarmer_id'};
        // $data['channel_id'] = $request->channel_id;
        // $data['assign_by'] = 'shuvo';
        // $me = Distributor::create($data);

        // return new DistributorResource($me);
    }

    public function addDistributorTochannel(Request $request) {
        $data = $request->all();
        $data['assign_by'] = 'shuvo';
        $me = Distributor::create($data);
        return new DistributorResource($me);
    }

    /**
     * Display the specified resource.
     */
    public function show(Distributor $distributor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Distributor $distributor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Distributor $distributor)
    {
        //
    }

    public function myMe(Distributor $distributor)
    {
        // return EmployeeResource::collection(Employee::where('employee_type', 5)->where('channel_id', $distributor->channel_id)->get());
        return EmployeeResource::collection(Employee::all());
    }
}

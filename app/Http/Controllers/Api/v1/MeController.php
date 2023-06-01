<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\EmployeeResource;
use App\Http\Resources\v1\FarmerResource;
use App\Http\Resources\v1\MeResource;
use App\Models\v1\Employee;
use App\Models\v1\Farmer;
use App\Models\v1\Me;
use Illuminate\Http\Request;


class MeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return ::collection(Employee::where('employee_type', 5)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request['employee_type'] = 5;
        // $result = (new EmployeeController)->store($request);
        // $getContent =json_decode($result->getContent());
        //  if($getContent->{'code'} == 404){
        //     return $result;
        //  }

        // $data['deshifarmer_id'] =$getContent->{'data'}->{'deshifarmer_id'};
        // $data['channel_id'] = $request->channel_id;
        // $data['assign_by'] = 'shuvo';
        // $me = Me::create($data);

        // return new MeResource($me);
    }

    /**
     * Display the specified resource.
     */
    public function show(me $me)
    {
       return new MeResource($me);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, me $me)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(me $me)
    {
        //
    }

    public function myFarmer()
    {
        return FarmerResource::collection(Farmer::where('input_by', auth()->user()->df_id)->get()) ;
    }
}

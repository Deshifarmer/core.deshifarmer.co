<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ChannelResource;
use App\Http\Resources\v1\UpazilaResource;
use App\Models\v1\Channel;
use App\Models\v1\Employee;
use App\Models\v1\Upazila;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChannelController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ChannelResource::collection(Channel::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['channel_name'] = Upazila::where('id', $request->upazila_id)->get()->implode('name');

        $validator = Validator::make($input, [
            'channel_name' => 'required|unique:channels',
            'distributor_id' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'channel_name' => 'Channel Already Exist',
            ], 409);
        }
        foreach ($request->distributor_id as $key => $value) {

            $employee = Employee::where('df_id', $value);
            $alreadyAssign = $employee->get('channel')->implode('channel');

            if ($alreadyAssign != null) {
                return response()->json([
                    'message' => $value . ' ' . 'This Distributor Already Assign',
                    'status' => 'error',
                ], 422);
            } else {
                (new EmployeeController)->update(
                    new Request(
                        [
                            'channel' => $input['channel_name'],
                            'channel_assign_by' => auth()->user()->df_id,
                        ]
                    ),
                    Employee::where('df_id', $value)->first()
                );
            }
        }

        $channel = Channel::create($input);
        return new ChannelResource($channel);
    }


    public function assign(Request $request, channel $channel)
    {

        foreach ($request->list as $key => $value) {
            $employee = Employee::where('df_id', $value);
            $alreadyAssign = $employee->get('channel')->implode('channel');

            if ($alreadyAssign != null) {
                return response()->json([
                    'message' => $value . ' ' . 'This Distributor Already Assign',
                    'status' => 'error',
                ], 422);
            } else {
                (new EmployeeController)->update(
                    new Request(
                        [
                            'channel' => $channel->channel_name,
                            'channel_assign_by' => auth()->user()->df_id,
                        ]
                    ),
                    Employee::where('df_id', $value)->first()
                );
            }

        }
        return response()->json([
            'message' => 'Assign Successfully',
            'status' => 'success',
        ], 200);
    }
    public function assignMe(Request $request, channel $channel)
    {
        foreach ($request->list as $key => $value) {
            $employee = Employee::where('df_id', $value);
            $alreadyAssign = $employee->get('channel')->implode('channel');

            if ($alreadyAssign != null) {
                return response()->json([
                    'message' => $value . ' ' . 'This Micro-Entrepreneurs Already Assign',
                    'status' => 'error',
                ], 422);
            } else {
                (new EmployeeController)->update(
                    new Request(
                        [
                            'channel' => Employee::where('df_id',$request->under )->get('channel')->implode('channel'),
                            'channel_assign_by' => auth()->user()->df_id,
                            'under'=>$request->under,
                        ]
                    ),
                    Employee::where('df_id', $value)->first()
                );
            }

        }
        return response()->json([
            'message' => 'Assign Successfully',
            'status' => 'success',
        ], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(channel $channel)
    {
        return new ChannelResource($channel);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, channel $channel)
    {
        $channel->update($request->all());
        return new ChannelResource($channel);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(channel $channel)
    {
        //
    }
}
